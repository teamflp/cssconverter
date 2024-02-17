<?php

namespace App\Cssconverter\Classes;

use DateTimeImmutable;

class Comment
{
    private string $authorName;
    private string $content;
    private DateTimeImmutable $createdAt;
    private string $email;

    public function __construct(string $authorName, string $content)
    {
        $this->authorName = $authorName;
        $this->content = $content;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): void
    {
        $this->authorName = $authorName;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}