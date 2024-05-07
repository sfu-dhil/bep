<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Town;
use App\Form\TownType;
use App\Repository\TownRepository;
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

#[Route(path: '/town')]
class TownController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'town_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, TownRepository $townRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $townRepository->searchQuery($q) : $townRepository->indexQuery();

        return [
            'towns' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'town_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, TownRepository $townRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($townRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'town_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $town = new Town();
        $form = $this->createForm(TownType::class, $town);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($town);
            $entityManager->flush();

            $this->addFlash('success', 'The new town has been saved.');

            return $this->redirectToRoute('town_show', ['id' => $town->getId()]);
        }

        return [
            'town' => $town,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'town_show', methods: ['GET'])]
    #[Template]
    public function show(Town $town) : array {
        return [
            'town' => $town,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'town_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Town $town) : array|RedirectResponse {
        $form = $this->createForm(TownType::class, $town);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated town has been saved.');

            return $this->redirectToRoute('town_show', ['id' => $town->getId()]);
        }

        return [
            'town' => $town,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'town_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Town $town) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $town->getId(), $request->request->get('_token'))) {
            $entityManager->remove($town);
            $entityManager->flush();
            $this->addFlash('success', 'The town has been deleted.');
        }

        return $this->redirectToRoute('town_index');
    }
}
