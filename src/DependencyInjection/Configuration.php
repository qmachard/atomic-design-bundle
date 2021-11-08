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
            ->scalarNode('css_entry_name')
                ->defaultValue('app')
                ->info('Encore CSS entry name.')
            ->end()
            ->scalarNode('js_entry_name')
                ->defaultValue('app')
                ->info('Encore JS entry name.')
            ->end()
            ->scalarNode('css_package_name')
                ->defaultNull()
                ->info('Encore CSS package name.')
            ->end()
            ->scalarNode('js_package_name')
            ->defaultNull()
                ->info('Encore JS package name.')
            ->end()
        ;

        return $treeBuilder;
    }
}
