<?php

namespace App\Infrastructure\Repository\Doctrine;

use App\Domain\BlogPost;
use App\Paginator\Pagination;
use App\Paginator\Paginator;
use App\Repository\BlogPostRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class DoctrineBlogPostRepository extends ServiceEntityRepository implements BlogPostRepository
{
    private Paginator $paginator;

    public function __construct(ManagerRegistry $registry, Paginator $paginator)
    {
        parent::__construct($registry, BlogPost::class);
        $this->paginator = $paginator;
    }

    public function findAllPaginated(int $page): Pagination
    {
        return $this->paginator->paginate(
            $this->findAllQb(),
            $page,
        );
    }

    private function findAllQb(): QueryBuilder
    {
        return $this->createQueryBuilder('b');
    }
}
