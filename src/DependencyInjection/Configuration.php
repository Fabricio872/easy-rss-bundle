<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('easy_rss');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->end();

        return $treeBuilder;
    }
}
