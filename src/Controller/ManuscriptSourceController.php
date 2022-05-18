<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\ManuscriptSource;
use App\Form\ManuscriptSourceType;
use App\Repository\ManuscriptSourceRepository;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/manuscript_source")
 */
class ManuscriptSourceController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="manuscript_source_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, ManuscriptSourceRepository $manuscriptSourceRepository) : array {
        $query = $manuscriptSourceRepository->indexQuery();
        $pageSize = (int) $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'sources' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="manuscript_source_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, ManuscriptSourceRepository $manuscriptSourceRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $manuscriptSourceRepository->searchQuery($q);
            $manuscriptSources = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $manuscriptSources = [];
        }

        return [
            'sources' => $manuscriptSources,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="manuscript_source_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, ManuscriptSourceRepository $manuscriptSourceRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($manuscriptSourceRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="manuscript_source_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $manuscriptSource = new ManuscriptSource();
        $form = $this->createForm(ManuscriptSourceType::class, $manuscriptSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manuscriptSource);
            $entityManager->flush();

            $this->addFlash('success', 'The new source has been saved.');

            return $this->redirectToRoute('manuscript_source_show', ['id' => $manuscriptSource->getId()]);
        }

        return [
            'source' => $manuscriptSource,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="manuscript_source_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="manuscript_source_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(ManuscriptSource $manuscriptSource) {
        return [
            'source' => $manuscriptSource,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="manuscript_source_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, ManuscriptSource $manuscriptSource) {
        $form = $this->createForm(ManuscriptSourceType::class, $manuscriptSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated source has been saved.');

            return $this->redirectToRoute('manuscript_source_show', ['id' => $manuscriptSource->getId()]);
        }

        return [
            'source' => $manuscriptSource,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="manuscript_source_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, ManuscriptSource $manuscriptSource) {
        if ($this->isCsrfTokenValid('delete' . $manuscriptSource->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($manuscriptSource);
            $entityManager->flush();
            $this->addFlash('success', 'The source has been deleted.');
        }

        return $this->redirectToRoute('manuscript_source_index');
    }
}
