<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserHomeController;


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



Route::controller(UserHomeController::class)->group(function ()
{
    Route::get('/portfolio', 'index')->name('portfolio');
    Route::get('/downloadPDF','downloadPDF')->name('downloadPDF');
    Route::get('/PDF/view/','pdfview')->name('viewPDF');
    Route::get('/PDF/view2/','pdfview2')->name('viewPDF2');
});

Route::get('/', function ()
{
    return redirect(route('portfolio'));
});

Auth::routes();
