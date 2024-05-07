<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Diocese;
use App\Form\DioceseType;
use App\Repository\DioceseRepository;
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

#[Route(path: '/diocese')]
class DioceseController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'diocese_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, DioceseRepository $dioceseRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $dioceseRepository->searchQuery($q) : $dioceseRepository->indexQuery();

        return [
            'dioceses' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'diocese_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, DioceseRepository $dioceseRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($dioceseRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'diocese_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $diocese = new Diocese();
        $form = $this->createForm(DioceseType::class, $diocese);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($diocese);
            $entityManager->flush();

            $this->addFlash('success', 'The new diocese has been saved.');

            return $this->redirectToRoute('diocese_show', ['id' => $diocese->getId()]);
        }

        return [
            'diocese' => $diocese,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'diocese_show', methods: ['GET'])]
    #[Template]
    public function show(Diocese $diocese) : array {
        return [
            'diocese' => $diocese,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'diocese_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Diocese $diocese) : array|RedirectResponse {
        $form = $this->createForm(DioceseType::class, $diocese);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated diocese has been saved.');

            return $this->redirectToRoute('diocese_show', ['id' => $diocese->getId()]);
        }

        return [
            'diocese' => $diocese,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'diocese_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Diocese $diocese) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $diocese->getId(), $request->request->get('_token'))) {
            $entityManager->remove($diocese);
            $entityManager->flush();
            $this->addFlash('success', 'The diocese has been deleted.');
        }

        return $this->redirectToRoute('diocese_index');
    }
}
