<?php

namespace App\Domain;

use App\Repository\BlogPostRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final
 */
class BlogPost
{
    public ?int $id;
    public ?string $title;
    public ?string $slug;
    public ?string $description;
    public ?string $body;
    public ?Author $author;
    public DateTimeInterface $createdAt;
    public DateTimeInterface $updatedAt;
}
