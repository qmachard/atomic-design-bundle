<?php

declare(strict_types=1);

namespace App\Tests\AtomicDesign\Components\Atoms;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\Component;

class AlertComponent extends Component
{
    public function getName(): string
    {
        return 'Atoms|Alert';
    }

    public function getStories(): array
    {
        return [
            'Colors' => 'colors',
        ];
    }

    public function colors(): string
    {
        $colors = ['secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        $buttons = [];

        foreach ($colors as $color) {
            $buttons[] = $this->render('@components/atoms/alert/alert.html.twig', [
                'props' => [
                    'text' => 'A simple ' . ucfirst($color) . ' alert !',
                    'color' => $color
                ]
            ]);
        }

        return join(' ', $buttons);
    }
}
