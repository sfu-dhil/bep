<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\PrintSource;
use App\Form\PrintSourceType;
use App\Repository\PrintSourceRepository;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/print_source")
 */
class PrintSourceController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * @Route("/", name="print_source_index", methods={"GET"})
     */
    public function index(Request $request, PrintSourceRepository $printSourceRepository) : Response {
        $query = $printSourceRepository->indexQuery();
        $pageSize = (int) $this->getParameter('page_size');
        $page = $request->query->getint('page', 1);

        return $this->render('print_source/index.html.twig', [
            'print_sources' => $this->paginator->paginate($query, $page, $pageSize),
        ]);
    }

    /**
     * @Route("/search", name="print_source_search", methods={"GET"})
     */
    public function search(Request $request, PrintSourceRepository $printSourceRepository) : Response {
        $q = $request->query->get('q');
        if ($q) {
            $query = $printSourceRepository->searchQuery($q);
            $printSources = $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), [
                'wrap-queries' => true,
            ]);
        } else {
            $printSources = [];
        }

        return $this->render('print_source/search.html.twig', [
            'print_sources' => $printSources,
            'q' => $q,
        ]);
    }

    /**
     * @Route("/typeahead", name="print_source_typeahead", methods={"GET"})
     */
    public function typeahead(Request $request, PrintSourceRepository $printSourceRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];
        foreach ($printSourceRepository->typeaheadQuery($q)->execute() as $result) {
            // @var PrintSource $result
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="print_source_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_CONTENT_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $em) : Response {
        $printSource = new PrintSource();
        $form = $this->createForm(PrintSourceType::class, $printSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($printSource);
            $em->flush();
            $this->addFlash('success', 'The new printSource has been saved.');

            return $this->redirectToRoute('print_source_show', ['id' => $printSource->getId()]);
        }

        return $this->render('print_source/new.html.twig', [
            'print_source' => $printSource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new_popup", name="print_source_new_popup", methods={"GET", "POST"})
     * @IsGranted("ROLE_CONTENT_ADMIN")
     */
    public function new_popup(Request $request, EntityManagerInterface $em) : Response {
        return $this->new($request, $em);
    }

    /**
     * @Route("/{id}", name="print_source_show", methods={"GET"})
     */
    public function show(PrintSource $printSource) : Response {
        return $this->render('print_source/show.html.twig', [
            'print_source' => $printSource,
        ]);
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="print_source_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PrintSource $printSource, EntityManagerInterface $em) : Response {
        $form = $this->createForm(PrintSourceType::class, $printSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'The updated printSource has been saved.');

            return $this->redirectToRoute('print_source_show', ['id' => $printSource->getId()]);
        }

        return $this->render('print_source/edit.html.twig', [
            'print_source' => $printSource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}", name="print_source_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PrintSource $printSource, EntityManagerInterface $em) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $printSource->getId(), $request->request->get('_token'))) {
            $em->remove($printSource);
            $em->flush();
            $this->addFlash('success', 'The printSource has been deleted.');
        } else {
            $this->addFlash('warning', 'The security token was not valid.');
        }

        return $this->redirectToRoute('print_source_index');
    }
}
