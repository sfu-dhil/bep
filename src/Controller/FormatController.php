<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Format;
use App\Form\FormatType;
use App\Repository\FormatRepository;
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

#[Route(path: '/format')]
class FormatController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'format_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, FormatRepository $formatRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $formatRepository->searchQuery($q) : $formatRepository->indexQuery();

        return [
            'formats' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'format_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, FormatRepository $formatRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($formatRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'format_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $format = new Format();
        $form = $this->createForm(FormatType::class, $format);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($format);
            $entityManager->flush();
            $this->addFlash('success', 'The new format has been saved.');

            return $this->redirectToRoute('format_show', ['id' => $format->getId()]);
        }

        return [
            'format' => $format,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'format_show', methods: ['GET'])]
    #[Template]
    public function show(Format $format) : array {
        return [
            'format' => $format,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'format_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, Format $format) : array|RedirectResponse {
        $form = $this->createForm(FormatType::class, $format);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated format has been saved.');

            return $this->redirectToRoute('format_show', ['id' => $format->getId()]);
        }

        return [
            'format' => $format,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'format_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, Format $format) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $format->getId(), $request->request->get('_token'))) {
            $entityManager->remove($format);
            $entityManager->flush();
            $this->addFlash('success', 'The format has been deleted.');
        }

        return $this->redirectToRoute('format_index');
    }
}
