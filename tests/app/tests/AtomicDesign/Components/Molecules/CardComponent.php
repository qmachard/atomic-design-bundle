<?php

declare(strict_types=1);

namespace App\Tests\AtomicDesign\Components\Molecules;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\Component;

class CardComponent extends Component
{
    public function getName(): string
    {
        return 'Molecules|Card';
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
