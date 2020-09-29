<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Menu;

interface ComponentMenuBuilderInterface
{
    public function createView(): array;
}
