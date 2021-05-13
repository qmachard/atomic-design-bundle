<?php

namespace spec\QuentinMachard\Bundle\AtomicDesignBundle\Provider;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use QuentinMachard\Bundle\AtomicDesignBundle\Model\ComponentInterface;
use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProvider;
use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProviderInterface;

class ComponentProviderSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ComponentProvider::class);

        $this->shouldImplement(ComponentProviderInterface::class);
    }

    function it_should_allow_component_object_only(): void
    {
        $this->beConstructedWith(['some-object']);
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_should_resolve_empty_components(): void
    {
        $results = $this->getComponents();

        $results->shouldBeArray();
        $results->shouldHaveCount(0);
    }

    function it_should_resolve_all_passed_components(
        ComponentInterface $someComponent,
        ComponentInterface $anotherComponent
    ): void {
        $this->beConstructedWith([$someComponent, $anotherComponent]);

        $results = $this->getComponents();

        $results->shouldBeArray();
        $results->shouldHaveCount(2);
        $results->shouldContain($someComponent);
        $results->shouldContain($anotherComponent);
    }

    function it_should_resolve_null_when_no_found_component(
        ComponentInterface $someComponent
    ) {
        $this->beConstructedWith([$someComponent]);

        $someComponent->getName()->willReturn('some-component');

        $component = $this->getComponent('inexsitant-component');
        $component->shouldBeNull();
    }

    function it_should_resolve_some_component(
        ComponentInterface $someComponent,
        ComponentInterface $anotherComponent
    ): void {
        $this->beConstructedWith([$someComponent, $anotherComponent]);

        $someComponent->getName()->willReturn('some-component');
        $anotherComponent->getName()->willReturn('another-component');

        $component = $this->getComponent('some-component');
        $component->shouldBe($someComponent);

        $component = $this->getComponent('another-component');
        $component->shouldBe($anotherComponent);
    }
}
