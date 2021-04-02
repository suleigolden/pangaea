<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;

class SubcriptionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_a_subscription()
    {

        $faker = Factory::create();
        $response = $this->json('POST','/api/subscribe/topic', [
            
            'url' => 'https://thelastcodebender.com',
            'topic' => $faker->word

        ]);
        $response->assertJsonStructure([
            'url','topic',
        ])->assertStatus(201);

    }
}
