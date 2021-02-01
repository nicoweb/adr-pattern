<?php

declare(strict_types=1);

namespace App\Action\BlogPost;

use App\Domain\BlogPost;
use App\Form\BlogPostType;
use App\Http\Response;
use App\Manager\BlogPostManager;
use App\Responder\Responder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class BlogPostCreateAction
{
    public function __construct(
        private BlogPostManager $postManager,
        private Responder $responder,
        private FormFactoryInterface $formFactory,
    ) {}

    public function __invoke(Request $request): Response
    {
        $blogPost = new BlogPost();
        $form = $this->formFactory->create(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postManager->insert($blogPost);

            return $this->responder->redirectToRoute('blog_post_index');
        }

        return $this->responder->render('blog_post/new.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form->createView(),
        ]);
    }
}
