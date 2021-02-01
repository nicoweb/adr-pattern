<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\InMemory;

use App\Domain\BlogPost;
use App\Exception\EntityNotFoundException;
use App\Infrastructure\Paginator\AppPagination;
use App\Paginator\Pagination;
use App\Repository\BlogPostRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

final class InMemoryBlogPostRepository implements BlogPostRepository
{
    /**
     * @var array|BlogPost[]
     */
    public static array $aggregates = [];

    public function getClassName(): string
    {
        return self::class;
    }

    public function find($id): ?BlogPost
    {
        if (!isset(self::$aggregates[(string) $id])) {
            throw new EntityNotFoundException($id, $this->getClassName());
        }

        return self::$aggregates[(string) $id];

    }

    public function findAll(): array
    {
        return self::$aggregates;
    }

    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        $this->checkPropertiesExist($criteria);

        return $this->doFindBy($criteria);
    }

    public function findOneBy(array $criteria): ?BlogPost
    {
        $results = $this->findBy($criteria);

        if (($total = count($results)) > 1) {
            throw new \Exception(sprintf('Only one result expected got "%d"', $total));
        }

        if ($total < 1) {
            throw new EntityNotFoundException(null, $this->getClassName());
        }

        return $results[array_key_first($results)];
    }

    public function findAllPaginated(int $page): Pagination
    {
        return new AppPagination(new SlidingPagination([]));
    }

    private function checkPropertiesExist(array $criteria): void
    {
        foreach ($criteria as $propertyName => $value) {
            if (!property_exists(BlogPost::class, $propertyName)) {
                throw new \Exception(sprintf('Property "%s" doesn\'t exist in class "%s"', $propertyName, $this->getClassName()));
            }
        }
    }

    private function doFindBy(array $criteria): array
    {
        return array_filter(self::$aggregates, static function ($post) use ($criteria) {
            foreach ($criteria as $propertyName => $value) {
                if ($value !== $post->$propertyName) {
                    return false;
                }
            }
            return true;
        });
    }
}
