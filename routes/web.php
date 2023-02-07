<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/inventory/tambah', [App\Http\Controllers\HomeController::class, 'create'])->name('inventory.create');
Route::post('/inventory/simpan', [App\Http\Controllers\HomeController::class, 'save'])->name('inventory.save');
Route::post('/inventory/hapus', [App\Http\Controllers\HomeController::class, 'delete'])->name('inventory.delete');


Route::get('/inventory/beli', [App\Http\Controllers\HomeController::class, 'beli'])->name('inventory.beli');
Route::post('/inventory/beli/simpan', [App\Http\Controllers\HomeController::class, 'beliSimpan'])->name('inventory.beli.simpan');

Route::get('/inventory/jual', [App\Http\Controllers\HomeController::class, 'jual'])->name('inventory.jual');
Route::post('/inventory/jual/simpan', [App\Http\Controllers\HomeController::class, 'jualSimpan'])->name('inventory.jual.simpan');
