<?php

declare(strict_types=1);

namespace App\Manager;

use App\Domain\Author;

interface AuthorManager
{
    public function insert(Author $author): void;
    public function update(Author $author): void;
    public function remove(Author $author): void;
}
