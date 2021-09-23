<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\Inventory;
use App\Form\InventoryType;
use App\Repository\InventoryRepository;
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

/**
 * @Route("/inventory")
 */
class InventoryController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    use ImageControllerTrait;

    /**
     * @Route("/", name="inventory_index", methods={"GET"})
     *
     * @Template(template="inventory/index.html.twig")
     */
    public function index(Request $request, InventoryRepository $inventoryRepository) : array {
        $query = $inventoryRepository->indexQuery();
        $pageSize = (int) $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'inventories' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="inventory_search", methods={"GET"})
     *
     * @Template(template="inventory/search.html.twig")
     *
     * @return array
     */
    public function search(Request $request, InventoryRepository $inventoryRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $inventoryRepository->searchQuery($q);
            $inventories = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $inventories = [];
        }

        return [
            'inventories' => $inventories,
            'q' => $q,
        ];
    }

    /**
     * @Route("/new", name="inventory_new", methods={"GET", "POST"})
     * @Template(template="inventory/new.html.twig")
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $inventory = new Inventory();
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
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

    /**
     * @Route("/new_popup", name="inventory_new_popup", methods={"GET", "POST"})
     * @Template(template="inventory/new_popup.html.twig")
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="inventory_show", methods={"GET"})
     * @Template(template="inventory/show.html.twig")
     *
     * @return array
     */
    public function show(Inventory $inventory) {
        return [
            'inventory' => $inventory,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="inventory_edit", methods={"GET", "POST"})
     *
     * @Template(template="inventory/edit.html.twig")
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Inventory $inventory) {
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated inventory has been saved.');

            return $this->redirectToRoute('inventory_show', ['id' => $inventory->getId()]);
        }

        return [
            'inventory' => $inventory,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="inventory_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Inventory $inventory) {
        if ($this->isCsrfTokenValid('delete' . $inventory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inventory);
            $entityManager->flush();
            $this->addFlash('success', 'The inventory has been deleted.');
        }

        return $this->redirectToRoute('inventory_index');
    }

    /**
     * @Route("/{id}/new_image", name="inventory_new_image", methods={"GET", "POST"})
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @Template(template="@NinesMedia/image/new.html.twig")
     */
    public function newImage(Request $request, Inventory $inventory) {
        return $this->newImageAction($request, $inventory, 'inventory_show');
    }

    /**
     * @Route("/{id}/edit_image/{image_id}", name="inventory_edit_image", methods={"GET", "POST"})
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @ParamConverter("image", options={"id": "image_id"})
     *
     * @Template(template="@NinesMedia/image/edit.html.twig")
     */
    public function editImage(Request $request, Inventory $inventory, Image $image) {
        return $this->editImageAction($request, $inventory, $image, 'inventory_show');
    }

    /**
     * @Route("/{id}/delete_image/{image_id}", name="inventory_delete_image", methods={"DELETE"})
     * @ParamConverter("image", options={"id": "image_id"})
     * @IsGranted("ROLE_CONTENT_ADMIN")
     */
    public function deleteImage(Request $request, Inventory $inventory, Image $image) {
        return $this->deleteImageAction($request, $inventory, $image, 'inventory_show');
    }
}
