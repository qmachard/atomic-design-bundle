<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class StoryControllerTest extends WebTestCase
{
    public function testRedirectToFirstComponent()
    {
        $client = static::createClient();

        $client->request('GET', '/_atomic-design/');

        $response = $client->getResponse();

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/_atomic-design/Atoms|Alert?story=colors', $response->headers->get('location'));
    }

    public function testDisplayComponent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/_atomic-design/Atoms|Alert');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertPageTitleSame('Atoms|Alert / colors - Atomic Design');
        $this->assertSelectorExists('.render_iframe');

        $iframe = $crawler->filter('.render_iframe')->first();

        $this->assertEquals('/_atomic-design/Atoms|Alert/colors/embed', $iframe->attr('src'));
    }

    public function testDisplayComponentStory()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/_atomic-design/Atoms|Button?story=outlines');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertPageTitleSame('Atoms|Button / outlines - Atomic Design');
        $this->assertSelectorExists('.render_iframe');

        $iframe = $crawler->filter('.render_iframe')->first();

        $this->assertEquals('/_atomic-design/Atoms|Button/outlines/embed', $iframe->attr('src'));
    }

    public function testHaveComponentsMenu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/_atomic-design/Atoms|Alert');

        $this->assertSelectorExists('.menu > .menu_categories > .menu_categories_item');

        $categories = $crawler->filter('.menu > .menu_categories > .menu_categories_item');

        $this->assertEquals(2, $categories->count());

        $dataSet = [
            [
                'category_name' => 'Atoms',
                'components' => [
                    [
                        'component_name' => 'Alert',
                        'stories' => [
                            [
                                'story_name' => 'Colors',
                                'story_link' => '/_atomic-design/Atoms|Alert?story=colors'
                            ],
                        ],
                        'stories_count' => 1,
                    ],
                    [
                        'component_name' => 'Button',
                        'stories' => [
                            [
                                'story_name' => 'Colors',
                                'story_link' => '/_atomic-design/Atoms|Button?story=colors'
                            ],
                            [
                                'story_name' => 'Outlines',
                                'story_link' => '/_atomic-design/Atoms|Button?story=outlines'
                            ],
                            [
                                'story_name' => 'Sizes',
                                'story_link' => '/_atomic-design/Atoms|Button?story=sizes'
                            ],
                        ],
                        'stories_count' => 3,
                    ],
                ],
                'components_count' => 2,
            ],
            [
                'category_name' => 'Molecules',
                'components' => [
                    [
                        'component_name' => 'Card',
                        'stories' => [
                            [
                                'story_name' => 'Default',
                                'story_link' => '/_atomic-design/Molecules|Card?story=default'
                            ],
                            [
                                'story_name' => '+ image',
                                'story_link' => '/_atomic-design/Molecules|Card?story=withImage'
                            ],
                        ],
                        'stories_count' => 2,
                    ],
                ],
                'components_count' => 1,
            ],
        ];

        foreach ($dataSet as $i => $expectedCategory) {
            $category = $categories->eq($i);

            $this->assertEquals($expectedCategory['category_name'], $category->filter('.menu_categories_label')->first()->text());

            $components = $category->filter('.menu_components > .menu_components_item');

            $this->assertEquals($expectedCategory['components_count'], $components->count());

            foreach ($expectedCategory['components'] as $j => $expectedComponent) {
                $component = $components->eq($j);

                $this->assertEquals($expectedComponent['component_name'], $component->filter('.menu_components_label')->first()->text());

                $stories = $component->filter('.menu_stories > .menu_stories_item');

                $this->assertEquals($expectedComponent['stories_count'], $stories->count());

                foreach ($expectedComponent['stories'] as $k => $expectedStory) {
                    $story = $stories->eq($k);
                    $storyLink = $story->filter('.menu_stories_link')->first();

                    $this->assertEquals($expectedStory['story_name'], $storyLink->text());
                    $this->assertEquals($expectedStory['story_link'], $storyLink->attr('href'));
                }
            }
        }
    }

    public function testThrowNotFoundWhenComponentNotFound()
    {
        $client = static::createClient();

        $client->request('GET', '/_atomic-design/NotFound|Component');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
