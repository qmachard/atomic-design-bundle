<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Controller;

use QuentinMachard\Bundle\AtomicDesignBundle\Menu\ComponentMenuBuilder;
use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Profiler\Profiler;

class StoryController extends AbstractController
{
    /** @var ComponentProvider */
    private $componentProvider;

    /** @var string */
    private $cssEntryName;

    /** @var string */
    private $jsEntryName;

    /** @var ComponentMenuBuilder */
    private $menuBuilder;

    public function __construct(
        string $cssEntryName = '',
        string $jsEntryName = '',
        ComponentProvider $componentProvider,
        Profiler $profiler,
        ComponentMenuBuilder $menuBuilder
    ) {
        $profiler->disable();

        $this->componentProvider = $componentProvider;
        $this->cssEntryName = $cssEntryName;
        $this->jsEntryName = $jsEntryName;
        $this->menuBuilder = $menuBuilder;
    }

    public function index(): Response
    {
        return $this->render('@AtomicDesign/index.html.twig', [
            'menu' => $this->menuBuilder->createView(),
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
            'menu' => $this->menuBuilder->createView(),
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
            'css_entry_name' => $this->cssEntryName,
            'js_entry_name' => $this->jsEntryName,
        ]);
    }
}
