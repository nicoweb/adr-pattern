<?php

declare(strict_types=1);

namespace App\Paginator;

interface Paginator
{
    public function paginate(mixed $target, int $page = 1, int $limit = 10, array $options = []): Pagination;
}
