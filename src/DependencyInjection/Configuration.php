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
                ->scalarNode('max_feeds')->defaultValue(10)->info('Maximum feeds that would be stored. (0 to unlimited)')->end()
//                ->scalarNode('ttl_feed')->defaultValue('')->info('Time interval value for how long feed should live e.g. "1 month", "1 week", etc. (empty for unlimited)')->end()
                ->arrayNode('feeds')
                        ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')->defaultValue('default')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
