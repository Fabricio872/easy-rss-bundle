<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle;

use Doctrine\ORM\EntityManagerInterface;
use Fabricio872\EasyRssBundle\DTO\FeedInterface;
use Fabricio872\EasyRssBundle\Entity\RssFeed;
use Fabricio872\EasyRssBundle\Service\DbStorage;
use Fabricio872\EasyRssBundle\Service\RssService;
use Fabricio872\EasyRssBundle\Service\RssStorageInterface;
use Markocupic\RssFeedGeneratorBundle\Item\Item;
use Markocupic\RssFeedGeneratorBundle\Item\ItemGroup;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class EasyRss
{
    public function __construct(
        private int                             $maxFeeds,
        private readonly RssStorageInterface    $rssStorage,
        private readonly RssService             $rssService,
        private readonly EntityManagerInterface $em
    )
    {
    }

    public function setMaxFeeds(int $maxFeeds): self
    {
        $this->maxFeeds = $maxFeeds;

        return $this;
    }

    public function add(FeedInterface $feed): self
    {
        $this->rssStorage->add($feed);
        $this->rssStorage->clean($feed->getChannel(), $this->maxFeeds ?? null);

        return $this;
    }

    public function update(Uuid $id, FeedInterface $feed): FeedInterface
    {
        return $this->rssStorage->add($feed, $id);
    }

    /**
     * @return array<int, FeedInterface>
     */
    public function getAllFeeds(): array
    {
        return $this->rssStorage->all();
    }

    public function getFeedById(Uuid $id): FeedInterface
    {
        return $this->rssStorage->getById($id);
    }

    public function getResponse(string $title, string $channel = 'default'): Response
    {
        $this->rssService->setTitle($title);
        $this->buildItemGroups($channel);

        return $this->rssService->getResponse();
    }

    private function buildItemGroups(string $channel): void
    {
        $feeds = $this->em->getRepository(RssFeed::class)->findBy(['channel' => $channel]);

        foreach ($feeds as $feed) {
            $this->rssService->setItems(new ItemGroup('item', [
                new Item('title', $feed->getTitle()),
                new Item('link', $feed->getLink()),
                new Item('description', $feed->getDescription(), ['cdata' => true]),
                new Item('pubDate', $feed->getCreatedAt()->format('r')),
                new Item('author', $feed->getAuthor()),
                new Item('guid', (string)$feed->getId()),
                new Item('tourdb:startdate', $feed->getCreatedAt()->format('Y-m-d')),
                new Item('tourdb:enddate', $feed->getUpdatedAt()->format('Y-m-d')),
            ]));
        }
    }
}
