<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Model;

use InvalidArgumentException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class Component implements ComponentInterface
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Get the Category.
     *
     * @return string
     */
    public function getCategory(): string
    {
        return 'Global';
    }

    /**
     * @return string
     */
    public function getDefaultStory(): string
    {
        $stories = $this->getStories();

        return current($stories);
    }

    /**
     * @inheritDoc
     */
    final public function renderStory(string $name): string
    {
        if (!method_exists($this, $name)) {
            throw new InvalidArgumentException("Story $name does't exists.");
        }

        return $this->$name();
    }

    /**
     * @param string $name
     * @param array  $params
     *
     * @return string
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function render(string $name, array $params = []): string
    {
        return $this->twig->render($name, $params);
    }
}
