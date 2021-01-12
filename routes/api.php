<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReplyController;
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

Route::group(['prefix' => 'auth'], function () {
  // Login Route
  Route::post('/login', [AuthController::class, 'login']);
  // register Route
  Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['middleware' => 'auth:api'], function () {
  // Question Routes
  Route::apiResource('/questions', QuestionController::class);
  // Category Routes
  Route::apiResource('/category', CategoryController::class);
  // Reply Routes
  Route::apiResource('/question/{question}/reply', ReplyController::class);
  // Like Routes
  Route::post('/like/{reply}', [LikeController::class, 'likeIt']);
  Route::delete('/like/{reply}', [LikeController::class, 'unLikeIt']);
  // Logout and Refresh Routes
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::post('/refresh', [AuthController::class, 'refresh']);
  // Me Routes
  Route::post('/me', [AuthController::class,'me']);
});
