<?php

declare(strict_types=1);

namespace App\Infrastructure\Manager\Doctrine;

use App\Domain\BlogPost;
use App\Event\Post\PostCreated;
use App\Event\Post\PostRemoved;
use App\Event\Post\PostUpdated;
use App\Manager\BlogPostManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class DoctrineBlogPostManager implements BlogPostManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $dispatcher,
    ) {}

    public function insert(BlogPost $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new PostCreated($post));
    }

    public function update(BlogPost $post): void
    {
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new PostUpdated($post));
    }

    public function remove(BlogPost $post): void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new PostRemoved($post));
    }
}
