<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\SourceCategory;
use App\Form\SourceCategoryType;
use App\Repository\SourceCategoryRepository;
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
 * @Route("/source_category")
 */
class SourceCategoryController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="source_category_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, SourceCategoryRepository $sourceCategoryRepository) : array {
        $query = $sourceCategoryRepository->indexQuery();
        $pageSize = (int) $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'source_categories' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="source_category_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, SourceCategoryRepository $sourceCategoryRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $sourceCategoryRepository->searchQuery($q);
            $sourceCategories = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $sourceCategories = [];
        }

        return [
            'source_categories' => $sourceCategories,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="source_category_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, SourceCategoryRepository $sourceCategoryRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($sourceCategoryRepository->typeaheadQuery($q) as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="source_category_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $sourceCategory = new SourceCategory();
        $form = $this->createForm(SourceCategoryType::class, $sourceCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sourceCategory);
            $entityManager->flush();
            $this->addFlash('success', 'The new sourceCategory has been saved.');

            return $this->redirectToRoute('source_category_show', ['id' => $sourceCategory->getId()]);
        }

        return [
            'source_category' => $sourceCategory,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="source_category_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="source_category_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(SourceCategory $sourceCategory) {
        return [
            'source_category' => $sourceCategory,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="source_category_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, SourceCategory $sourceCategory) {
        $form = $this->createForm(SourceCategoryType::class, $sourceCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated sourceCategory has been saved.');

            return $this->redirectToRoute('source_category_show', ['id' => $sourceCategory->getId()]);
        }

        return [
            'source_category' => $sourceCategory,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="source_category_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, SourceCategory $sourceCategory) {
        if ($this->isCsrfTokenValid('delete' . $sourceCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sourceCategory);
            $entityManager->flush();
            $this->addFlash('success', 'The sourceCategory has been deleted.');
        }

        return $this->redirectToRoute('source_category_index');
    }
}
