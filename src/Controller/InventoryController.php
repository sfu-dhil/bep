<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Inventory;
use App\Form\InventoryType;
use App\Repository\InventoryRepository;
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

#[Route(path: '/inventory')]
class InventoryController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;
    use ImageControllerTrait;

    #[Route(path: '/', name: 'inventory_index', methods: ['GET'])]
    #[Template('inventory/index.html.twig')]
    public function index(Request $request, InventoryRepository $inventoryRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $inventoryRepository->searchQuery($q) : $inventoryRepository->indexQuery();

        return [
            'inventories' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/new', name: 'inventory_new', methods: ['GET', 'POST'])]
    #[Template('inventory/new.html.twig')]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $inventory = new Inventory();
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inventory);
            $entityManager->flush();
            $this->addFlash('success', 'The new inventory has been saved.');

            return $this->redirectToRoute('inventory_show', ['id' => $inventory->getId()]);
        }

        return [
            'inventory' => $inventory,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'inventory_show', methods: ['GET'])]
    #[Template('inventory/show.html.twig')]
    public function show(Inventory $inventory) : ?array {
        return [
            'inventory' => $inventory,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'inventory_edit', methods: ['GET', 'POST'])]
    #[Template('inventory/edit.html.twig')]
    public function edit(EntityManagerInterface $entityManager, Request $request, Inventory $inventory) : array|RedirectResponse {
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated inventory has been saved.');

            return $this->redirectToRoute('inventory_show', ['id' => $inventory->getId()]);
        }

        return [
            'inventory' => $inventory,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'inventory_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Inventory $inventory) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $inventory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($inventory);
            $entityManager->flush();
            $this->addFlash('success', 'The inventory has been deleted.');
        }

        return $this->redirectToRoute('inventory_index');
    }

    #[Route(path: '/{id}/image/new', name: 'inventory_image_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Template('inventory/image_new.html.twig')]
    public function newImage(Request $request, EntityManagerInterface $em, Inventory $inventory) : array|RedirectResponse {
        return $this->newImageAction($request, $em, $inventory, 'inventory_show', ['id' => $inventory->getId()]);
    }

    #[Route(path: '/{id}/image/{image_id}/edit', name: 'inventory_image_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Template('inventory/image_edit.html.twig')]
    #[ParamConverter('image', options: ['id' => 'image_id'])]
    public function editImage(Request $request, EntityManagerInterface $em, Inventory $inventory, Image $image) : array|RedirectResponse {
        return $this->editImageAction($request, $em, $inventory, $image, 'inventory_show', ['id' => $inventory->getId()]);
    }

    #[Route(path: '/{id}/image/{image_id}', name: 'inventory_image_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[ParamConverter('image', options: ['id' => 'image_id'])]
    public function deleteImage(Request $request, EntityManagerInterface $em, Inventory $inventory, Image $image) : RedirectResponse {
        return $this->deleteImageAction($request, $em, $inventory, $image, 'inventory_show', ['id' => $inventory->getId()]);
    }
}
