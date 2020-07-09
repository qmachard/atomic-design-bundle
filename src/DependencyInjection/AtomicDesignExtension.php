<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\DependencyInjection;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\ComponentInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class AtomicDesignExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->registerForAutoconfiguration(ComponentInterface::class)
            ->addTag('atomic_design.component');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('atomic_design.controller.story');

        $definition->setArgument(2, $config['css_path']);
        $definition->setArgument(3, $config['js_path']);
    }
}
