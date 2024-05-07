<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Province;
use App\Form\ProvinceType;
use App\Repository\ProvinceRepository;
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

#[Route(path: '/province')]
class ProvinceController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'province_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, ProvinceRepository $provinceRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $provinceRepository->searchQuery($q) : $provinceRepository->indexQuery();

        return [
            'provinces' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'province_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, ProvinceRepository $provinceRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($provinceRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'province_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $province = new Province();
        $form = $this->createForm(ProvinceType::class, $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($province);
            $entityManager->flush();

            $this->addFlash('success', 'The new province has been saved.');

            return $this->redirectToRoute('province_show', ['id' => $province->getId()]);
        }

        return [
            'province' => $province,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'province_show', methods: ['GET'])]
    #[Template]
    public function show(Province $province) : array {
        return [
            'province' => $province,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'province_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Province $province) : array|RedirectResponse {
        $form = $this->createForm(ProvinceType::class, $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated province has been saved.');

            return $this->redirectToRoute('province_show', ['id' => $province->getId()]);
        }

        return [
            'province' => $province,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'province_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Province $province) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $province->getId(), $request->request->get('_token'))) {
            $entityManager->remove($province);
            $entityManager->flush();
            $this->addFlash('success', 'The province has been deleted.');
        }

        return $this->redirectToRoute('province_index');
    }
}
