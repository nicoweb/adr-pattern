<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeInterface;

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
