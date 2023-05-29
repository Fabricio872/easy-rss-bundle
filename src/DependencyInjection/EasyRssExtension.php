<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class EasyRssExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        if (! $configuration) {
            throw new Exception('Configuration cannot be null');
        }
        $config = $this->processConfiguration($configuration, $configs);

        $serviceDefinition = $container->getDefinition('fabricio872_easy_rss.easy_rss');
        $serviceDefinition->setArgument(0, $config['max_feeds']);
    }
}
