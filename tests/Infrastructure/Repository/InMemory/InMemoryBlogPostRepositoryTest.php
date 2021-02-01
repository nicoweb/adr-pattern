<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\InMemory;

use App\Domain\Author;
use App\Domain\BlogPost;
use App\Infrastructure\Repository\InMemory\InMemoryBlogPostRepository;
use PHPUnit\Framework\TestCase;

class InMemoryBlogPostRepositoryTest extends TestCase
{
    private InMemoryBlogPostRepository $blogPostRepository;
    private BlogPost $post;

    protected function setUp(): void
    {
        $this->blogPostRepository = new InMemoryBlogPostRepository();
        $author = new Author();
        $author->id = (int) uniqid('', true);
        $author->title = 'dev';
        $author->email = 'email.test@test.com';
        $author->name = 'Nicolas';
        $this->post = new BlogPost();
        $this->post->author = $author;
        $this->post->title = 'test title';
        $this->post->id = (int) uniqid('', true);
        $this->post->body = 'The body';
        $this->post->description = 'description';
        $this->post->slug = 'slug-short';

        InMemoryBlogPostRepository::$aggregates = [$this->post->id => $this->post];
    }

    public function testFindOneBy(): void
    {
        $result = $this->blogPostRepository->findOneBy([
            'title' => 'test title',
            'body' => 'The body'
        ]);

        self::assertSame($this->post, $result);
    }
}
