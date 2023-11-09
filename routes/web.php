<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Wo\DashboardWoController;
use App\Http\Controllers\Wo\LayananWoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class,'index'])->name('home');


//route prefix admin
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

        //route resource kategori 'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
        Route::resource('kategori', KategoriController::class);
    });

//route prefix wo
Route::prefix('wo')
    ->middleware(['auth', 'wo'])
    ->group(function () {
        Route::get('/dashboard', [DashboardWoController::class, 'index'])->name('wo.dashboard');

        Route::delete('/layanan-wo/delete-gallery/{id}', [LayananWoController::class, 'deleteGallery'])->name('layanan-wo.delete-gallery-layanan');

         //route resource kategori 'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
         Route::resource('layanan-wo', LayananWoController::class);

    });

//route prefix customer
//route prefix mua
Auth::routes();
