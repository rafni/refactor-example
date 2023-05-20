<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\LeadController::class, 'create'])->name('lead.create');
Route::post('/', [\App\Http\Controllers\LeadController::class, 'store'])->name('lead.store');
Route::get('/{lead}', [\App\Http\Controllers\LeadController::class, 'show'])->whereNumber('lead')->name('lead.show');
Route::get('/{lead}/edit', [\App\Http\Controllers\LeadController::class, 'edit'])->whereNumber('lead')->name('lead.edit');
Route::put('/{lead}', [\App\Http\Controllers\LeadController::class, 'update'])->whereNumber('lead')->name('lead.update');
Route::delete('/{lead}', [\App\Http\Controllers\LeadController::class, 'destoy'])->whereNumber('lead')->name('lead.destoy');
