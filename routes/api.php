<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/alive', function (Request $request) {
    return response()->json([
        'package' => ai_picklist_api_infos(),
        'env' => app()->environmentFile(),
        'serverDateTime' => Carbon::now()->toString(),
    ]);
});

$authApi = config('picklist_api.auth.api');
if (!empty($authApi)) {
    Route::middleware($authApi)->get('/get/{ids}', 'PicklistApiController@get');
} else {
    Route::get('/get/{ids}', 'PicklistApiController@get');
}
