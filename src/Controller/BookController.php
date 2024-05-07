<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
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

#[Route(path: '/book')]
class BookController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'book_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, BookRepository $bookRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $bookRepository->searchQuery($q) : $bookRepository->indexQuery();

        return [
            'books' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'book_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, BookRepository $bookRepository) : JsonResponse {
        $q = $request->query->get('q');
        if (( ! $q) || (mb_strlen($q) < 4)) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($bookRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => implode(', ', array_map(fn ($s) => '"' . $s . '"', array_merge([$result->getTitle()], $result->getVariantTitles()))),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'book_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success', 'The new book has been saved.');

            return $this->redirectToRoute('book_show', ['id' => $book->getId()]);
        }

        return [
            'book' => $book,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'book_show', methods: ['GET'])]
    #[Template]
    public function show(Book $book) : array {
        return [
            'book' => $book,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'book_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Book $book) : array|RedirectResponse {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated book has been saved.');

            return $this->redirectToRoute('book_show', ['id' => $book->getId()]);
        }

        return [
            'book' => $book,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'book_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Book $book) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
            $this->addFlash('success', 'The book has been deleted.');
        }

        return $this->redirectToRoute('book_index');
    }
}
