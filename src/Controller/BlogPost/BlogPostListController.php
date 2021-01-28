<?php

declare(strict_types=1);

namespace App\Controller\BlogPost;

use App\Repository\BlogPostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route('/post', name: 'blog_post_index', methods: ['GET'])]
class BlogPostListController
{
    private PaginatorInterface $paginator;
    private BlogPostRepository $blogPostRepository;
    private Environment $twig;

    public function __construct(PaginatorInterface $paginator, BlogPostRepository $blogPostRepository, Environment $twig)
    {
        $this->paginator = $paginator;
        $this->blogPostRepository = $blogPostRepository;
        $this->twig = $twig;
    }

    public function __invoke(Request $request): Response
    {
        $posts = $this->paginator->paginate(
            $this->blogPostRepository->findAllQb(),
            $request->query->getInt('page', 1)
        );

        return new Response($this->twig->render('blog_post/index.html.twig', [
            'blog_posts' => $posts,
        ]));
    }
}
