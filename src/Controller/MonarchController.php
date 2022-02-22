<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\Monarch;
use App\Form\MonarchType;
use App\Repository\MonarchRepository;

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
 * @Route("/monarch")
 */
class MonarchController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="monarch_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, MonarchRepository $monarchRepository) : array {
        $query = $monarchRepository->indexQuery();
        $pageSize = (int) $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'monarchs' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="monarch_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, MonarchRepository $monarchRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $monarchRepository->searchQuery($q);
            $monarchs = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $monarchs = [];
        }

        return [
            'monarchs' => $monarchs,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="monarch_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, MonarchRepository $monarchRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];
        foreach ($monarchRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="monarch_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $monarch = new Monarch();
        $form = $this->createForm(MonarchType::class, $monarch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($monarch);
            $entityManager->flush();
            $this->addFlash('success', 'The new monarch has been saved.');

            return $this->redirectToRoute('monarch_show', ['id' => $monarch->getId()]);
        }

        return [
            'monarch' => $monarch,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="monarch_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="monarch_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(Monarch $monarch) {
        return [
            'monarch' => $monarch,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="monarch_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Monarch $monarch) {
        $form = $this->createForm(MonarchType::class, $monarch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated monarch has been saved.');

            return $this->redirectToRoute('monarch_show', ['id' => $monarch->getId()]);
        }

        return [
            'monarch' => $monarch,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="monarch_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Monarch $monarch) {
        if ($this->isCsrfTokenValid('delete' . $monarch->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($monarch);
            $entityManager->flush();
            $this->addFlash('success', 'The monarch has been deleted.');
        }

        return $this->redirectToRoute('monarch_index');
    }
}
