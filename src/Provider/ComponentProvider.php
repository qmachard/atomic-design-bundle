<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Provider;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\ComponentInterface;

class ComponentProvider
{
    /**
     * @var ComponentInterface[]
     */
    private $components;

    public function __construct(array $components)
    {
        $this->components = $components;
    }

    public function getComponents(): array
    {
        return $this->components;
    }

    public function getComponent(string $name): ?ComponentInterface
    {
        foreach ($this->components as $component) {
            if ($component->getName() === $name) {
                return $component;
            }
        }

        return null;
    }
}
