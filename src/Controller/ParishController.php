<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Parish;
use App\Form\ParishType;
use App\Repository\ParishRepository;
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

#[Route(path: '/parish')]
class ParishController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'parish_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, ParishRepository $parishRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $parishRepository->searchQuery($q) : $parishRepository->indexQuery();

        return [
            'parishes' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'parish_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, ParishRepository $parishRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($parishRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'parish_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $parish = new Parish();
        $form = $this->createForm(ParishType::class, $parish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parish);
            $entityManager->flush();

            $this->addFlash('success', 'The new parish has been saved.');

            return $this->redirectToRoute('parish_show', ['id' => $parish->getId()]);
        }

        return [
            'parish' => $parish,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'parish_show', methods: ['GET'])]
    #[Template]
    public function show(Parish $parish) : array {
        return [
            'parish' => $parish,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'parish_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Parish $parish) : array|RedirectResponse {
        $form = $this->createForm(ParishType::class, $parish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated parish has been saved.');

            return $this->redirectToRoute('parish_show', ['id' => $parish->getId()]);
        }

        return [
            'parish' => $parish,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'parish_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Parish $parish) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $parish->getId(), $request->request->get('_token'))) {
            $entityManager->remove($parish);
            $entityManager->flush();
            $this->addFlash('success', 'The parish has been deleted.');
        }

        return $this->redirectToRoute('parish_index');
    }
}
