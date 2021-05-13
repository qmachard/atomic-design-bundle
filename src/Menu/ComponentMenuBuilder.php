<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Menu;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\ComponentInterface;
use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProviderInterface;

class ComponentMenuBuilder implements ComponentMenuBuilderInterface
{
    private $levelSeparator;

    /** @var ComponentProviderInterface */
    private $componentProvider;

    /** @var array */
    private $menu;

    public function __construct(ComponentProviderInterface $componentProvider, string $levelSeparator = '|')
    {
        $this->componentProvider = $componentProvider;
        $this->levelSeparator = $levelSeparator;
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

        /** @var ComponentInterface $component */
        foreach ($this->componentProvider->getComponents() as $component) {
            $category = $component->getCategory();
            $name = $component->getName();

            if (null === $category) {
                extract($this->extractNames($component->getName()));
            }

            $category = trim($category);
            $name = trim($name);

            if (!array_key_exists($category, $menu)) {
                $menu[$category] = [];
            }

            $menu[$category][$name] = $component->getStories();
        }

        return $menu;
    }

    private function extractNames(string $name): array
    {
        $parts = explode($this->levelSeparator, $name);

        if (count($parts) === 1) {
            return [
                'category' => 'Default',
                'name' => $parts[0],
            ];
        }

        if (count($parts) > 2) {
            return [
                'category' => array_shift($parts),
                'name' => implode($this->levelSeparator, $parts),
            ];
        }

        return [
            'category' => $parts[0],
            'name' => $parts[1],
        ];
    }
}
