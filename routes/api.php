<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\WorkExpController;
use Illuminate\Support\Facades\Route;

Route::post('/token', [AuthController::class, 'token'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->name('api.')->group(function ()
{
    Route::delete('/token', [AuthController::class, 'revoke']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    Route::get('/export', ExportController::class);

    Route::post('/projects/order', [ProjectController::class, 'updateOrder']);
    Route::patch('/projects/{id}/toggle-cv', [ProjectController::class, 'toggleCV']);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('work-exps', WorkExpController::class);
    Route::apiResource('languages', LanguageController::class);
});
