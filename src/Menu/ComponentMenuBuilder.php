<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Menu;

use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProviderInterface;

class ComponentMenuBuilder implements ComponentMenuBuilderInterface
{
    private static $levelPattern = '/(.*)\|(.*)/m';

    /** @var ComponentProviderInterface */
    private $componentProvider;

    /** @var array */
    private $menu;

    public function __construct(ComponentProviderInterface $componentProvider)
    {
        $this->componentProvider = $componentProvider;
    }

    public function createView(): array
    {
        if (null === $this->menu) {
            $this->menu = $this->buildMenu();
        }

        return $this->menu;
    }

    private function buildMenu(): array
    {
        $menu = [];

        foreach ($this->componentProvider->getComponents() as $component) {
            $names = $this->extractNames($component->getName());

            if (!array_key_exists($names['category'], $menu)) {
                $menu[$names['category']] = [];
            }

            $menu[$names['category']][$names['component']] = $component->getStories();
        }

        return $menu;
    }

    private function extractNames(string $name): array
    {
        if (preg_match(self::$levelPattern, $name, $matches)) {
            $category = $matches[1];
            $component = $matches[2];
        } else {
            $category = 'Default';
            $component = $name;
        }

        return [
            'category' => $category,
            'component' => $component,
        ];
    }
}
