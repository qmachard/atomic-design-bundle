<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Model;

interface ComponentInterface
{
    /**
     * Get Name of the Component.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get List of Stories.
     *
     * @return string[]
     */
    public function getStories(): array;

    /**
     * Render the template of story.
     *
     * @param string $name
     *
     * @return string
     */
    public function renderStory(string $name): string;
}
