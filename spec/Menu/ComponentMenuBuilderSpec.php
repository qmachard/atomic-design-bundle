<?php

namespace spec\QuentinMachard\Bundle\AtomicDesignBundle\Menu;

use PhpSpec\ObjectBehavior;
use QuentinMachard\Bundle\AtomicDesignBundle\Menu\ComponentMenuBuilder;
use QuentinMachard\Bundle\AtomicDesignBundle\Menu\ComponentMenuBuilderInterface;
use QuentinMachard\Bundle\AtomicDesignBundle\Model\ComponentInterface;
use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProviderInterface;

class ComponentMenuBuilderSpec extends ObjectBehavior
{
    private $componentProvider;
    private $someComponent;
    private $anotherComponent;

    function let(
        ComponentProviderInterface $componentProvider,
        ComponentInterface $someComponent,
        ComponentInterface $anotherComponent
    ) {
        $this->beConstructedWith($componentProvider);

        $someComponent->getName()->willReturn('Some Component');
        $someComponent->getStories()->willReturn(['Some Story', 'Another Story']);

        $anotherComponent->getName()->willReturn(' Another Component');
        $anotherComponent->getStories()->willReturn([]);

        $componentProvider->getComponents()->willReturn([$someComponent, $anotherComponent]);

        $this->componentProvider = $componentProvider;
        $this->someComponent = $someComponent;
        $this->anotherComponent = $anotherComponent;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ComponentMenuBuilder::class);

        $this->shouldImplement(ComponentMenuBuilderInterface::class);
    }

    function it_should_build_empty_menu_when_no_components()
    {
        $this->componentProvider->getComponents()->willReturn([]);

        $result = $this->createView();
        $result->shouldBeArray();
        $result->shouldHaveCount(0);
    }

    function it_should_build_menu_for_resolved_components()
    {
        $result = $this->createView();
        $result->shouldBeArray();
        $result->shouldHaveCount(1);
        $result->shouldHaveKey('Default');

        $result['Default']->shouldBeArray();
        $result['Default']->shouldHaveCount(2);
        $result['Default']->shouldHaveKey('Some Component');
        $result['Default']->shouldHaveKey('Another Component');

        $result['Default']['Some Component']->shouldBeArray();
        $result['Default']['Some Component']->shouldHaveCount(2);
        $result['Default']['Some Component']->shouldContain('Some Story');
        $result['Default']['Some Component']->shouldContain('Another Story');

        $result['Default']['Another Component']->shouldBeArray();
        $result['Default']['Another Component']->shouldHaveCount(0);
    }

    function it_should_build_menu_with_parsed_category()
    {
        $this->someComponent->getName()->willReturn('Some Category|Some Component');
        $this->anotherComponent->getName()->willReturn('Another Category | Another Component');

        $result = $this->createView();
        $result->shouldBeArray();
        $result->shouldHaveCount(2);
        $result->shouldHaveKey('Some Category');
        $result->shouldHaveKey('Another Category');

        $result['Some Category']->shouldBeArray();
        $result['Some Category']->shouldHaveCount(1);
        $result['Some Category']->shouldHaveKey('Some Component');
        $result['Some Category']->shouldNotHaveKey('Another Component');

        $result['Another Category']->shouldBeArray();
        $result['Another Category']->shouldHaveCount(1);
        $result['Another Category']->shouldHaveKey('Another Component');
        $result['Another Category']->shouldNotHaveKey('Some Component');

        $result['Some Category']['Some Component']->shouldBeArray();
        $result['Some Category']['Some Component']->shouldHaveCount(2);
        $result['Some Category']['Some Component']->shouldContain('Some Story');
        $result['Some Category']['Some Component']->shouldContain('Another Story');

        $result['Another Category']['Another Component']->shouldBeArray();
        $result['Another Category']['Another Component']->shouldHaveCount(0);
    }

    function it_should_build_menu_with_only_one_level_parsed_category()
    {
        $this->someComponent->getName()->willReturn('Some Category|Some | Component');
        $this->anotherComponent->getName()->willReturn('Another Category | Another|Component');

        $result = $this->createView();
        $result->shouldBeArray();
        $result->shouldHaveCount(2);
        $result->shouldHaveKey('Some Category');
        $result->shouldHaveKey('Another Category');

        $result['Some Category']->shouldBeArray();
        $result['Some Category']->shouldHaveCount(1);
        $result['Some Category']->shouldHaveKey('Some | Component');

        $result['Another Category']->shouldBeArray();
        $result['Another Category']->shouldHaveCount(1);
        $result['Another Category']->shouldHaveKey('Another|Component');
    }

    function it_should_build_menu_with_another_level_separator()
    {
        $this->someComponent->getName()->willReturn('Some Category//Some Component');
        $this->anotherComponent->getName()->willReturn('Another Category//Another Component');

        $this->beConstructedWith($this->componentProvider, '//');

        $result = $this->createView();
        $result->shouldBeArray();
        $result->shouldHaveCount(2);
        $result->shouldHaveKey('Some Category');
        $result->shouldHaveKey('Another Category');
    }
}
