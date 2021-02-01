<?php

declare(strict_types=1);

namespace App\Action\Author;

use App\Domain\Author;
use App\Http\Response;
use App\Responder\Responder;

final class AuthorShowAction
{
    public function __construct(
        private Responder $responder,
    ) {}

    public function __invoke(Author $author): Response
    {
        return $this->responder->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }
}
