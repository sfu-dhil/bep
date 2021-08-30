<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\County;
use App\Form\CountyType;
use App\Repository\CountyRepository;
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
 * @Route("/county")
 */
class CountyController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="county_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, CountyRepository $countyRepository) : array {
        $query = $countyRepository->indexQuery();
        $pageSize = $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'counties' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="county_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, CountyRepository $countyRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $countyRepository->searchQuery($q);
            $counties = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $counties = [];
        }

        return [
            'counties' => $counties,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="county_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, CountyRepository $countyRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($countyRepository->typeaheadQuery($q) as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="county_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $county = new County();
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($county);
            $entityManager->flush();

            $this->addFlash('success', 'The new county has been saved.');

            return $this->redirectToRoute('county_show', ['id' => $county->getId()]);
        }

        return [
            'county' => $county,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="county_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="county_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(County $county) {
        return [
            'county' => $county,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="county_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, County $county) {
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated county has been saved.');

            return $this->redirectToRoute('county_show', ['id' => $county->getId()]);
        }

        return [
            'county' => $county,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="county_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, County $county) {
        if ($this->isCsrfTokenValid('delete' . $county->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($county);
            $entityManager->flush();
            $this->addFlash('success', 'The county has been deleted.');
        }

        return $this->redirectToRoute('county_index');
    }
}
