<?php

namespace App\Controller;

use App\Entity\Snippet;
use App\Repository\SnippetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SnippetController extends AbstractController
{
    protected SnippetRepository|null $snippetRepository = null;
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function getRepository(): SnippetRepository
    {
        if (is_null($this->snippetRepository)) {
            $this->setRepository();
        }
        return $this->snippetRepository;
    }

    protected function setRepository()
    {
        $this->snippetRepository = $this->entityManager->getRepository(Snippet::class);
    }

    #[Route('/snippets/{id}', name: 'snippet', methods: 'GET')]
    public function getOne(EntityManagerInterface $entityManager, int $id): Response
    {
        /** @var Snippet $snippet */
        $snippet = $entityManager->getRepository(Snippet::class)->find($id);
        return new JsonResponse(
            $snippet->toArray()
        );
    }


    #[Route('/snippets', name: 'snippet_list', methods: 'GET')]
    public function get(EntityManagerInterface $entityManager): Response
    {
        /** @var Snippet[] $snippets */
        $snippets = $entityManager->getRepository(Snippet::class)->findAll();
        return new JsonResponse(
            array_map(
                /** @var Snippet $snippet */
                fn($snippet) => $snippet->toArray(),
                $snippets
            )
        );
    }


    #[Route('/snippets', name: 'snippet_create', methods: 'POST')]
    public function post(Request $request): Response
    {
        $data = $request->getPayload();
        $snippetRepository = $this->getRepository();
        $snippet = $snippetRepository->createOne($data->get('title'), $data->get('code'));
        return new JsonResponse(
            $snippet->toArray()
        );
    }


    #[Route('/snippets/{id}', name: 'snippet_update', methods: 'PUT')]
    public function put(Request $request, int $id): Response
    {
        $data = $request->getPayload();
        $snippetRepository = $this->getRepository();
        $snippet = $snippetRepository->update($id, $data->get('title'), $data->get('code'));
        return new JsonResponse(
            $snippet->toArray()
        );
    }


    #[Route('/snippets/{id}', name: 'snippet_delete', methods: 'DELETE')]
    public function destroy(int $id): Response
    {
        $snippetRepository = $this->getRepository();
        $snippet = $snippetRepository->delete($id);
        return new JsonResponse(
            $snippet->toArray()

        );
    }
}
