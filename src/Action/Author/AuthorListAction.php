<?php

declare(strict_types=1);

namespace App\Action\Author;

use App\Http\Response;
use App\Repository\AuthorRepository;
use App\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;

final class AuthorListAction
{
    public function __construct(
        private Responder $responder,
        private AuthorRepository $authorRepository,
    ) {}

    public function __invoke(Request $request): Response
    {
        return $this->responder->render('author/index.html.twig', [
            'authors' => $this->authorRepository->findAll(),
        ]);
    }
}
