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

    /** @var string */
    private $cssPath;

    /** @var string */
    private $jsPath;

    public function __construct(ComponentProvider $componentProvider, Profiler $profiler, string $cssPath = '', string $jsPath = '')
    {
        $profiler->disable();

        $this->componentProvider = $componentProvider;
        $this->cssPath = $cssPath;
        $this->jsPath = $jsPath;
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
            'css_path' => $this->cssPath,
            'js_path' => $this->jsPath,
        ]);
    }
}
