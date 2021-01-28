<?php

declare(strict_types=1);

namespace App\Controller\BlogPost;

use App\Entity\BlogPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post/{id}', name: 'blog_post_delete', methods: ['DELETE'])]
class BlogPostDeleteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Request $request, BlogPost $blogPost): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogPost->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($blogPost);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('blog_post_index');
    }
}
