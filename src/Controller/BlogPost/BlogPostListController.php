<?php

declare(strict_types=1);

namespace App\Controller\BlogPost;

use App\Repository\BlogPostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post', name: 'blog_post_index', methods: ['GET'])]
class BlogPostListController extends AbstractController
{
    private PaginatorInterface $paginator;
    private BlogPostRepository $blogPostRepository;

    public function __construct(PaginatorInterface $paginator, BlogPostRepository $blogPostRepository)
    {
        $this->paginator = $paginator;
        $this->blogPostRepository = $blogPostRepository;
    }

    public function __invoke(Request $request): Response
    {
        $posts = $this->paginator->paginate(
            $this->blogPostRepository->findAllQb(),
            $request->query->getInt('page', 1)
        );

        return $this->render('blog_post/index.html.twig', [
            'blog_posts' => $posts,
        ]);
    }
}
