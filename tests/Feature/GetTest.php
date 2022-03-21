<?php
namespace Antares\Picklist\Api\Tests\Feature;

use Antares\Picklist\Api\Http\PicklistApiHttpErrors;
use Antares\Picklist\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class GetTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function get_with_empty_id()
    {
        $response = $this->get(config('picklist_api.route.prefix.api') . '/get/_');
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertArrayHasKey('status', $json);
        $this->assertEquals('error', $json['status']);
        $this->assertArrayHasKey('code', $json);
        $this->assertEquals(PicklistApiHttpErrors::NO_PICKLIST_SUPPLIED, $json['code']);
        $this->assertArrayHasKey('message', $json);
        $this->assertEquals(__(PicklistApiHttpErrors::MESSAGES[PicklistApiHttpErrors::NO_PICKLIST_SUPPLIED]), $json['message']);
    }

    /** @test */
    public function get_with_not_found_id()
    {
        $response = $this->get(config('picklist_api.route.prefix.api') . '/get/dummy_id');
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertArrayHasKey('status', $json);
        $this->assertEquals('error', $json['status']);
        $this->assertArrayHasKey('code', $json);
        $this->assertEquals(PicklistApiHttpErrors::REQUEST_ERROR, $json['code']);
        $this->assertArrayHasKey('message', $json);
        $this->assertEquals(__(PicklistApiHttpErrors::MESSAGES[PicklistApiHttpErrors::REQUEST_ERROR]), $json['message']);
        $this->assertArrayHasKey('data', $json);
        $this->assertArrayHasKey('successful', $json['data']);
        $this->assertIsArray($json['data']['successful']);
        $this->assertEmpty($json['data']['successful']);
        $this->assertArrayHasKey('error', $json['data']);
        $this->assertIsArray($json['data']['error']);
        $this->assertArrayHasKey('dummy_id', $json['data']['error']);
        $this->assertIsArray($json['data']['error']['dummy_id']);
        $this->assertArrayHasKey('status', $json['data']['error']['dummy_id']);
        $this->assertEquals('error', $json['data']['error']['dummy_id']['status']);
        $this->assertArrayHasKey('code', $json['data']['error']['dummy_id']);
        $this->assertEquals(PicklistApiHttpErrors::PICKLIST_NOT_FOUND, $json['data']['error']['dummy_id']['code']);
        $this->assertArrayHasKey('message', $json['data']['error']['dummy_id']);
        $this->assertEquals(__(PicklistApiHttpErrors::MESSAGES[PicklistApiHttpErrors::PICKLIST_NOT_FOUND]), $json['data']['error']['dummy_id']['message']);
    }

    /** @test */
    public function get_successful()
    {
        $response = $this->get(config('picklist_api.route.prefix.api') . '/get/fruits');
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertArrayHasKey('status', $json);
        $this->assertEquals('successful', $json['status']);
        $this->assertArrayHasKey('data', $json);
        $this->assertIsArray($json['data']);

        $this->assertArrayHasKey('successful', $json['data']);
        $this->assertIsArray($json['data']['successful']);
        $this->assertCount(1, $json['data']['successful']);
        $this->assertArrayHasKey('fruits', $json['data']['successful']);
        $this->assertIsArray($json['data']['successful']['fruits']);
        $this->assertCount(4, $json['data']['successful']['fruits']);

        $this->assertArrayHasKey('error', $json['data']);
        $this->assertIsArray($json['data']['error']);
        $this->assertEmpty($json['data']['error']);
    }

    /** @test */
    public function get_partially_successful()
    {
        $response = $this->get(config('picklist_api.route.prefix.api') . '/get/fruits||brands|_|other.fruits|dummy_id|other.cities.brasil.goias');
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertArrayHasKey('status', $json);
        $this->assertEquals('error', $json['status']);
        $this->assertArrayHasKey('code', $json);
        $this->assertEquals(PicklistApiHttpErrors::PARTIALLY_SUCCESSFUL, $json['code']);
        $this->assertArrayHasKey('message', $json);
        $this->assertEquals(__(PicklistApiHttpErrors::MESSAGES[PicklistApiHttpErrors::PARTIALLY_SUCCESSFUL]), $json['message']);
        $this->assertArrayHasKey('data', $json);
        $this->assertArrayHasKey('successful', $json['data']);
        $this->assertIsArray($json['data']['successful']);
        $this->assertCount(4, $json['data']['successful']);
        $this->assertArrayHasKey('fruits', $json['data']['successful']);
        $this->assertArrayHasKey('brands', $json['data']['successful']);
        $this->assertArrayHasKey('other.fruits', $json['data']['successful']);
        $this->assertArrayHasKey('other.cities.brasil.goias', $json['data']['successful']);
        $this->assertArrayHasKey('error', $json['data']);
        $this->assertIsArray($json['data']['error']);
        $this->assertArrayHasKey('dummy_id', $json['data']['error']);
        $this->assertIsArray($json['data']['error']['dummy_id']);
        $this->assertArrayHasKey('status', $json['data']['error']['dummy_id']);
        $this->assertEquals('error', $json['data']['error']['dummy_id']['status']);
        $this->assertArrayHasKey('code', $json['data']['error']['dummy_id']);
        $this->assertEquals(PicklistApiHttpErrors::PICKLIST_NOT_FOUND, $json['data']['error']['dummy_id']['code']);
        $this->assertArrayHasKey('message', $json['data']['error']['dummy_id']);
        $this->assertEquals(__(PicklistApiHttpErrors::MESSAGES[PicklistApiHttpErrors::PICKLIST_NOT_FOUND]), $json['data']['error']['dummy_id']['message']);
    }
}
