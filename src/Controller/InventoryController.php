<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\Inventory;
use App\Form\InventoryType;
use App\Repository\InventoryRepository;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inventory")
 */
class InventoryController extends AbstractController implements PaginatorAwareInterface
{
    use PaginatorTrait;

    /**
     * @Route("/", name="inventory_index", methods={"GET"})
     *
     * @Template
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
     * @Route("/new", name="inventory_new", methods={"GET", "POST"})
     * @Template
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
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="inventory_show", methods={"GET"})
     * @Template
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
     * @Template
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
}
