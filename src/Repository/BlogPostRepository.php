<?php

declare(strict_types=1);

namespace App\Repository;

use App\Paginator\Pagination;

interface BlogPostRepository extends Repository
{
    public function findAllPaginated(int $page): Pagination;
}
