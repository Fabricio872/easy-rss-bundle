<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Fabricio872\EasyRssBundle\Exceptions\NotSetException;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class RssFeed
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(unique: true, type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $channel = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updatedAt = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        if (! $this->title) {
            throw new NotSetException('$this->title');
        }

        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getAuthor(): string
    {
        if (! $this->author) {
            throw new NotSetException('$this->author');
        }

        return $this->author;
    }

    public function setAuthor(string $author): RssFeed
    {
        $this->author = $author;
        return $this;
    }

    public function getLink(): string
    {
        if (! $this->link) {
            throw new NotSetException('$this->link');
        }

        return $this->link;
    }

    public function setLink(string $link): RssFeed
    {
        $this->link = $link;
        return $this;
    }

    public function getDescription(): string
    {
        if (! $this->description) {
            throw new NotSetException('$this->description');
        }

        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        if (! $this->createdAt) {
            throw new NotSetException('$this->createdAt');
        }

        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        if (! $this->updatedAt) {
            throw new NotSetException('$this->updatedAt');
        }

        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
