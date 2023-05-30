<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\DTO;

interface FeedInterface
{
    public function getTitle(): string;

    public function getChannel(): ?string;

    public function getDescription(): string;
}
