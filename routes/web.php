<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DnpgFileController;
use App\Http\Controllers\Users;
use App\Models\User;
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
    // dd(User::with('roles')->get());
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
        Route::post('store', [Users::class, 'store'])->name('store');
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
            '/',
            [Users::class, 'index']
        )->name('index');
    });
});

// Group Route DNPG
Route::middleware(['auth'])->group(function () {
    // Route DNPG
    Route::middleware('checkPermission:DNPG Create')->prefix('dnpg')->name('dnpg.')->group(function () {
        Route::get('create', [DnpgFileController::class, 'create'])->name('create');
        Route::post('dnpg/store', [DnpgFileController::class, 'store'])->name('store');
    });

    Route::middleware('checkPermission:DNPG Edit')->prefix('dnpg')->name('dnpg.')->group(function () {
        Route::get('{dnpg}/edit', [DnpgFileController::class, 'edit'])->name('edit');
        Route::put('{dnpg}', [DnpgFileController::class, 'update'])->name('update');
    });

    Route::middleware('checkPermission:DNPG Delete')->prefix('dnpg')->name('dnpg.')->group(function () {
        Route::delete('{dnpg}', [DnpgFileController::class, 'destroy'])->name('destroy');
    });

    Route::middleware('checkPermission:DNPG Index')->prefix('dnpg')->name('dnpg.')->group(function () {
        Route::get('/', [DnpgFileController::class, 'index'])->name('index');
    });
});

// Route::middleware(['auth'])->group(function () {
//     // Route SJ
//     Route::middleware('checkPermission:SJ Create')->prefix('sj')->name('sj.')->group(function () {
//         Route::get('create', [SJController::class, 'create'])->name('create');
//         Route::post('sj/store', [SJController::class, 'store'])->name('store');
//     });

//     Route::middleware('checkPermission:SJ Edit')->prefix('sj')->name('sj.')->group(function () {
//         Route::get('{sj}/edit', [SJController::class, 'edit'])->name('edit');
//         Route::put('{sj}', [SJController::class, 'update'])->name('update');
//     });

//     Route::middleware('checkPermission:SJ Delete')->prefix('sj')->name('sj.')->group(function () {
//         Route::delete('{sj}', [SJController::class, 'destroy'])->name('destroy');
//     });

//     Route::middleware('checkPermission:SJ Index')->prefix('sj')->name('sj.')->group(function () {
//         Route::get('/', [SJController::class, 'index'])->name('index');
//     });
// });
// Route::middleware(['auth'])->group(function () {
//     // Route OPNAME
//     Route::middleware('checkPermission:OPNAME Create')->prefix('opname')->name('opname.')->group(function () {
//         Route::get('create', [OpnameController::class, 'create'])->name('create');
//         Route::post('opname/store', [OpnameController::class, 'store'])->name('store');
//     });

//     Route::middleware('checkPermission:OPNAME Edit')->prefix('opname')->name('opname.')->group(function () {
//         Route::get('{opname}/edit', [OpnameController::class, 'edit'])->name('edit');
//         Route::put('{opname}', [OpnameController::class, 'update'])->name('update');
//     });

//     Route::middleware('checkPermission:OPNAME Delete')->prefix('opname')->name('opname.')->group(function () {
//         Route::delete('{opname}', [OpnameController::class, 'destroy'])->name('destroy');
//     });

//     Route::middleware('checkPermission:OPNAME Index')->prefix('opname')->name('opname.')->group(function () {
//         Route::get('/', [OpnameController::class, 'index'])->name('index');
//     });
// });

// Route::middleware(['auth'])->group(function () {
//     // Route CBM
//     Route::middleware('checkPermission:CBM Create')->prefix('cbm')->name('cbm.')->group(function () {
//         Route::get('create', [CBMController::class, 'create'])->name('create');
//         Route::post('cbm/store', [CBMController::class, 'store'])->name('store');
//     });

//     Route::middleware('checkPermission:CBM Edit')->prefix('cbm')->name('cbm.')->group(function () {
//         Route::get('{cbm}/edit', [CBMController::class, 'edit'])->name('edit');
//         Route::put('{cbm}', [CBMController::class, 'update'])->name('update');
//     });

//     Route::middleware('checkPermission:CBM Delete')->prefix('cbm')->name('cbm.')->group(function () {
//         Route::delete('{cbm}', [CBMController::class, 'destroy'])->name('destroy');
//     });

//     Route::middleware('checkPermission:CBM Index')->prefix('cbm')->name('cbm.')->group(function () {
//         Route::get('/', [CBMController::class, 'index'])->name('index');
//     });
// });
