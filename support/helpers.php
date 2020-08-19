<?php

if (!function_exists('ai_picklist_api_infos')) {
    /**
     * Get package infos.
     *
     * @return object
     */
    function ai_picklist_api_infos()
    {
        return json_decode(file_get_contents(ai_picklist_api_path('support/infos.json')));
    }
}

if (!function_exists('ai_picklist_api_path')) {
    /**
     * Return the path of the resource relative to the package
     *
     * @param string $resource
     * @return string
     */
    function ai_picklist_api_path($resource = null)
    {
        if (!empty($resource) and substr($resource, 0, 1) != DIRECTORY_SEPARATOR) {
            $resource = DIRECTORY_SEPARATOR . $resource;
        }
        return dirname(__DIR__) . $resource;
    }
}
