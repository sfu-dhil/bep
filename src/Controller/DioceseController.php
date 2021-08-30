<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\Diocese;
use App\Form\DioceseType;
use App\Repository\DioceseRepository;
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
 * @Route("/diocese")
 */
class DioceseController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="diocese_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, DioceseRepository $dioceseRepository) : array {
        $query = $dioceseRepository->indexQuery();
        $pageSize = $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'dioceses' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="diocese_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, DioceseRepository $dioceseRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $dioceseRepository->searchQuery($q);
            $dioceses = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $dioceses = [];
        }

        return [
            'dioceses' => $dioceses,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="diocese_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, DioceseRepository $dioceseRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($dioceseRepository->typeaheadQuery($q) as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="diocese_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $diocese = new Diocese();
        $form = $this->createForm(DioceseType::class, $diocese);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($diocese);
            $entityManager->flush();

            $this->addFlash('success', 'The new diocese has been saved.');

            return $this->redirectToRoute('diocese_show', ['id' => $diocese->getId()]);
        }

        return [
            'diocese' => $diocese,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="diocese_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="diocese_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(Diocese $diocese) {
        return [
            'diocese' => $diocese,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="diocese_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Diocese $diocese) {
        $form = $this->createForm(DioceseType::class, $diocese);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated diocese has been saved.');

            return $this->redirectToRoute('diocese_show', ['id' => $diocese->getId()]);
        }

        return [
            'diocese' => $diocese,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="diocese_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Diocese $diocese) {
        if ($this->isCsrfTokenValid('delete' . $diocese->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($diocese);
            $entityManager->flush();
            $this->addFlash('success', 'The diocese has been deleted.');
        }

        return $this->redirectToRoute('diocese_index');
    }
}
