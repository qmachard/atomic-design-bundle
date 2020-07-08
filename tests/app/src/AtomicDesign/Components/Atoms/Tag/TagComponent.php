<?php

declare(strict_types=1);

namespace App\AtomicDesign\Components\Atoms\Tag;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\Component;
use QuentinMachard\Bundle\AtomicDesignBundle\Model\ComponentInterface;

class TagComponent extends Component
{

    public function getName(): string
    {
        return 'Tag';
    }

    public function getStories(): array
    {
        return [
            'Default' => 'defaultStory',
        ];
    }

    public function defaultStory(): string
    {
        return $this->render('@components/Atoms/Tag/tag.html.twig', [
            'props' => [
                'label' => 'Lorem ipsum'
            ],
        ]);
    }

    public function getDefaultStory(): string
    {
        return 'defaultStory';
    }
}
