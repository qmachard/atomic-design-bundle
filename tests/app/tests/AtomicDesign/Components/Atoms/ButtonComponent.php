<?php

declare(strict_types=1);

namespace App\Tests\AtomicDesign\Components\Atoms;

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
            'Primary' => 'storyPrimary',
        ];
    }

    public function getDefaultStory(): string
    {
        return 'storyPrimary';
    }

    public function storyPrimary(): string
    {
        return $this->render('@components/atoms/button/button.html.twig', [
            'props' => [
                'label' => 'Primary',
            ],
        ]);
    }
}
