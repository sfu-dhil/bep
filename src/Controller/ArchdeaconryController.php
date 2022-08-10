<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\Archdeaconry;
use App\Form\ArchdeaconryType;
use App\Repository\ArchdeaconryRepository;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/archdeaconry")
 */
class ArchdeaconryController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="archdeaconry_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, ArchdeaconryRepository $archdeaconryRepository) : array {
        $query = $archdeaconryRepository->indexQuery();
        $pageSize = $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'archdeaconries' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="archdeaconry_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, ArchdeaconryRepository $archdeaconryRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $archdeaconryRepository->searchQuery($q);
            $archdeaconries = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $archdeaconries = [];
        }

        return [
            'archdeaconries' => $archdeaconries,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="archdeaconry_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, ArchdeaconryRepository $archdeaconryRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($archdeaconryRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="archdeaconry_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request) {
        $archdeaconry = new Archdeaconry();
        $form = $this->createForm(ArchdeaconryType::class, $archdeaconry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($archdeaconry);
            $entityManager->flush();

            $this->addFlash('success', 'The new archdeaconry has been saved.');

            return $this->redirectToRoute('archdeaconry_show', ['id' => $archdeaconry->getId()]);
        }

        return [
            'archdeaconry' => $archdeaconry,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="archdeaconry_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request) {
        return $this->new($request);
    }

    /**
     * @Route("/{id}", name="archdeaconry_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(Archdeaconry $archdeaconry) {
        return [
            'archdeaconry' => $archdeaconry,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="archdeaconry_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Archdeaconry $archdeaconry) {
        $form = $this->createForm(ArchdeaconryType::class, $archdeaconry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated archdeaconry has been saved.');

            return $this->redirectToRoute('archdeaconry_show', ['id' => $archdeaconry->getId()]);
        }

        return [
            'archdeaconry' => $archdeaconry,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="archdeaconry_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Archdeaconry $archdeaconry) {
        if ($this->isCsrfTokenValid('delete' . $archdeaconry->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($archdeaconry);
            $entityManager->flush();
            $this->addFlash('success', 'The archdeaconry has been deleted.');
        }

        return $this->redirectToRoute('archdeaconry_index');
    }
}
