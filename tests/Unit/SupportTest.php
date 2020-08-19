<?php declare(strict_types=1);

namespace Antares\Picklist\Api\Tests\Unit;

use Antares\Picklist\Api\Tests\TestCase;

final class SupportTest extends TestCase
{
    private function getPath()
    {
        return ai_picklist_api_path();
    }

    private function getInfos()
    {
        return ai_picklist_api_infos();
    }

    public function testHelpers()
    {
        $path = $this->getPath();
        $this->assertIsString($path);
        $this->assertEquals(substr(__DIR__, 0, strlen($path)), $path);

        $infos = $this->getInfos();
        $this->assertIsObject($infos);
    }

    public function testInfos()
    {
        $infos = $this->getInfos();
        $this->assertObjectHasAttribute('name', $infos);
        $this->assertObjectHasAttribute('version', $infos);
        $this->assertObjectHasAttribute('major', $infos->version);
        $this->assertObjectHasAttribute('release', $infos->version);
        $this->assertObjectHasAttribute('minor', $infos->version);
    }
}
