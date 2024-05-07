<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Injunction;
use App\Form\InjunctionType;
use App\Repository\InjunctionRepository;
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

#[Route(path: '/injunction')]
class InjunctionController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'injunction_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, InjunctionRepository $injunctionRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $injunctionRepository->searchQuery($q) : $injunctionRepository->indexQuery();

        return [
            'injunctions' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'injunction_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, InjunctionRepository $injunctionRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];
        foreach ($injunctionRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'injunction_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $injunction = new Injunction();
        $form = $this->createForm(InjunctionType::class, $injunction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($injunction);
            $entityManager->flush();
            $this->addFlash('success', 'The new injunction has been saved.');

            return $this->redirectToRoute('injunction_show', ['id' => $injunction->getId()]);
        }

        return [
            'injunction' => $injunction,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'injunction_show', methods: ['GET'])]
    #[Template]
    public function show(Injunction $injunction) : ?array {
        return [
            'injunction' => $injunction,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'injunction_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Injunction $injunction) : array|RedirectResponse {
        $form = $this->createForm(InjunctionType::class, $injunction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated injunction has been saved.');

            return $this->redirectToRoute('injunction_show', ['id' => $injunction->getId()]);
        }

        return [
            'injunction' => $injunction,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'injunction_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Injunction $injunction) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $injunction->getId(), $request->request->get('_token'))) {
            $entityManager->remove($injunction);
            $entityManager->flush();
            $this->addFlash('success', 'The injunction has been deleted.');
        }

        return $this->redirectToRoute('injunction_index');
    }
}
