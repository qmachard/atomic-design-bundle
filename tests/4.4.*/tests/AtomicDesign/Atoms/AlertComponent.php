<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Tests\App\Tests\AtomicDesign\Atoms;

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

        $alerts = [];

        foreach ($colors as $color) {
            $alerts[] = $this->render('@components/atoms/alert/alert.html.twig', [
                'props' => [
                    'text' => 'A simple ' . ucfirst($color) . ' alert !',
                    'color' => $color
                ]
            ]);
        }

        return join(' ', $alerts);
    }
}
