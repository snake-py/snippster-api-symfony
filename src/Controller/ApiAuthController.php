<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


class ApiAuthController extends AbstractController
{

    protected UserRepository|null $userRepository = null;
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function getRepository(): UserRepository
    {
        if (is_null($this->userRepository)) {
            $this->setRepository();
        }
        return $this->userRepository;
    }

    protected function setRepository()
    {
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $userRepository = $this->getRepository();
        $data = $request->getPayload();

        try {
            $user = $userRepository->register(
                $data->get('username'),
                $data->get('email'),
                $data->get('password')
            );
        } catch (Exception $error) {
            return $this->json([
                'error' => $error->getMessage()
            ]);
        }

        return $this->json($user->toArray());
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(#[CurrentUser] ?User $user): JsonResponse
    {
        if (is_null($user)) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = 'my-new-toke'; //  $user->getToken();

        return $this->json([
            'user' => $user->getUserIdentifier(),
            'toke' => $token
        ]);
    }
}
