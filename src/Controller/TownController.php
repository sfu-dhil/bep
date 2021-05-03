<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\Town;
use App\Form\TownType;
use App\Repository\TownRepository;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\MediaBundle\Service\LinkManager;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/town")
 */
class TownController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="town_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, TownRepository $townRepository) : array {
        $query = $townRepository->indexQuery();
        $pageSize = $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'towns' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="town_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, TownRepository $townRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $townRepository->searchQuery($q);
            $towns = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $towns = [];
        }

        return [
            'towns' => $towns,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="town_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, TownRepository $townRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($townRepository->typeaheadQuery($q) as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="town_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request, LinkManager $linkManager) {
        $town = new Town();
        $form = $this->createForm(TownType::class, $town);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($town);
            $entityManager->flush();

            $linkManager->setLinks($town, $form->get('links')->getData());
            $entityManager->flush();

            $this->addFlash('success', 'The new town has been saved.');

            return $this->redirectToRoute('town_show', ['id' => $town->getId()]);
        }

        return [
            'town' => $town,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="town_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request, LinkManager $linkManager) {
        return $this->new($request, $linkManager);
    }

    /**
     * @Route("/{id}", name="town_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(Town $town) {
        return [
            'town' => $town,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="town_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Town $town, LinkManager $linkManager) {
        $form = $this->createForm(TownType::class, $town);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $linkManager->setLinks($town, $form->get('links')->getData());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated town has been saved.');

            return $this->redirectToRoute('town_show', ['id' => $town->getId()]);
        }

        return [
            'town' => $town,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="town_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Town $town) {
        if ($this->isCsrfTokenValid('delete' . $town->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($town);
            $entityManager->flush();
            $this->addFlash('success', 'The town has been deleted.');
        }

        return $this->redirectToRoute('town_index');
    }
}
