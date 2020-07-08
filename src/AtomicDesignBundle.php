<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle;

use QuentinMachard\Bundle\AtomicDesignBundle\DependencyInjection\AtomicDesignExtension;
use QuentinMachard\Bundle\AtomicDesignBundle\DependencyInjection\Reference\ComponentProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AtomicDesignBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new AtomicDesignExtension();
        }

        return $this->extension;
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ComponentProviderCompilerPass());
    }
}
