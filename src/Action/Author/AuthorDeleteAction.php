<?php

declare(strict_types=1);

namespace App\Action\Author;

use App\Domain\Author;
use App\Http\Response;
use App\Manager\AuthorManager;
use App\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class AuthorDeleteAction
{
    public function __construct(
        private CsrfTokenManagerInterface $csrfTokenManager,
        private AuthorManager $authorManager,
        private Responder $responder,
    ) {}

    public function __invoke(Request $request, Author $author): Response
    {
        if ($this->csrfTokenManager->isTokenValid(new CsrfToken('delete'.$author->id, $request->request->get('_token')))) {
            $this->authorManager->remove($author);
        }

        return $this->responder->redirectToRoute('author_index');
    }
}
