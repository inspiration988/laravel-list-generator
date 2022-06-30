<?php

use App\Http\Controllers\Api\v1\ListController;
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


//routes/api.php
Route::group(['prefix' => 'v1'], function () {
    Route::post('list/generate', [ListController::class, 'generate']);

});