<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\Service;

use Markocupic\RssFeedGeneratorBundle\Feed\Feed;
use Markocupic\RssFeedGeneratorBundle\Feed\FeedFactory;
use Markocupic\RssFeedGeneratorBundle\Formatter\Formatter;
use Markocupic\RssFeedGeneratorBundle\Item\Item;
use Markocupic\RssFeedGeneratorBundle\Item\ItemGroup;
use Symfony\Component\HttpFoundation\Response;

class RssService
{
    private readonly Feed $rss;
    private readonly FeedFactory $feedFactory;

    public function __construct()
    {
        $formatter = new Formatter([
            '/[\n\r]+/' => ' ',
            '/\[nbsp\]/' => ' ',
            '/&nbsp;/' => ' '
        ]);
        $this->feedFactory = new FeedFactory($formatter);

        // Use the feed factory to generate the feed object
        $this->rss = $this->feedFactory->createFeed(Feed::ENCODING_UTF8);

        // Add one or more attributes to the root element
        $this->rss->setRootAttributes([
            'xmlns:tourdb' => 'https://acme.com/schema/tourdbrss/1.0',
            'xmlns:atom' => 'http://www.w3.org/2005/Atom',
        ]);
    }

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

    public function setItems(ItemGroup ...$items): RssService
    {
        foreach ($items as $item) {
            $this->rss->addChannelItemField($item);
        }

        return $this;
    }

    public function getResponse(): Response
    {
        return $this->rss->render();
    }
}
