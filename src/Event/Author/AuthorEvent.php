<?php

declare(strict_types=1);

namespace App\Event\Author;

use App\Domain\Author;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AuthorEvent extends Event
{
    public function __construct(
        private Author $author
    ) {}

    public function getAuthor(): Author
    {
        return $this->author;
    }
}
