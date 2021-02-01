<?php

declare(strict_types=1);

namespace App\Event\Post;

use App\Domain\BlogPost;
use Symfony\Contracts\EventDispatcher\Event;

abstract class PostEvent extends Event
{
    public function __construct(
        private BlogPost $post
    ) {}

    public function getPost(): BlogPost
    {
        return $this->post;
    }
}
