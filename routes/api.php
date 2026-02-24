<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\SpeakingLanguageApiController;
use App\Http\Controllers\Api\SkillsApiController;
use App\Http\Controllers\Api\ProjectsApiController;
use App\Http\Controllers\Api\WorkExpsApiController;
use App\Http\Controllers\Api\FeedbackApiController;

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


Route::prefix('users')->controller(UserApiController::class)->group(function ()
{
    Route::get('show-all', 'showAll');
    Route::put('update/{user}', 'update');
});

Route::prefix('speaking-languages')->controller(SpeakingLanguageApiController::class)->group(function ()
{
    Route::get('show-all ', 'showAll');

    Route::post('create', 'create');

    Route::put('update/{lang}', 'update');

    Route::delete('delete/{lang}', 'delete');
});


Route::prefix('skills')->controller(SkillsApiController::class)->group(function ()
{
    // Show Endpoint
    Route::get('show-all', 'showAll');

    Route::get('show/{skill}', 'show');

    // Create Endpoint
    Route::post('create', 'create');

    Route::put('update/{skill}', 'update');

    Route::delete('delete/{skill}', 'delete');
});

Route::prefix('projects')->controller(ProjectsApiController::class)->group(function ()
{
    Route::get('show-all', 'showAll');

    Route::get('show/{project}', 'show');

    Route::post('create', 'create');

    Route::put('update/{project}', 'update');

    Route::delete('delete/{project}', 'delete');
});

Route::prefix('work-exps')->controller(WorkExpsApiController::class)->group(function ()
{
    Route::get('show-all', 'showAll');

    Route::get('show/{work}', 'show');

    Route::post('create', 'create');

    Route::put('update/{work}', 'update');

    Route::delete('delete/{work}', 'delete');
});

Route::prefix('feedbacks')->controller(FeedbackApiController::class)->group(function ()
{
    Route::get('show-all', 'showAll');

    Route::get('show/{feed}', 'show');

    Route::post('create', 'create');

    Route::put('update/{feed}', 'update');

    Route::delete('delete/{feed}', 'delete');
});
