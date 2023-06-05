<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\DTO;

use Symfony\Component\Uid\Uuid;

interface FeedInterface
{
    public function getId(): ?Uuid;

    public function getTitle(): string;

    public function getChannel(): ?string;

    public function getAuthor(): string;

    public function getLink(): string;

    public function getDescription(): string;
}
