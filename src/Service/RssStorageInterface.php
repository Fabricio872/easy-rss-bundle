<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\Service;

use Fabricio872\EasyRssBundle\DTO\FeedInterface;
use Symfony\Component\Uid\Uuid;

interface RssStorageInterface
{
    public function add(FeedInterface $feed, ?Uuid $id = null): FeedInterface;

    public function clean(?string $channel, ?int $maxFeeds): void;

    /**
     * @return array<int, FeedInterface>
     */
    public function all(): array;

    public function getById(Uuid $id): ?FeedInterface;
}
