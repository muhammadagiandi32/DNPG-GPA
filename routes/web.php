<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DnpgFileController;
use App\Http\Controllers\Users;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

// Route::get('/test', function () {
//     return view('dnpg.index');
// })->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Group Route Users
Route::middleware(['auth'])->group(function () {
    // route Users
    Route::middleware('checkPermission:Users Create')->prefix('users')->name('users.')->group(function () {
        Route::get('create', [Users::class, 'create'])->name('create');
        Route::post('', [Users::class, 'store'])->name('store');
    });
    Route::middleware('checkPermission:Users Edit')->prefix('users')->name('users.')->group(function () {
        Route::get('{users}/edit', [Users::class, 'edit'])->name('edit');
        Route::put('{users}', [Users::class, 'update'])->name('update');
    });
    Route::middleware('checkPermission:Users Delete')->prefix('users')->name('users.')->group(function () {
        Route::delete('{users}', [Users::class, 'destroy'])->name('destroy');
    });
    Route::middleware('checkPermission:Users Index')->prefix('users')->name('users.')->group(function () {
        Route::get(
            '',
            [Users::class, 'index']
        )->name('index');
    });
});

// Group Route DNPG
Route::middleware(['auth'])->group(function () {
    // Route DNPG
    Route::middleware('checkPermission:DNPG Create')->prefix('dnpg')->name('dnpg.')->group(function () {
        Route::get('create', [DnpgFileController::class, 'create'])->name('create');
        Route::post('', [DnpgFileController::class, 'store'])->name('store');
    });

    Route::middleware('checkPermission:DNPG Edit')->prefix('dnpg')->name('dnpg.')->group(function () {
        Route::get('{dnpg}/edit', [DnpgFileController::class, 'edit'])->name('edit');
        Route::put('{dnpg}', [DnpgFileController::class, 'update'])->name('update');
    });

    Route::middleware('checkPermission:DNPG Delete')->prefix('dnpg')->name('dnpg.')->group(function () {
        Route::delete('{dnpg}', [DnpgFileController::class, 'destroy'])->name('destroy');
    });

    Route::middleware('checkPermission:DNPG Index')->prefix('dnpg')->name('dnpg.')->group(function () {
        Route::get('', [DnpgFileController::class, 'index'])->name('index');
    });
});
