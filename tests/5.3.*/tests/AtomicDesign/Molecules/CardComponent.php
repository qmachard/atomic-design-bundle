<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Tests\App\Tests\AtomicDesign\Molecules;

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
            'Default' => 'default',
            '+ image' => 'withImage',
        ];
    }

    public function default(): string
    {
        return $this->render('@components/molecules/card/card.html.twig', [
            'props' => [
                'title' => 'Card title',
                'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
            ]
        ]);
    }

    public function withImage(): string
    {
        return $this->render('@components/molecules/card/card.html.twig', [
            'props' => [
                'image' => [
                    'src' => 'http://placekitten.com/300/200',
                    'alt' => 'A cat.',
                ],
                'title' => 'Card title',
                'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
            ]
        ]);
    }
}
