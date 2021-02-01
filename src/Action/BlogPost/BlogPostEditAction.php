<?php

declare(strict_types=1);

namespace App\Action\BlogPost;

use App\Domain\BlogPost;
use App\Form\BlogPostType;
use App\Http\Response;
use App\Manager\BlogPostManager;
use App\Responder\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class BlogPostEditAction extends AbstractController
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private BlogPostManager $postManager,
        private Responder $responder,
    )
    {}

    public function __invoke(Request $request, BlogPost $blogPost): Response
    {
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postManager->update($blogPost);

            return $this->responder->redirectToRoute('blog_post_index');
        }

        return $this->responder->render('blog_post/edit.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form->createView(),
        ]);
    }
}
