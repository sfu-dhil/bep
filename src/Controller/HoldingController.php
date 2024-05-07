<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Holding;
use App\Form\HoldingType;
use App\Repository\HoldingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\MediaBundle\Controller\ImageControllerTrait;
use Nines\MediaBundle\Entity\Image;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/holding')]
class HoldingController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;
    use ImageControllerTrait;

    #[Route(path: '/', name: 'holding_index', methods: ['GET'])]
    #[Template('holding/index.html.twig')]
    public function index(Request $request, HoldingRepository $holdingRepository) : array {
        $query = $holdingRepository->indexQuery();

        return [
            'holdings' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
        ];
    }

    #[Route(path: '/new', name: 'holding_new', methods: ['GET', 'POST'])]
    #[Template('holding/new.html.twig')]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $holding = new Holding();
        $form = $this->createForm(HoldingType::class, $holding);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($holding);
            $entityManager->flush();
            $this->addFlash('success', 'The new surviving text has been saved.');

            return $this->redirectToRoute('holding_show', ['id' => $holding->getId()]);
        }

        return [
            'holding' => $holding,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'holding_show', methods: ['GET'])]
    #[Template('holding/show.html.twig')]
    public function show(Holding $holding) : array {
        return [
            'holding' => $holding,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'holding_edit', methods: ['GET', 'POST'])]
    #[Template('holding/edit.html.twig')]
    public function edit(EntityManagerInterface $entityManager, Request $request, Holding $holding) : array|RedirectResponse {
        $form = $this->createForm(HoldingType::class, $holding);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated surviving text has been saved.');

            return $this->redirectToRoute('holding_show', ['id' => $holding->getId()]);
        }

        return [
            'holding' => $holding,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'holding_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Holding $holding) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $holding->getId(), $request->request->get('_token'))) {
            $entityManager->remove($holding);
            $entityManager->flush();
            $this->addFlash('success', 'The surviving text has been deleted.');
        }

        return $this->redirectToRoute('holding_index');
    }

    #[Route(path: '/{id}/image/new', name: 'holding_image_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Template('holding/image_new.html.twig')]
    public function newImage(Request $request, EntityManagerInterface $em, Holding $holding) : array|RedirectResponse {
        return $this->newImageAction($request, $em, $holding, 'holding_show', ['id' => $holding->getId()]);
    }

    #[Route(path: '/{id}/image/{image_id}/edit', name: 'holding_image_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Template('holding/image_edit.html.twig')]
    #[ParamConverter('image', options: ['id' => 'image_id'])]
    public function editImage(Request $request, EntityManagerInterface $em, Holding $holding, Image $image) : array|RedirectResponse {
        return $this->editImageAction($request, $em, $holding, $image, 'holding_show', ['id' => $holding->getId()]);
    }

    #[Route(path: '/{id}/image/{image_id}', name: 'holding_image_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[ParamConverter('image', options: ['id' => 'image_id'])]
    public function deleteImage(Request $request, EntityManagerInterface $em, Holding $holding, Image $image) : RedirectResponse {
        return $this->deleteImageAction($request, $em, $holding, $image, 'holding_show', ['id' => $holding->getId()]);
    }
}
