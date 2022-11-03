<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::get('/', function () {
    return [
        'version' => '1.0.0'
    ];
});

Route::get('/rewards/search', [\App\Http\Controllers\Api\RewardController::class, 'search']);
Route::get('/reward_codes/search', [\App\Http\Controllers\Api\RewardCodeController::class, 'search']);
Route::get('/novels/search', [\App\Http\Controllers\Api\NovelController::class, 'search']);
Route::apiResource('/rewards', \App\Http\Controllers\Api\RewardController::class);
Route::apiResource('/reward_codes', \App\Http\Controllers\Api\RewardCodeController::class);
Route::apiResource('/novels',\App\Http\Controllers\Api\NovelController::class);
Route::apiResource('/novels/episodes',\App\Http\Controllers\Api\EpisodeController::class);
Route::apiResource('/commentNovels',\App\Http\Controllers\Api\CommentNovelController::class);
Route::apiResource('/commentEpisodes',\App\Http\Controllers\Api\CommentEpisodeController::class);
Route::apiResource('/tags',\App\Http\Controllers\Api\TagController::class);
Route::apiResource('/users',\App\Http\Controllers\Api\UserController::class);
Route::post('updateProfile/{id}', [\App\Http\Controllers\Api\UserController::class,'updateProfile']);
Route::post('NovelEdit/{id}', [\App\Http\Controllers\Api\NovelController::class,'NovelEdit']);


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
