<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Master\Field\FieldController;
use App\Http\Controllers\Admin\Master\TagController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//field
Route::get('/field', [FieldController::class, 'apiData']);
//tags
Route::get('/tags.json', [TagController::class, 'apiData']);