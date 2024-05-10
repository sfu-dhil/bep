<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\TransactionCategory;
use App\Form\TransactionCategoryType;
use App\Repository\TransactionCategoryRepository;
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

#[Route(path: '/transaction_category')]
class TransactionCategoryController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'transaction_category_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, TransactionCategoryRepository $transactionCategoryRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $transactionCategoryRepository->searchQuery($q) : $transactionCategoryRepository->indexQuery();

        return [
            'transaction_categories' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'transaction_category_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, TransactionCategoryRepository $transactionCategoryRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($transactionCategoryRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'transaction_category_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $transactionCategory = new TransactionCategory();
        $form = $this->createForm(TransactionCategoryType::class, $transactionCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transactionCategory);
            $entityManager->flush();
            $this->addFlash('success', 'The new transactionCategory has been saved.');

            return $this->redirectToRoute('transaction_category_show', ['id' => $transactionCategory->getId()]);
        }

        return [
            'transaction_category' => $transactionCategory,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'transaction_category_show', methods: ['GET'])]
    #[Template]
    public function show(TransactionCategory $transactionCategory) : array {
        return [
            'transaction_category' => $transactionCategory,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'transaction_category_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, TransactionCategory $transactionCategory) : array|RedirectResponse {
        $form = $this->createForm(TransactionCategoryType::class, $transactionCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated transactionCategory has been saved.');

            return $this->redirectToRoute('transaction_category_show', ['id' => $transactionCategory->getId()]);
        }

        return [
            'transaction_category' => $transactionCategory,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'transaction_category_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, TransactionCategory $transactionCategory) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $transactionCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($transactionCategory);
            $entityManager->flush();
            $this->addFlash('success', 'The transactionCategory has been deleted.');
        }

        return $this->redirectToRoute('transaction_category_index');
    }
}
