<?php

declare(strict_types=1);

namespace App\Manager;

use App\Domain\BlogPost;

interface BlogPostManager
{
    public function insert(BlogPost $post): void;
    public function update(BlogPost $post): void;
    public function remove(BlogPost $post): void;
}
