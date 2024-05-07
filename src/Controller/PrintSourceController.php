<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\PrintSource;
use App\Form\PrintSourceType;
use App\Repository\PrintSourceRepository;

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

#[Route(path: '/print_source')]
class PrintSourceController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'print_source_index', methods: ['GET'])]
    #[Template('print_source/index.html.twig')]
    public function index(Request $request, PrintSourceRepository $printSourceRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $printSourceRepository->searchQuery($q) : $printSourceRepository->indexQuery();

        return [
            'print_sources' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'print_source_typeahead', methods: ['GET'])]
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

    #[Route(path: '/new', name: 'print_source_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Template('print_source/new.html.twig')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $printSource = new PrintSource();
        $form = $this->createForm(PrintSourceType::class, $printSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($printSource);
            $entityManager->flush();
            $this->addFlash('success', 'The new printSource has been saved.');

            return $this->redirectToRoute('print_source_show', ['id' => $printSource->getId()]);
        }

        return [
            'print_source' => $printSource,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'print_source_show', methods: ['GET'])]
    #[Template('print_source/show.html.twig')]
    public function show(PrintSource $printSource) : array {
        return [
            'print_source' => $printSource,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'print_source_edit', methods: ['GET', 'POST'])]
    #[Template('print_source/edit.html.twig')]
    public function edit(EntityManagerInterface $entityManager, Request $request, PrintSource $printSource) : array|RedirectResponse {
        $form = $this->createForm(PrintSourceType::class, $printSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated printSource has been saved.');

            return $this->redirectToRoute('print_source_show', ['id' => $printSource->getId()]);
        }

        return [
            'print_source' => $printSource,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'print_source_delete', methods: ['DELETE'])]
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
