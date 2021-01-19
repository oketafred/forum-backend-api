<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'Forum Backend API',
        'developer' => 'Oketa Fred',
        'email' => 'oketafred@gmail.com',
        'telephone_number' => '+256 787-584-128',
        'documentation_url' => env('L5_SWAGGER_CONST_HOST') . '/api/documentation'
    ]);
});
