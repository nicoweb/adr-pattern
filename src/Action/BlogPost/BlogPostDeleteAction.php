<?php

declare(strict_types=1);

namespace App\Action\BlogPost;

use App\Domain\BlogPost;
use App\Http\Response;
use App\Manager\BlogPostManager;
use App\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class BlogPostDeleteAction
{
    public function __construct(
        private BlogPostManager $postManager,
        private CsrfTokenManagerInterface $csrfTokenManager,
        private Responder $responder,
    ) {}

    public function __invoke(Request $request, BlogPost $blogPost): Response
    {
        if ($this->csrfTokenManager->isTokenValid(new CsrfToken('delete'.$blogPost->id, $request->request->get('_token')))) {
            $this->postManager->remove($blogPost);
        }

        return $this->responder->redirectToRoute('blog_post_index');
    }
}
