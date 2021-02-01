<?php

declare(strict_types=1);

namespace App\Action\BlogPost;

use App\Domain\BlogPost;
use App\Http\Response;
use App\Responder\Responder;

final class BlogPostShowAction
{
    public function __construct(
        private Responder $responder,
    )
    {}

    public function __invoke(BlogPost $blogPost): Response
    {
        return $this->responder->render('blog_post/show.html.twig', [
            'blog_post' => $blogPost,
        ]);
    }
}
