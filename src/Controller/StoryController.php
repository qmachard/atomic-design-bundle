<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Controller;

use QuentinMachard\Bundle\AtomicDesignBundle\Menu\ComponentMenuBuilderInterface;
use QuentinMachard\Bundle\AtomicDesignBundle\Model\Component;
use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Profiler\Profiler;

class StoryController extends AbstractController
{
    /** @var string */
    private $cssEntryName;

    /** @var string */
    private $jsEntryName;

    /** @var string */
    private $cssPackageName;

    /** @var string */
    private $jsPackageName;

    /** @var ComponentProviderInterface */
    private $componentProvider;

    /** @var ComponentMenuBuilderInterface */
    private $menuBuilder;

    public function __construct(
        ?string $cssEntryName,
        ?string $jsEntryName,
        ?string $cssPackageName,
        ?string $jsPackageName,
        ComponentProviderInterface $componentProvider,
        ComponentMenuBuilderInterface $menuBuilder,
        ?Profiler $profiler
    ) {
        if (null !== $profiler) {
            $profiler->disable();
        }

        $this->componentProvider = $componentProvider;
        $this->cssEntryName = $cssEntryName;
        $this->jsEntryName = $jsEntryName;
        $this->cssPackageName = $cssPackageName;
        $this->jsPackageName = $jsPackageName;
        $this->menuBuilder = $menuBuilder;
    }

    public function index(): Response
    {
        $components = $this->componentProvider->getComponents();

        foreach ($components as $component) {
            foreach ($component->getStories() as $story) {
                return $this->redirectToRoute('_atomic_design_view', [
                    'component' => $component->getName(),
                    'story' => $story
                ]);
            }
        }

        throw new NotFoundHttpException('No Stories Found.');
    }

    public function view(Component $component, Request $request): Response
    {
        $story = $request->get('story', null);

        if (null === $story) {
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
            'css_package_name' => $this->cssPackageName,
            'js_package_name' => $this->jsPackageName,
        ]);
    }
}
