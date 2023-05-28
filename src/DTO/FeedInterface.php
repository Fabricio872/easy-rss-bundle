<?php

namespace Fabricio872\EasyRssBundle\DTO;

interface FeedInterface
{
    public function getTitle(): ?string;

    public function getDescription(): ?string;
}
