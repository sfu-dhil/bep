<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ManuscriptSource;
use App\Form\ManuscriptSourceType;
use App\Repository\ManuscriptSourceRepository;
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

#[Route(path: '/manuscript_source')]
class ManuscriptSourceController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    #[Route(path: '/', name: 'manuscript_source_index', methods: ['GET'])]
    #[Template]
    public function index(Request $request, ManuscriptSourceRepository $manuscriptSourceRepository) : array {
        $q = $request->query->get('q');
        $query = $q ? $manuscriptSourceRepository->searchQuery($q) : $manuscriptSourceRepository->indexQuery();

        return [
            'sources' => $this->paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('page_size'), ['wrap-queries' => true]),
            'q' => $q,
        ];
    }

    #[Route(path: '/typeahead', name: 'manuscript_source_typeahead', methods: ['GET'])]
    public function typeahead(Request $request, ManuscriptSourceRepository $manuscriptSourceRepository) : JsonResponse {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($manuscriptSourceRepository->typeaheadQuery($q)->execute() as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/new', name: 'manuscript_source_new', methods: ['GET', 'POST'])]
    #[Template]
    #[IsGranted('ROLE_CONTENT_ADMIN')]
    public function new(EntityManagerInterface $entityManager, Request $request) : array|RedirectResponse {
        $manuscriptSource = new ManuscriptSource();
        $form = $this->createForm(ManuscriptSourceType::class, $manuscriptSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($manuscriptSource);
            $entityManager->flush();

            $this->addFlash('success', 'The new source has been saved.');

            return $this->redirectToRoute('manuscript_source_show', ['id' => $manuscriptSource->getId()]);
        }

        return [
            'source' => $manuscriptSource,
            'form' => $form->createView(),
        ];
    }

    #[Route(path: '/{id}', name: 'manuscript_source_show', methods: ['GET'])]
    #[Template]
    public function show(ManuscriptSource $manuscriptSource) : array {
        return [
            'source' => $manuscriptSource,
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}/edit', name: 'manuscript_source_edit', methods: ['GET', 'POST'])]
    #[Template]
    public function edit(EntityManagerInterface $entityManager, Request $request, ManuscriptSource $manuscriptSource) : array|RedirectResponse {
        $form = $this->createForm(ManuscriptSourceType::class, $manuscriptSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'The updated source has been saved.');

            return $this->redirectToRoute('manuscript_source_show', ['id' => $manuscriptSource->getId()]);
        }

        return [
            'source' => $manuscriptSource,
            'form' => $form->createView(),
        ];
    }

    #[IsGranted('ROLE_CONTENT_ADMIN')]
    #[Route(path: '/{id}', name: 'manuscript_source_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Request $request, ManuscriptSource $manuscriptSource) : RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $manuscriptSource->getId(), $request->request->get('_token'))) {
            $entityManager->remove($manuscriptSource);
            $entityManager->flush();
            $this->addFlash('success', 'The source has been deleted.');
        }

        return $this->redirectToRoute('manuscript_source_index');
    }
}
