<?php

namespace Antares\Picklist\Api\Http\Controllers;

use Antares\Picklist\Api\Http\PicklistApiHttpErrors;
use Antares\Picklist\Api\Http\PicklistApiJsonResponse;
use Antares\Picklist\PicklistException;
use Antares\Foundation\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PicklistApiController extends Controller
{
    private function getIdList(Request $request, $ids)
    {
        if ($ids == '_') {
            if ($request->has('data.ids')) {
                $ids = $request->input('data.ids');
            }
        }

        if (is_string($ids)) {
            $ids = explode('|', $ids);
        }

        if (!is_array($ids)) {
            return PicklistApiJsonResponse::error(PicklistApiHttpErrors::INVALID_PICKLIST_IDS, null, $ids);
        }

        $idList = [];
        foreach ($ids as $id) {
            $id = trim($id);
            if (!Str::icIn($id, '', '_')) {
                $idList[] = trim($id);
            }
        }

        if (empty($idList)) {
            return PicklistApiJsonResponse::error(PicklistApiHttpErrors::NO_PICKLIST_SUPPLIED);
        }

        return $idList;
    }

    public function get(Request $request, $ids)
    {
        $idList = $this->getIdList($request, $ids);
        if ($idList instanceof \Illuminate\Http\JsonResponse) {
            return $idList;
        }

        $successful = [];
        $error = [];

        foreach ($idList as $id) {
            try {
                $picklist = picklists()->get($id);
                $successful[$id] = $picklist->getData();
            } catch (PicklistException $e) {
                $error[$id] = PicklistApiJsonResponse::error(PicklistApiHttpErrors::PICKLIST_NOT_FOUND)->getData();
            }
        }

        $resultData = [
            'successful' => $successful,
            'error' => $error,
        ];

        if (!empty($successful) and empty($error)) {
            return PicklistApiJsonResponse::successful($resultData);
        }

        return PicklistApiJsonResponse::error(empty($successful) ? PicklistApiHttpErrors::REQUEST_ERROR : PicklistApiHttpErrors::PARTIALLY_SUCCESSFUL, null, $resultData);
    }
}
