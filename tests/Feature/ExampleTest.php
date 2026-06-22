<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $bufferLevel = ob_get_level();

        $response = $this->get('/');

        while (ob_get_level() > $bufferLevel) {
            ob_end_clean();
        }

        $response->assertStatus(200);
    }
}
