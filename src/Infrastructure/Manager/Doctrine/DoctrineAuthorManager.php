<?php

declare(strict_types=1);

namespace App\Infrastructure\Manager\Doctrine;

use App\Domain\Author;
use App\Event\Author\AuthorCreated;
use App\Event\Author\AuthorRemoved;
use App\Event\Author\AuthorUpdated;
use App\Manager\AuthorManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class DoctrineAuthorManager implements AuthorManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $dispatcher,
    ) {}

    public function insert(Author $author): void
    {
        $this->entityManager->persist($author);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new AuthorCreated($author));
    }

    public function update(Author $author): void
    {
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new AuthorUpdated($author));
    }

    public function remove(Author $author): void
    {
        $this->entityManager->remove($author);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new AuthorRemoved($author));
    }
}
