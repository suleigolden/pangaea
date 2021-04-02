<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;

class PublisherControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * Test that you can create a puslish a message.
     *
     * @return void
     */
    public function test_can_publish_message()
    {
        $faker = Factory::create();
        $response = $this->json('POST','/api/publish/topic', [
            'topic' => $faker->word

        ]);
        $response->assertJsonStructure([
            'message','data',
        ])->assertStatus(201);

    }
}
