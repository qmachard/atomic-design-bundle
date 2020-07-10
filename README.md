<h1 align="center">
    <img src="./doc/atomic-design.png" alt="atomic-design" />
    <br />
    <a href="./LICENSE.md" title="Licence MIT">
        <img src="https://img.shields.io/packagist/l/qmachard/atomic-design-bundle" />
    </a>
    <a href="https://packagist.org/packages/qmachard/atomic-design-bundle" title="Packagist">
        <img src="https://img.shields.io/packagist/v/qmachard/atomic-design-bundle?include_prereleases" />
    </a>
    <a href="https://packagist.org/packages/qmachard/atomic-design-bundle" title="PHP 7.3">
        <img src="https://img.shields.io/packagist/php-v/qmachard/atomic-design-bundle" />
    </a>
</h1>

Atomic Design is a StoryBook like bundle made for Symfony.

Installation
------------

Atomic Design requires PHP 7.2 or higher and Symfony 5.1 or higher.

Run the following command to install it in your application:

```bash
$ composer require --dev qmachard/atomic-design-bundle
```

Manual Installation
-------------------

1. Enabled the Bundle

    ```php
    // config/bundles.php
    return [
       // ...
       QuentinMachard\Bundle\AtomicDesignBundle\AtomicDesignBundle::class => ['dev' => true],
    ];
    ```

1. Configure Bundle

    Create file `atomic_design.yaml` into `config/packages/dev` folder. Setting you Encore entry points.
    
    ```yaml
    # config/packages/dev/atomic_design.yaml
    atomic_design:
      css_entry_name: 'app'
      js_entry_name: 'app'
    ```

1. Configure Routes

    Create file `atomic_design.yaml` into `config/routes/dev` folder.
    
    ```yaml
    # config/routes/dev/atomic_design.yaml
    _atomic_design:
      resource: '@AtomicDesignBundle/Resources/config/routing/atomic_design.xml'
      prefix: /_atomic-design
    ```

    Routes will be defined only for `dev` environment.

1. Configure your Components

    Create file `service_dev.yaml` (is not already exists) in `config` folder and add this configuration
    
    ```yaml
    # config/service_dev.yaml
    services:
      App\Tests\AtomicDesign\:
        resource: '../tests/AtomicDesign'
        tags: ['atomic_design.component']
        autoconfigure: true
        autowire: true
    ```

Create your First Component "Playground"
-------------------------------------

You just need to create all "Component" class you want.

*Each story is a callable method names like the story*

```php
// tests/AtomicDesign/Components/ButtonComponent.php
namespace App\Tests\AtomicDesign\Components;

use QuentinMachard\Bundle\AtomicDesignBundle\Model\Component;

class ButtonComponent extends Component
{
    /**
     * Return the name of component (before pipe is Category).
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Atoms|Button';
    }

    /**
     * Return list of stories for component.
     * 
     * @return string[]
     */
    public function getStories(): array
    {
        return [
            'Default' => 'default', // This will call `$this->default()` method.
            'Colors' => 'colors',   // This will call `$this->colors()` method.
        ];
    }

    /**
     * A simple story.
     *
     * @return string
     */
    public function default(): string
    {
        return $this->render('@components/atoms/button/button.html.twig', [
            'props' => [
                'label' => 'My awesome button',
            ]
        ]);
    }

    /**
     * A full example story.
     *
     * @return string
     */
    public function colors(): string
    {
        $colors = ['primary', 'secondary'];

        $buttons = [];

        foreach ($colors as $color) {
            $buttons[] = $this->render('@components/atoms/button/button.html.twig', [
                'props' => [
                    'label' => ucfirst($color),
                    'class_modifiers' => [$color]
                ]
            ]);
        }

        return join(' ', $buttons);
    }
}
```

Contributing
------------

Read the [Contributing Guide](CONTRIBUTING.md) and feel free to open a pull-request! 🍻

Licence
-------

This software is published under the [MIT License](LICENSE.md)

Authors
-------

Atomic Design was originally created with heart by [Quentin Machard](https://twitter.com/quentinmachard).
