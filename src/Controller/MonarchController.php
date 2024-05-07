<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Monarch;
use App\Form\MonarchType;
use App\Repository\MonarchRepository;
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

#[Route(path: '/monarch')]
class MonarchController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'monarch_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, MonarchRepository $monarchRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $monarchRepository->searchQuery($q) : $monarchRepository->indexQuery();

        return [
            'monarchs' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'monarch_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, MonarchRepository $monarchRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];
        foreach ($monarchRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'monarch_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $monarch = new Monarch();
        $form = $this->createForm(MonarchType::class, $monarch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($monarch);
            $entityManager->flush();
            $this->addFlash('success', 'The new monarch has been saved.');

            return $this->redirectToRoute('monarch_show', ['id' => $monarch->getId()]);
        }

        return [
            'monarch' => $monarch,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'monarch_show', methods: ['GET'])]
    #[Template]
    public function show(Monarch $monarch) : array {
        return [
            'monarch' => $monarch,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'monarch_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Monarch $monarch) : array|RedirectResponse {
        $form = $this->createForm(MonarchType::class, $monarch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated monarch has been saved.');

            return $this->redirectToRoute('monarch_show', ['id' => $monarch->getId()]);
        }

        return [
            'monarch' => $monarch,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'monarch_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Monarch $monarch) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $monarch->getId(), $request->request->get('_token'))) {
            $entityManager->remove($monarch);
            $entityManager->flush();
            $this->addFlash('success', 'The monarch has been deleted.');
        }

        return $this->redirectToRoute('monarch_index');
    }
}
