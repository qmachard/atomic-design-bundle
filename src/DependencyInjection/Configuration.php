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
                ->info('Encore CSS entry name.')
            ->end()
            ->scalarNode('js_entry_name')
                ->info('Encore JS entry name.')
            ->end()
        ;

        return $treeBuilder;
    }
}
