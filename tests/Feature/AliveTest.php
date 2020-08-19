<?php

namespace Antares\Picklist\Api\Tests\Feature;

use Antares\Picklist\Api\Tests\TestCase;

class AliveTest extends TestCase
{
    /** @test */
    public function get_alive()
    {
        $response = $this->get(config('picklist_api.route.prefix.api') . '/alive');
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertArrayHasKey('package', $json);
        $this->assertArrayHasKey('env', $json);
        $this->assertArrayHasKey('serverDateTime', $json);
    }
}
