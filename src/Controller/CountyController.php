<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\County;
use App\Form\CountyType;
use App\Repository\CountyRepository;
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

#[Route(path: '/county')]
class CountyController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'county_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, CountyRepository $countyRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $countyRepository->searchQuery($q) : $countyRepository->indexQuery();

        return [
            'counties' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'county_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, CountyRepository $countyRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($countyRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'county_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $county = new County();
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($county);
            $entityManager->flush();

            $this->addFlash('success', 'The new county has been saved.');

            return $this->redirectToRoute('county_show', ['id' => $county->getId()]);
        }

        return [
            'county' => $county,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'county_show', methods: ['GET'])]
    #[Template]
    public function show(County $county) : array {
        return [
            'county' => $county,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'county_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, County $county) : array|RedirectResponse {
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated county has been saved.');

            return $this->redirectToRoute('county_show', ['id' => $county->getId()]);
        }

        return [
            'county' => $county,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'county_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, County $county) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $county->getId(), $request->request->get('_token'))) {
            $entityManager->remove($county);
            $entityManager->flush();
            $this->addFlash('success', 'The county has been deleted.');
        }

        return $this->redirectToRoute('county_index');
    }
}
