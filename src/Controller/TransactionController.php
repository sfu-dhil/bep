<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/transaction')]
class TransactionController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'transaction_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, TransactionRepository $transactionRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $transactionRepository->searchQuery($q) : $transactionRepository->indexQuery();

        return [
            'transactions' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/new', name: 'transaction_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transaction);
            $entityManager->flush();
            $this->addFlash('success', 'The new transaction has been saved.');

            return $this->redirectToRoute('transaction_show', ['id' => $transaction->getId()]);
        }

        return [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to copy a transaction.
     */
    #[Route(path: '/{id}/copy', name: 'transaction_copy', methods: ['GET'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function copy(Transaction $transaction, EntityManagerInterface $em) : array {
        $form = $this->createForm(TransactionType::class, $transaction, [
            'action' => $this->generateUrl('transaction_new'),
        ]);

        return [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'transaction_show', methods: ['GET'])]
    #[Template]
    public function show(Transaction $transaction) : ?array {
        return [
            'transaction' => $transaction,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'transaction_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Transaction $transaction) : array|RedirectResponse {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated transaction has been saved.');

            return $this->redirectToRoute('transaction_show', ['id' => $transaction->getId()]);
        }

        return [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'transaction_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Transaction $transaction) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $transaction->getId(), $request->request->get('_token'))) {
            $entityManager->remove($transaction);
            $entityManager->flush();
            $this->addFlash('success', 'The transaction has been deleted.');
        }

        return $this->redirectToRoute('transaction_index');
    }
}
