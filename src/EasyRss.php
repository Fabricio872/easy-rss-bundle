<?php

namespace Fabricio872\EasyRssBundle;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Fabricio872\EasyRssBundle\DTO\FeedInterface;
use Fabricio872\EasyRssBundle\Entity\RssFeed;

class EasyRss
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    public function add(FeedInterface $feed):self
    {
        $feedEntity = new RssFeed();
        $feedEntity
            ->setTitle($feed->getTitle())
            ->setDescription($feed->getDescription())
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(new DateTimeImmutable());

        $this->em->persist($feedEntity);
        $this->em->flush();

        return $this;
    }
}
