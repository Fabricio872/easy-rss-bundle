<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\DTO;

use Symfony\Component\Uid\Uuid;

class Feed implements FeedInterface
{
    private ?Uuid $id = null;

    private string $title;

    private ?string $channel = null;

    private string $author;

    private string $link;

    private string $description;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(?Uuid $id): Feed
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Feed
    {
        $this->title = $title;
        return $this;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(?string $channel): Feed
    {
        $this->channel = $channel;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): Feed
    {
        $this->author = $author;
        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): Feed
    {
        $this->link = $link;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Feed
    {
        $this->description = $description;
        return $this;
    }
}
