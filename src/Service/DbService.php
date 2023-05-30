<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\Service;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Fabricio872\EasyRssBundle\DTO\FeedInterface;
use Fabricio872\EasyRssBundle\Entity\RssFeed;

class DbService
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function add(FeedInterface $feed): self
    {
        $feedEntity = new RssFeed();
        $feedEntity
            ->setTitle($feed->getTitle())
            ->setDescription($feed->getDescription())
            ->setChannel($feed->getChannel() ?? 'default')
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(new DateTimeImmutable());

        $this->em->persist($feedEntity);

        return $this;
    }

    public function clean(?string $channel, ?int $maxFeeds): void
    {
        if (! $maxFeeds) {
            return;
        }

        $qb = $this->em->createQueryBuilder()
            ->select('r')
            ->from(RssFeed::class, 'r')
            ->orderBy('r.updatedAt', 'DESC')
            ->andWhere('r.channel = :channel')
            ->setParameter('channel', $channel ?? 'default')
            ->setFirstResult($maxFeeds);

        foreach ($qb->getQuery()->getResult() as $feedToDelete) {
            $this->em->remove($feedToDelete);
        }
    }
}
