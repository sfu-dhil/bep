<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\Injunction;
use App\Form\InjunctionType;
use App\Repository\InjunctionRepository;

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
 * @Route("/injunction")
 */
class InjunctionController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="injunction_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, InjunctionRepository $injunctionRepository) : array {
        $query = $injunctionRepository->indexQuery();
        $pageSize = (int) $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'injunctions' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="injunction_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, InjunctionRepository $injunctionRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $injunctionRepository->searchQuery($q);
            $injunctions = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $injunctions = [];
        }

        return [
            'injunctions' => $injunctions,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="injunction_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, InjunctionRepository $injunctionRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];
        foreach ($injunctionRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="injunction_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $injunction = new Injunction();
        $form = $this->createForm(InjunctionType::class, $injunction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($injunction);
            $entityManager->flush();
            $this->addFlash('success', 'The new injunction has been saved.');

            return $this->redirectToRoute('injunction_show', ['id' => $injunction->getId()]);
        }

        return [
            'injunction' => $injunction,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="injunction_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="injunction_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(Injunction $injunction) {
        return [
            'injunction' => $injunction,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="injunction_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Injunction $injunction) {
        $form = $this->createForm(InjunctionType::class, $injunction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated injunction has been saved.');

            return $this->redirectToRoute('injunction_show', ['id' => $injunction->getId()]);
        }

        return [
            'injunction' => $injunction,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="injunction_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Injunction $injunction) {
        if ($this->isCsrfTokenValid('delete' . $injunction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($injunction);
            $entityManager->flush();
            $this->addFlash('success', 'The injunction has been deleted.');
        }

        return $this->redirectToRoute('injunction_index');
    }
}
