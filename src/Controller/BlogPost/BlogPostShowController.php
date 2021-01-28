<?php

declare(strict_types=1);

namespace App\Controller\BlogPost;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post/{id}', name: 'blog_post_show', methods: ['GET'])]
class BlogPostShowController extends AbstractController
{
    public function __invoke(BlogPost $blogPost): Response
    {
        return $this->render('blog_post/show.html.twig', [
            'blog_post' => $blogPost,
        ]);
    }
}
