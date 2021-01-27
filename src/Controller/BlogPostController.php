<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\BlogPostType;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post')]
class BlogPostController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private BlogPostRepository $blogPostRepository;
    private PaginatorInterface $paginator;

    public function __construct(EntityManagerInterface $entityManager, BlogPostRepository $blogPostRepository, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;
        $this->blogPostRepository = $blogPostRepository;
        $this->paginator = $paginator;
    }

    #[Route('/', name: 'blog_post_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $posts = $this->paginator->paginate(
            $this->blogPostRepository->findAllQb(),
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('blog_post/index.html.twig', [
            'blog_posts' => $posts,
        ]);
    }

    #[Route('/new', name: 'blog_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $blogPost = new BlogPost();
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($blogPost);
            $this->entityManager->flush();

            return $this->redirectToRoute('blog_post_index');
        }

        return $this->render('blog_post/new.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'blog_post_show', methods: ['GET'])]
    public function show(BlogPost $blogPost): Response
    {
        return $this->render('blog_post/show.html.twig', [
            'blog_post' => $blogPost,
        ]);
    }

    #[Route('/{id}/edit', name: 'blog_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BlogPost $blogPost): Response
    {
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_post_index');
        }

        return $this->render('blog_post/edit.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'blog_post_delete', methods: ['DELETE'])]
    public function delete(Request $request, BlogPost $blogPost): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogPost->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($blogPost);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('blog_post_index');
    }
}
