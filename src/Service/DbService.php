<?php

namespace Fabricio872\EasyRssBundle\Service;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Fabricio872\EasyRssBundle\DTO\FeedInterface;
use Fabricio872\EasyRssBundle\Entity\RssFeed;

class DbService
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function add(FeedInterface $feed)
    {
        $feedEntity = new RssFeed();
        $feedEntity
            ->setTitle($feed->getTitle())
            ->setDescription($feed->getDescription())
            ->setCategory($feed->getCategory() ?? 'default')
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(new DateTimeImmutable());

        $this->em->persist($feedEntity);
    }

    public function clean(?string $category, ?int $maxFeeds): void
    {
        if (!$maxFeeds) {
            return;
        }

        $qb = $this->em->createQueryBuilder()
            ->select('r')
            ->from(RssFeed::class, 'r')
            ->orderBy('r.updatedAt', 'DESC')
            ->andWhere('r.category = :category')
            ->setParameter('category', $category ?? 'default')
            ->setFirstResult($maxFeeds);

        foreach ($qb->getQuery()->getResult() as $feedToDelete) {
            $this->em->remove($feedToDelete);
        }
    }
}
