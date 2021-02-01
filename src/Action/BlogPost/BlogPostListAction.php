<?php

declare(strict_types=1);

namespace App\Action\BlogPost;

use App\Paginator\Paginator;
use App\Repository\BlogPostRepository;
use App\Responder\Responder;
use App\Http\Response;
use Symfony\Component\HttpFoundation\Request;

final class BlogPostListAction
{
    public function __construct(
        private Paginator $paginator,
        private BlogPostRepository $blogPostRepository,
        private Responder $responder,
    ) {}

    public function __invoke(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        return $this->responder->render('blog_post/index.html.twig', [
            'blog_posts' => $this->blogPostRepository->findAllPaginated($page),
        ]);
    }
}
