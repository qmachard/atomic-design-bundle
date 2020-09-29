<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\ParamConverter;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\Component;
use QuentinMachard\Bundle\AtomicDesignBundle\Provider\ComponentProviderInterface;
use ReflectionClass;
use ReflectionException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ComponentParamConverter implements ParamConverterInterface
{
    /**
     * @var ComponentProviderInterface
     */
    private $componentProvider;

    public function __construct(ComponentProviderInterface $componentProvider)
    {
        $this->componentProvider = $componentProvider;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $class = $configuration->getClass();

        $componentName = $request->attributes->get($name);

        if (null === $componentName) {
            $configuration->setIsOptional(true);
        }

        $component = $this->componentProvider->getComponent($componentName);

        if (null === $component) {
            $message = sprintf('%s object not found by the @%s annotation.', $class, $this->getAnnotationName($configuration));

            throw new NotFoundHttpException($message);
        }

        $request->attributes->set($name, $component);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return Component::class === $configuration->getClass();
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return string
     * @throws ReflectionException
     */
    private function getAnnotationName(ParamConverter $configuration): string
    {
        $r = new ReflectionClass($configuration);

        return $r->getShortName();
    }
}
