<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\SourceCategory;
use App\Form\SourceCategoryType;
use App\Repository\SourceCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/source_category')]
class SourceCategoryController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'source_category_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, SourceCategoryRepository $sourceCategoryRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $sourceCategoryRepository->searchQuery($q) : $sourceCategoryRepository->indexQuery();

        return [
            'source_categories' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'source_category_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, SourceCategoryRepository $sourceCategoryRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($sourceCategoryRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'source_category_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $sourceCategory = new SourceCategory();
        $form = $this->createForm(SourceCategoryType::class, $sourceCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    #[Route(path: '/{id}', name: 'source_category_show', methods: ['GET'])]
    #[Template]
    public function show(SourceCategory $sourceCategory) : array {
        return [
            'source_category' => $sourceCategory,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'source_category_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, SourceCategory $sourceCategory) : array|RedirectResponse {
        $form = $this->createForm(SourceCategoryType::class, $sourceCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated sourceCategory has been saved.');

            return $this->redirectToRoute('source_category_show', ['id' => $sourceCategory->getId()]);
        }

        return [
            'source_category' => $sourceCategory,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'source_category_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, SourceCategory $sourceCategory) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $sourceCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sourceCategory);
            $entityManager->flush();
            $this->addFlash('success', 'The sourceCategory has been deleted.');
        }

        return $this->redirectToRoute('source_category_index');
    }
}
