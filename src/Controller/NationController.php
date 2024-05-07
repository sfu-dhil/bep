<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Nation;
use App\Form\NationType;
use App\Repository\NationRepository;
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

#[Route(path: '/nation')]
class NationController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'nation_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, NationRepository $nationRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $nationRepository->searchQuery($q) : $nationRepository->indexQuery();

        return [
            'nations' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'nation_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, NationRepository $nationRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($nationRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'nation_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $nation = new Nation();
        $form = $this->createForm(NationType::class, $nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nation);
            $entityManager->flush();
            $this->addFlash('success', 'The new nation has been saved.');

            return $this->redirectToRoute('nation_show', ['id' => $nation->getId()]);
        }

        return [
            'nation' => $nation,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'nation_show', methods: ['GET'])]
    #[Template]
    public function show(Nation $nation) : array {
        return [
            'nation' => $nation,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'nation_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Nation $nation) : array|RedirectResponse {
        $form = $this->createForm(NationType::class, $nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated nation has been saved.');

            return $this->redirectToRoute('nation_show', ['id' => $nation->getId()]);
        }

        return [
            'nation' => $nation,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'nation_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Nation $nation) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $nation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nation);
            $entityManager->flush();
            $this->addFlash('success', 'The nation has been deleted.');
        }

        return $this->redirectToRoute('nation_index');
    }
}
