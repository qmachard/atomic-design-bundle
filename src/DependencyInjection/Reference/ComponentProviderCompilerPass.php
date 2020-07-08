<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ComponentProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('atomic_design.provider.component');
        $references = [];

        foreach ($container->findTaggedServiceIds('atomic_design.component') as $id => $tags) {
            $references[] = new Reference($id);
        }

        $definition->setArgument(0, $references);
    }
}
