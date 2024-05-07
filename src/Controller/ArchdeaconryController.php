<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Archdeaconry;
use App\Form\ArchdeaconryType;
use App\Repository\ArchdeaconryRepository;
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

#[Route(path: '/archdeaconry')]
class ArchdeaconryController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'archdeaconry_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, ArchdeaconryRepository $archdeaconryRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $archdeaconryRepository->searchQuery($q) : $archdeaconryRepository->indexQuery();

        return [
            'archdeaconries' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size')),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'archdeaconry_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, ArchdeaconryRepository $archdeaconryRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($archdeaconryRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'archdeaconry_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $archdeaconry = new Archdeaconry();
        $form = $this->createForm(ArchdeaconryType::class, $archdeaconry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($archdeaconry);
            $entityManager->flush();

            $this->addFlash('success', 'The new archdeaconry has been saved.');

            return $this->redirectToRoute('archdeaconry_show', ['id' => $archdeaconry->getId()]);
        }

        return [
            'archdeaconry' => $archdeaconry,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'archdeaconry_show', methods: ['GET'])]
    #[Template]
    public function show(Archdeaconry $archdeaconry) : array {
        return [
            'archdeaconry' => $archdeaconry,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'archdeaconry_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Archdeaconry $archdeaconry) : array|RedirectResponse {
        $form = $this->createForm(ArchdeaconryType::class, $archdeaconry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated archdeaconry has been saved.');

            return $this->redirectToRoute('archdeaconry_show', ['id' => $archdeaconry->getId()]);
        }

        return [
            'archdeaconry' => $archdeaconry,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'archdeaconry_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Archdeaconry $archdeaconry) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $archdeaconry->getId(), $request->request->get('_token'))) {
            $entityManager->remove($archdeaconry);
            $entityManager->flush();
            $this->addFlash('success', 'The archdeaconry has been deleted.');
        }

        return $this->redirectToRoute('archdeaconry_index');
    }
}
