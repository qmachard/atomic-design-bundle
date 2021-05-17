<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Tests\App\Tests\AtomicDesign\Atoms;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\Component;

class ButtonComponent extends Component
{
    public function getName(): string
    {
        return 'Atoms|Button';
    }

    public function getStories(): array
    {
        return [
            'Colors' => 'colors',
            'Outlines' => 'outlines',
            'Sizes' => 'sizes',
        ];
    }

    public function colors(): string
    {
        $colors = ['secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        $buttons = [];

        foreach ($colors as $color) {
            $buttons[] = $this->render('@components/atoms/button/button.html.twig', [
                'props' => [
                    'label' => ucfirst($color),
                    'color' => $color
                ]
            ]);
        }

        return join(' ', $buttons);
    }

    public function outlines(): string
    {
        $colors = ['secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        $buttons = [];

        foreach ($colors as $color) {
            $buttons[] = $this->render('@components/atoms/button/button.html.twig', [
                'props' => [
                    'label' => ucfirst($color),
                    'color' => 'outline-' . $color,
                ]
            ]);
        }

        return join(' ', $buttons);
    }

    public function sizes(): string
    {
        $sizes = ['sm', 'md', 'lg'];

        $buttons = [];

        foreach ($sizes as $size) {
            $buttons[] = $this->render('@components/atoms/button/button.html.twig', [
                'props' => [
                    'label' => 'Button ' . strtoupper($size),
                    'color' => 'primary',
                    'size' => $size,
                ]
            ]);
        }

        return join(' ', $buttons);
    }
}
