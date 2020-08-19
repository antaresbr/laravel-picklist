<?php

namespace Antares\Picklist\Api\Tests;

use Antares\Picklist\Api\Providers\PicklistApiServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PicklistApiServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        if (!defined('PICKLIST_DATA')) {
            define('PICKLIST_DATA', ai_picklist_api_path('tests/data'));
        }
    }
}
