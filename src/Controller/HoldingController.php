<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

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

/**
 * @Route("/holding")
 */
class HoldingController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;
    use ImageControllerTrait;

    /**
     * @Route("/", name="holding_index", methods={"GET"})
     *
     * @Template(template="holding/index.html.twig")
     */
    public function index(Request $request, HoldingRepository $holdingRepository) : array {
        $query = $holdingRepository->indexQuery();
        $pageSize = (int) $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'holdings' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/new", name="holding_new", methods={"GET", "POST"})
     * @Template(template="holding/new.html.twig")
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $holding = new Holding();
        $form = $this->createForm(HoldingType::class, $holding);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
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

    /**
     * @Route("/new_popup", name="holding_new_popup", methods={"GET", "POST"})
     * @Template(template="holding/new_popup.html.twig")
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="holding_show", methods={"GET"})
     * @Template(template="holding/show.html.twig")
     *
     * @return array
     */
    public function show(Holding $holding) {
        return [
            'holding' => $holding,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="holding_edit", methods={"GET", "POST"})
     *
     * @Template(template="holding/edit.html.twig")
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Holding $holding) {
        $form = $this->createForm(HoldingType::class, $holding);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated surviving text has been saved.');

            return $this->redirectToRoute('holding_show', ['id' => $holding->getId()]);
        }

        return [
            'holding' => $holding,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="holding_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Holding $holding) {
        if ($this->isCsrfTokenValid('delete' . $holding->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($holding);
            $entityManager->flush();
            $this->addFlash('success', 'The surviving text has been deleted.');
        }

        return $this->redirectToRoute('holding_index');
    }

    /**
     * @Route("/{id}/new_image", name="holding_new_image", methods={"GET", "POST"})
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @Template("holding/new_image.html.twig")
     */
    public function newImage(Request $request, EntityManagerInterface $em, holding $holding) {
        return $this->newImageAction($request, $em, $holding, 'holding_show');
    }

    /**
     * @Route("/{id}/edit_image/{image_id}", name="holding_edit_image", methods={"GET", "POST"})
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @ParamConverter("image", options={"id": "image_id"})
     *
     * @Template("holding/edit_image.html.twig")
     */
    public function editImage(Request $request, EntityManagerInterface $em, holding $holding, Image $image) {
        return $this->editImageAction($request, $em, $holding, $image, 'holding_show');
    }

    /**
     * @Route("/{id}/delete_image/{image_id}", name="holding_delete_image", methods={"DELETE"})
     * @ParamConverter("image", options={"id": "image_id"})
     * @IsGranted("ROLE_CONTENT_ADMIN")
     */
    public function deleteImage(Request $request, EntityManagerInterface $em, holding $holding, Image $image) {
        return $this->deleteImageAction($request, $em, $holding, $image, 'holding_show');
    }
}
