Installation
============

Atomic Design requires PHP 7.2 or higher and Symfony 5.1 or higher.

Run the following command to install it in your application:

.. code-block:: bash

    $ composer require --dev qmachard/atomic-design-bundle

Manual Installation
-------------------

Step 1: Enabled the Bundle
~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    // config/bundles.php
    return [
       // ...
       QuentinMachard\Bundle\AtomicDesignBundle\AtomicDesignBundle::class => ['dev' => true],
    ];

Step 2: Configure the Bundle
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Create file ``atomic_design.yaml`` into ``config/packages/dev`` folder. Setting you Encore entry points (default ``app``).

.. code-block:: yaml

    # config/packages/dev/atomic_design.yaml
    atomic_design:
      css_entry_name: 'app'
      js_entry_name: 'app'

Example of Webpack configuration using ``app`` entry point.

.. code-block:: javascript

    var Encore = require('@symfony/webpack-encore');

    Encore
        // ...
        .addEntry('app', './assets/js/app.js');

    module.exports = Encore.getWebpackConfig();


Step 3: Configure Routes
~~~~~~~~~~~~~~~~~~~~~~~~

Create file ``atomic_design.yaml`` into ``config/routes/dev`` folder.

.. code-block:: yaml

    # config/routes/dev/atomic_design.yaml
    _atomic_design:
      resource: '@AtomicDesignBundle/Resources/config/routing/atomic_design.xml'
      prefix: /_atomic-design

Routes will be defined only for ``dev`` environment.

Step 4: Configure your Components
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

* Create file ``services_dev.yaml`` (is not already exists) in ``config`` folder and add this configuration.

.. code-block:: yaml

    # config/services_dev.yaml
    services:
      App\Tests\AtomicDesign\:
        resource: '../tests/AtomicDesign'
        tags: ['atomic_design.component']
        autoconfigure: true
        autowire: true

* Create ``./tests/AtomicDesign/`` folder.

Step 5: Install assets and clear cache
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: yaml

    $ php bin/console assets:install
    $ php bin/console cache:clear

Create your First Component "Playground"
========================================

You just need to create all "Component" class you want.

*Each story is a callable method names like the story*

.. code-block:: php

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
                'Default' => 'default', // This will call ``$this->default()`` method.
                'Colors' => 'colors',   // This will call ``$this->colors()`` method.
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
