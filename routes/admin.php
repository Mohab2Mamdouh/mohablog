<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PersonalController;
use App\Http\Controllers\Admin\SkillsController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\workcontroller;
use App\Http\Controllers\Admin\LanguageController;


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


Route::controller(HomeController::class)->group(function ()
{
    // Dashboard
    Route::get('/home', 'index')->name('home');
});

Route::prefix('personal')->name('info.')->controller(PersonalController::class)->group(function ()
{
    // Update Persenol Info
    Route::get('/show', 'show')->name('show');
    Route::get('/edit', 'edit')->name('edit');
    Route::post('/update', 'update')->name('update');

    // Update Profile Image
    Route::post('/updateProfileImage', 'updateProfileImage')->name('image');
});


Route::prefix('skills')->name('skills.')->controller(SkillsController::class)->group(function ()
{
    // Show Skill
    Route::get('/show', 'index')->name('show');

    // Add New Skill
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');

    // Update Skill
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');

    // Delete Skill
    Route::get('/{id}/delete', 'destroy')->name('delete');
});


Route::prefix('projects')->name('projects.')->controller(ProjectController::class)->group(function ()
{
    // Show Projects
    Route::get('show', 'index')->name('show');

    // Add New Project
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');

    // Update Project
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');

    // Delete Project
    Route::get('/{id}/delete', 'destroy')->name('delete');
});

Route::prefix('works')->name('works.')->controller(workcontroller::class)->group(function ()
{
    // Show Work Experiences
    Route::get('/show', 'index')->name('show');

    // Add New Work Experience
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');

    // Update Work Experience
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');

    // Delete Work Experience
    Route::get('/{id}/delete', 'destroy')->name('delete');
});


Route::prefix('speaking-language')->name('langs.')->controller(LanguageController::class)->group(function ()
{
    // Show Speaking Language
    Route::get('/show', 'index')->name('show');

    // Add New Speaking Language
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');

    // Update Speaking Language
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');

    // Delete Speaking Language
    Route::get('/{id}/delete', 'destroy')->name('delete');
});

