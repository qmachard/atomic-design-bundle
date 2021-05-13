<?php

namespace spec\QuentinMachard\Bundle\AtomicDesignBundle\ParamConverter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use QuentinMachard\Bundle\AtomicDesignBundle\Model\Component;
use QuentinMachard\Bundle\AtomicDesignBundle\Model\ComponentInterface;
use QuentinMachard\Bundle\AtomicDesignBundle\ParamConverter\ComponentParamConverter;
use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProviderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ComponentParamConverterSpec extends ObjectBehavior
{
    private $componentProvider;
    private $configuration;

    function let(ComponentProviderInterface $componentProvider, ParamConverter $paramConverter)
    {
        $this->beConstructedWith($componentProvider);

        $paramConverter->getName()->willReturn('component');
        $paramConverter->getClass()->willReturn(Component::class);

        $this->componentProvider = $componentProvider;
        $this->configuration = $paramConverter;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ComponentParamConverter::class);
        $this->shouldImplement(ParamConverterInterface::class);
    }

    function it_should_support_component(
        ParamConverter $supportedParamConverter,
        ParamConverter $anotherSupportedParamConverter,
        ParamConverter $unsupportedParamConverter
    ) {
        $supportedParamConverter->getClass()->willReturn(ComponentInterface::class);
        $anotherSupportedParamConverter->getClass()->willReturn(Component::class);
        $unsupportedParamConverter->getClass()->willReturn('AnotherClass');

        $this->supports($supportedParamConverter)->shouldReturn(true);
        $this->supports($anotherSupportedParamConverter)->shouldReturn(true);
        $this->supports($unsupportedParamConverter)->shouldReturn(false);
    }

    function it_should_apply_component_to_request(
        Request $request,
        ParameterBag $attributes,
        ComponentInterface $component
    ) {
        $request->attributes = $attributes;

        $attributes->get('component')->willReturn('Default|SomeComponent');

        $this->componentProvider->getComponent('Default|SomeComponent')
            ->willReturn($component);

        $this->apply($request, $this->configuration)
            ->shouldReturn(true);

        $attributes->set('component', $component)
            ->shouldHaveBeenCalled();
    }

    function it_should_throw_not_found_exception_when_component_is_not_found(
        Request $request,
        ParameterBag $attributes
    ) {
        $request->attributes = $attributes;

        $attributes->get('component')->willReturn('Default|SomeComponent');

        $this->componentProvider->getComponent('Default|SomeComponent')
            ->willReturn(null);

        $this->shouldThrow(NotFoundHttpException::class)
            ->during('apply', [$request, $this->configuration]);

        $attributes->set('component', Argument::any())
            ->shouldNotHaveBeenCalled();
    }

    function it_should_return_false_if_object_is_not_successfully_set(
        Request $request,
        ParameterBag $attributes
    ) {
        $request->attributes = $attributes;

        $attributes->get('component')->willReturn(null);

        $this->apply($request, $this->configuration)
            ->shouldReturn(false);

        $attributes->set('component', Argument::any())
            ->shouldNotHaveBeenCalled();
    }
}
