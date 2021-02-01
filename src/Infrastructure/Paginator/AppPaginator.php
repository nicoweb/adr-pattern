<?php

declare(strict_types=1);

namespace App\Infrastructure\Paginator;

use App\Paginator\Pagination;
use App\Paginator\Paginator;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

final class AppPaginator implements Paginator
{
    private PaginatorInterface $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    public function paginate(mixed $target, int $page = 1, int $limit = 10, array $options = []): Pagination
    {
        $pagination = $this->paginator->paginate($target, $page, $limit, $options);

        if (!$pagination instanceof SlidingPaginationInterface) {
            throw new \LogicException('variable "$pagination" must be instance of SlidingPaginationInterface');
        }

        return new AppPagination($pagination);
    }
}
