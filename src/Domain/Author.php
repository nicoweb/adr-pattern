<?php

namespace App\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @final
 */
class Author
{
    public ?int $id;
    public ?string $name;
    public ?string $title;
    public ?string $username;
    public ?string $company;
    public ?string $shortBio;
    public ?string $email;
    public array|Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function addPost(BlogPost $post): void
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->author = $this;
        }
    }

    public function removePost(BlogPost $post): void
    {
        if ($this->posts->removeElement($post)) {
            if ($post->author === $this) {
                $post->author = null;
            }
        }
    }

    public function __toString(): string
    {
        return (string) $this->email;
    }
}
