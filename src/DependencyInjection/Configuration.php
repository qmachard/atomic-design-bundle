<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('atomic_design');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
            ->scalarNode('css_path')->info('Project CSS path.')->end()
            ->scalarNode('js_path')->info('Project JS path.')->end()
        ;

        return $treeBuilder;
    }
}
