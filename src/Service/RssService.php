<?php

namespace Fabricio872\EasyRssBundle\Service;

use Markocupic\RssFeedGeneratorBundle\Feed\Feed;
use Markocupic\RssFeedGeneratorBundle\Feed\FeedFactory;
use Markocupic\RssFeedGeneratorBundle\Item\Item;
use Markocupic\RssFeedGeneratorBundle\Item\ItemGroup;
use Symfony\Component\HttpFoundation\Response;

class RssService
{
    private Feed $rss;

    public function __construct(
        private FeedFactory $feedFactory
    )
    {
        // Use the feed factory to generate the feed object
        $this->rss = $this->feedFactory->createFeed(Feed::ENCODING_UTF8);

        // Add one or more attributes to the root element
        $this->rss->setRootAttributes([
            'xmlns:tourdb' => 'https://acme.com/schema/tourdbrss/1.0',
            'xmlns:atom' => 'http://www.w3.org/2005/Atom',
        ]);
    }

    /**
     * @param string $title
     * @return RssService
     */
    public function setTitle(string $title): RssService
    {
        $this->rss->setChannelAttributes(
            array_merge(['title' => $title], $this->rss->getChannelAttributes())
        );

        $this->rss->addChannelField(
            new Item('title', $title)
        );

        return $this;
    }

    /**
     * @param string $link
     * @return RssService
     */
    public function setLink(string $link): RssService
    {
        $this->rss->setChannelAttributes(
            array_merge(['link' => $link], $this->rss->getChannelAttributes())
        );

        $this->rss->addChannelField(
            new Item('link', $link)
        );

        return $this;
    }

    /**
     * @param string $description
     * @return RssService
     */
    public function setDescription(string $description): RssService
    {
        $this->rss->setChannelAttributes(
            array_merge(['description' => $description], $this->rss->getChannelAttributes())
        );

        $this->rss->addChannelField(
            new Item('description', $description)
        );

        return $this;
    }

    /**
     * @param ItemGroup ...$items
     * @return void
     */
    public function setItems(ItemGroup ...$items): RssService
    {
        foreach ($items as $item) {
            $this->rss->addChannelItemField($item);
        }

        return $this;
    }

    public function getResponse(): Response
    {

//        $rss->addChannelItemField(
//            new ItemGroup('item', [
//                new Item('title', 'title'),
//                new Item('link', 'link'),
//                new Item('description', 'description', ['cdata' => true]),
//                new Item('pubDate', (new \DateTime())->format('r')),
//                new Item('author', 'author'),
//                new Item('guid', new Uuid('80107532-6b78-45db-af58-ca56d46696fb')),
//                new Item('tourdb:startdate', (new \DateTime())->format('Y-m-d')),
//                new Item('tourdb:enddate', (new \DateTime())->format('Y-m-d')),
//            ])
//        );

        return $this->rss->render();
    }
}
