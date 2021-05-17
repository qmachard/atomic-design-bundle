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

    public function testThrowNotFoundWhenComponentNotFound()
    {
        $client = static::createClient();

        $client->request('GET', '/_atomic-design/NotFound|Component');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
