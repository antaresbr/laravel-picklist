<?php

namespace Antares\Picklist\Api\Http;

use Antares\Http\AbstractHttpErrors;

class PicklistApiHttpErrors extends AbstractHttpErrors
{
    public const REQUEST_ERROR = 992001;
    public const PARTIALLY_SUCCESSFUL = 992002;
    public const NO_PICKLIST_SUPPLIED = 992003;
    public const PICKLIST_NOT_FOUND = 992004;
    public const INVALID_PICKLIST_IDS = 992005;

    public const MESSAGES = [
        self::REQUEST_ERROR => 'picklist_api::errors.request_error',
        self::PARTIALLY_SUCCESSFUL => 'picklist_api::errors.partially_successful',
        self::NO_PICKLIST_SUPPLIED => 'picklist_api::errors.no_picklist_supplied',
        self::PICKLIST_NOT_FOUND => 'picklist_api::errors.picklist_not_found',
        self::INVALID_PICKLIST_IDS => 'picklist_api::errors.invalid_picklist_ids',
    ];
}
