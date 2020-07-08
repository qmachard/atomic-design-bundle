<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Controller;

use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Profiler\Profiler;

class StoryController extends AbstractController
{
    /** @var ComponentProvider */
    private $componentProvider;

    public function __construct(ComponentProvider $componentProvider, Profiler $profiler)
    {
        $profiler->disable();

        $this->componentProvider = $componentProvider;
    }

    public function index(): Response
    {
        return $this->render('@AtomicDesign/index.html.twig', [
            'components' => $this->componentProvider->getComponents(),
        ]);
    }

    public function view(string $component, string $story = ''): Response
    {
        $component = $this->componentProvider->getComponent($component);

        if (null === $component) {
            throw new NotFoundHttpException('Component not found');
        }

        if ('' === $story) {
            $story = $component->getDefaultStory();
        }

        return $this->render('@AtomicDesign/view.html.twig', [
            'components' => $this->componentProvider->getComponents(),
            'component' => $component,
            'story' => $story,
        ]);
    }

    public function embed(string $component, string $story): Response
    {
        $component = $this->componentProvider->getComponent($component);

        $render = $component->renderStory($story);

        return $this->render('@AtomicDesign/embed.html.twig', [
            'render' => $render,
        ]);
    }
}
