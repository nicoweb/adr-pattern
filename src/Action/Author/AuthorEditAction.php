<?php

declare(strict_types=1);

namespace App\Action\Author;

use App\Domain\Author;
use App\Form\AuthorType;
use App\Http\Response;
use App\Manager\AuthorManager;
use App\Responder\Responder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class AuthorEditAction
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private AuthorManager $authorManager,
        private Responder $responder,
    ) {}

    public function __invoke(Request $request, Author $author): Response
    {
        $form = $this->formFactory->create(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->authorManager->update($author);

            return $this->responder->redirectToRoute('author_index');
        }

        return $this->responder->render('author/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }
}
