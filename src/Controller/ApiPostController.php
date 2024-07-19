<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Flex\Recipe;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiPostController extends AbstractController
{
    #[Route('/api/post', name: 'app_api_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findAll();

        return $this->json($posts,200, [], [
            'groups' => ['posts.index']
        ]);
    
    }

    #[Route('/api/post', name: 'app_api_post_index', methods: ['POST'])]
    public function create( Request $request,
        #[MapRequestPayload(
            serializationContext: [
                'groups' => ['recipes.create']
            ]
        )]
        Post $post,
        EntityManagerInterface $em,
        ValidatorInterface $validator
        )
    {
       
        
        try {
            $errors = $validator->validate($post);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $em->persist($post);
            $em->flush();

        } catch (\Throwable $th) {
            //throw $th;
        }


        return $this->json($post,200, [], [
            'groups' => ['posts.index']
        ]);
    
    }
}
