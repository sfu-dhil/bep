<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\Parish;
use App\Form\ParishType;
use App\Repository\ParishRepository;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\MediaBundle\Service\LinkManager;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parish")
 */
class ParishController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="parish_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, ParishRepository $parishRepository) : array {
        $query = $parishRepository->indexQuery();
        $pageSize = $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'parishes' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="parish_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, ParishRepository $parishRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $parishRepository->searchQuery($q);
            $parishes = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $parishes = [];
        }

        return [
            'parishes' => $parishes,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="parish_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, ParishRepository $parishRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($parishRepository->typeaheadQuery($q) as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="parish_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request, LinkManager $linkManager) {
        $parish = new Parish();
        $form = $this->createForm(ParishType::class, $parish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parish);
            $entityManager->flush();

            $linkManager->setLinks($parish, $form->get('links')->getData());
            $entityManager->flush();

            $this->addFlash('success', 'The new parish has been saved.');

            return $this->redirectToRoute('parish_show', ['id' => $parish->getId()]);
        }

        return [
            'parish' => $parish,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="parish_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request, LinkManager $linkManager) {
        return $this->new($request, $linkManager);
    }

    /**
     * @Route("/{id}", name="parish_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(Parish $parish) {
        return [
            'parish' => $parish,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="parish_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Parish $parish, LinkManager $linkManager) {
        $form = $this->createForm(ParishType::class, $parish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $linkManager->setLinks($parish, $form->get('links')->getData());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated parish has been saved.');

            return $this->redirectToRoute('parish_show', ['id' => $parish->getId()]);
        }

        return [
            'parish' => $parish,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="parish_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Parish $parish) {
        if ($this->isCsrfTokenValid('delete' . $parish->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($parish);
            $entityManager->flush();
            $this->addFlash('success', 'The parish has been deleted.');
        }

        return $this->redirectToRoute('parish_index');
    }
}
