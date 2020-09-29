<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Provider;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\ComponentInterface;

interface ComponentProviderInterface
{
    public function getComponents(): array;

    public function getComponent(string $name): ?ComponentInterface;
}
