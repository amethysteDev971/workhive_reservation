<?php
namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/api/users', name: 'api_users_')]
class UserApiController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $users = $em->getRepository(User::class)->findAll();
        $data = $serializer->serialize($users, 'json', ['groups' => 'user:read']);
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(User $user, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->serialize($user, 'json', ['groups' => 'user:read']);
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(
        EntityManagerInterface $em, 
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        $user->setPhone($data['phone'] ?? null);
        // Validation
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse((string) $errors, JsonResponse::HTTP_BAD_REQUEST);
        }
        $em->persist($user);
        $em->flush();

        $response = $serializer->serialize($user, 'json', ['groups' => 'user:read']);
        return new JsonResponse($response, 201, [], true);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT', 'PATCH'])]
    public function update(
        int $id,
        EntityManagerInterface $em,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {
        // Récupération de l'utilisateur existant
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Décoder les données envoyées dans la requête
        $data = json_decode($request->getContent(), true);

        // Mise à jour des propriétés si elles sont présentes dans les données
        if (isset($data['firstName'])) {
            $user->setFirstName($data['firstName']);
        }
        if (isset($data['lastName'])) {
            $user->setLastName($data['lastName']);
        }
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['password'])) {
            $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        }
        if (isset($data['phone'])) {
            $user->setPhone($data['phone']);
        }

        // Validation des données mises à jour
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse((string) $errors, JsonResponse::HTTP_BAD_REQUEST);
        }

        // Persister les modifications
        $em->flush();

        // Sérialisation de la réponse
        $response = $serializer->serialize($user, 'json', ['groups' => 'user:read']);
        return new JsonResponse($response, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        // Récupération de l'utilisateur existant
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Suppression de l'utilisateur
        $em->remove($user);
        $em->flush();

        // Retourner une réponse avec succès
        return new JsonResponse(['message' => 'User deleted successfully'], JsonResponse::HTTP_OK);
    }

}
