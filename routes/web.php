<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ResponsesController;

use App\Http\Controllers\PagesController;

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


Route::get('/', [PagesController::class, 'index'])->name('welcomePage');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/contact', [ResponsesController::class, 'store'])->name('contact.store');

Route::get('privacy-policy', [PagesController::class, 'privacy_policy'])->name('ppPage');
Route::get('terms-and-conditions', [PagesController::class, 'terms_and_conditions'])->name('tocPage');