<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\DTO;

class Feed implements FeedInterface
{
    private string $title;

    private ?string $channel = null;

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

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(?string $channel): Feed
    {
        $this->channel = $channel;
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
