<?php

namespace Fabricio872\EasyRssBundle;

use Doctrine\ORM\EntityManagerInterface;
use Fabricio872\EasyRssBundle\DTO\FeedInterface;
use Fabricio872\EasyRssBundle\Entity\RssFeed;
use Fabricio872\EasyRssBundle\Service\DbService;
use Fabricio872\EasyRssBundle\Service\RssService;
use Markocupic\RssFeedGeneratorBundle\Item\Item;
use Markocupic\RssFeedGeneratorBundle\Item\ItemGroup;
use Symfony\Component\HttpFoundation\Response;

class EasyRss
{
    public function __construct(
        private int                    $maxFeeds,
        private DbService              $dbService,
        private RssService             $rssService,
        private EntityManagerInterface $em
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
        $this->dbService->add($feed);
        $this->dbService->clean($feed->getCategory(), $this->maxFeeds ?? null);
        $this->em->flush();

        return $this;
    }

    public function getResponse(string $title, string $category = 'default'): Response
    {
        $this->rssService->setTitle($title);
        $this->buildItemGroups($category);

        return $this->rssService->getResponse();
    }

    private function buildItemGroups(string $category)
    {
        $feeds = $this->em->getRepository(RssFeed::class)->findBy(['category' => $category]);

        foreach ($feeds as $feed) {
            $this->rssService->setItems(new ItemGroup('item', [
                new Item('title', $feed->getTitle()),
                new Item('link', 'link'),
                new Item('description', $feed->getDescription(), ['cdata' => true]),
                new Item('pubDate', $feed->getCreatedAt()->format('r')),
                new Item('author', 'author'),
                new Item('guid', $feed->getId()),
                new Item('tourdb:startdate', $feed->getCreatedAt()->format('Y-m-d')),
                new Item('tourdb:enddate', $feed->getUpdatedAt()->format('Y-m-d')),
            ]));
        }
    }
}
