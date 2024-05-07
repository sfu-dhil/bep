<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Archive;
use App\Form\ArchiveType;
use App\Repository\ArchiveRepository;
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

#[Route(path: '/archive')]
class ArchiveController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'archive_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, ArchiveRepository $archiveRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $archiveRepository->searchQuery($q) : $archiveRepository->indexQuery();

        return [
            'archives' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'archive_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, ArchiveRepository $archiveRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($archiveRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'archive_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $archive = new Archive();
        $form = $this->createForm(ArchiveType::class, $archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($archive);
            $entityManager->flush();

            $this->addFlash('success', 'The new archive has been saved.');

            return $this->redirectToRoute('archive_show', ['id' => $archive->getId()]);
        }

        return [
            'archive' => $archive,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'archive_show', methods: ['GET'])]
    #[Template]
    public function show(Archive $archive) : array {
        return [
            'archive' => $archive,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'archive_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Archive $archive) : array|RedirectResponse {
        $form = $this->createForm(ArchiveType::class, $archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated archive has been saved.');

            return $this->redirectToRoute('archive_show', ['id' => $archive->getId()]);
        }

        return [
            'archive' => $archive,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'archive_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Archive $archive) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $archive->getId(), $request->request->get('_token'))) {
            $entityManager->remove($archive);
            $entityManager->flush();
            $this->addFlash('success', 'The archive has been deleted.');
        }

        return $this->redirectToRoute('archive_index');
    }
}
