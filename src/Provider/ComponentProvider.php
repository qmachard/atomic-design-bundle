<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Provider;

use InvalidArgumentException;
use QuentinMachard\Bundle\AtomicDesignBundle\Model\ComponentInterface;

class ComponentProvider implements ComponentProviderInterface
{
    /**
     * @var ComponentInterface[]
     */
    private $components = [];

    public function __construct(array $components)
    {
        foreach ($components as $component) {
            if (false === $component instanceof ComponentInterface) {
                throw new InvalidArgumentException(sprintf(
                    'The class "%s" neither implements "%s".',
                    get_debug_type($component),
                    ComponentInterface::class
                ));
            }

            $this->components[] = $component;
        }
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
