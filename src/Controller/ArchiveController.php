<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\Archive;
use App\Form\ArchiveType;
use App\Repository\ArchiveRepository;
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
 * @Route("/archive")
 */
class ArchiveController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="archive_index", methods={"GET"})
     *
     * @Template
     */
    public function index(Request $request, ArchiveRepository $archiveRepository) : array {
        $query = $archiveRepository->indexQuery();
        $pageSize = (int) $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return [
            'archives' => $this->paginator->paginate($query, $page, $pageSize),
        ];
    }

    /**
     * @Route("/search", name="archive_search", methods={"GET"})
     *
     * @Template
     *
     * @return array
     */
    public function search(Request $request, ArchiveRepository $archiveRepository) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $archiveRepository->searchQuery($q);
            $archives = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]);
        } else {
            $archives = [];
        }

        return [
            'archives' => $archives,
            'q' => $q,
        ];
    }

    /**
     * @Route("/typeahead", name="archive_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, ArchiveRepository $archiveRepository) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($archiveRepository->typeaheadQuery($q) as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="archive_new", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new(Request $request, LinkManager $linkManager) {
        $archive = new Archive();
        $form = $this->createForm(ArchiveType::class, $archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($archive);
            $entityManager->flush();

            $linkManager->setLinks($archive, $form->get('links')->getData());
            $entityManager->flush();

            $this->addFlash('success', 'The new archive has been saved.');

            return $this->redirectToRoute('archive_show', ['id' => $archive->getId()]);
        }

        return [
            'archive' => $archive,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/new_popup", name="archive_new_popup", methods={"GET", "POST"})
     * @Template
     * @IsGranted("ROLE_CONTENT_ADMIN")
     *
     * @return array|RedirectResponse
     */
    public function new_popup(Request $request, LinkManager $linkManager) {
        return $this->new($request, $linkManager);
    }

    /**
     * @Route("/{id}", name="archive_show", methods={"GET"})
     * @Template
     *
     * @return array
     */
    public function show(Archive $archive) {
        return [
            'archive' => $archive,
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="archive_edit", methods={"GET", "POST"})
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Archive $archive, LinkManager $linkManager) {
        $form = $this->createForm(ArchiveType::class, $archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $linkManager->setLinks($archive, $form->get('links')->getData());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The updated archive has been saved.');

            return $this->redirectToRoute('archive_show', ['id' => $archive->getId()]);
        }

        return [
            'archive' => $archive,
            'form' => $form->createView(),
        ];
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="archive_delete", methods={"DELETE"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Archive $archive) {
        if ($this->isCsrfTokenValid('delete' . $archive->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($archive);
            $entityManager->flush();
            $this->addFlash('success', 'The archive has been deleted.');
        }

        return $this->redirectToRoute('archive_index');
    }
}
