<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

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

/**
 * @Route("/transaction")
 */
class TransactionController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="transaction_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, TransactionRepository $transactionRepository) : array {
        $query = $transactionRepository->indexQuery();
        $pageSize = $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'transactions' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="transaction_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, TransactionRepository $transactionRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $transactionRepository->searchQuery($q);
            $transactions = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $transactions = [];
        }

        return [
            'transactions' => $transactions,
            'q' => $q,
        ];
    }

    /**
     * @Route("/new", name="transaction_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
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
     *
     * @Route("/{id}/copy", name="transaction_copy", methods={"GET"})
     * @Template
     * @isGranted("ROLE_CONTENT_ADMIN")
     */
    public function copy(Request $request, Transaction $transaction, EntityManagerInterface $em) : array {
        $form = $this->createForm(TransactionType::class, $transaction, [
            'action' => $this->generateUrl('transaction_new'),
        ]);

        return [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="transaction_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="transaction_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(Transaction $transaction) {
        return [
            'transaction' => $transaction,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="transaction_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Transaction $transaction) {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated transaction has been saved.');

            return $this->redirectToRoute('transaction_show', ['id' => $transaction->getId()]);
        }

        return [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="transaction_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Transaction $transaction) {
        if ($this->isCsrfTokenValid('delete' . $transaction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transaction);
            $entityManager->flush();
            $this->addFlash('success', 'The transaction has been deleted.');
        }

        return $this->redirectToRoute('transaction_index');
    }
}
