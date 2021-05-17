<?php

declare(strict_types=1);

namespace QuentinMachard\Bundle\AtomicDesignBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class StoryControllerTest extends WebTestCase
{
    public function testDisplayComponentStory()
    {
        $client = static::createClient();

        $client->request('GET', '/_atomic-design/Atoms|Alert?story=colors');

        $this->assertResponseIsSuccessful();
    }
}
