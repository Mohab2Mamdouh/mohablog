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
    Route::get('/portfolio', function () {
        return redirect(route('portfolio'));
    })->name('home.portfolio');
    Route::get('/downloadPDF','downloadPDF')->name('downloadPDF');
    Route::get('/PDF/view/','pdfview')->name('viewPDF');
    Route::get('/PDF/view2/','pdfview2')->name('viewPDF2');
});

Route::get('/', [UserHomeController::class, 'index'])->name('portfolio');

// Design Templates Preview Routes
Route::get('/template/terminal', [UserHomeController::class, 'templateTerminal'])->name('template.terminal');
Route::get('/template/code-first', [UserHomeController::class, 'templateCodeFirst'])->name('template.code-first');
Route::get('/template/architecture', [UserHomeController::class, 'templateArchitecture'])->name('template.architecture');
Route::get('/template/minimalist', [UserHomeController::class, 'templateMinimalist'])->name('template.minimalist');

Auth::routes();

// Optimize Clear Route
Route::get('/artisan/optimize-clear', function () {
    try {
        Artisan::call('optimize:clear');
        return response()->json([
            'status' => 'success',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Route Clear Route tets
Route::get('/artisan/route-clear', function () {
    try {
        Artisan::call('route:clear');
        return response()->json([
            'status' => 'success',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// cache Clear
Route::get('/artisan/cache-clear', function () {
    try {
        Artisan::call('cache:clear');
        return response()->json([
            'status' => 'success',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

