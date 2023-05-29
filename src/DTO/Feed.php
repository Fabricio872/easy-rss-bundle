<?php

namespace Fabricio872\EasyRssBundle\DTO;

class Feed implements FeedInterface
{
    private string $title;
    private ?string $category = null;
    private string $description;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Feed
    {
        $this->title = $title;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): Feed
    {
        $this->category = $category;
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
