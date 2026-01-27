<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ResponsesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminContentController;
use App\Http\Controllers\Admin\AdminEventsController;
use App\Http\Controllers\Admin\AdminRolesController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\AdminClientLogoController;

/* Public Routes */
Route::get('/', [PagesController::class, 'index'])->name('welcomePage');
Route::get('/privacy-policy', [PagesController::class, 'privacy_policy'])->name('ppPage');
Route::get('/terms-and-conditions', [PagesController::class, 'terms_and_conditions'])->name('tocPage');
Route::post('/contact', [ResponsesController::class, 'store'])->name('contact.store');

/* Auth */
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

/* Admin Routes */
Route::middleware(['auth', 'check.role_or_permission:Admin,Operations Manager,Content Editor'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::middleware(['check.role_or_permission:Admin,Operations Manager'])->group(function () {
        Route::resource('users', AdminUserController::class, ['as' => 'admin']);
        Route::post('users/{user}/assign-role', [AdminUserController::class, 'assignRole'])->name('admin.users.assign-role');
        Route::delete('users/{user}/remove-role/{role}', [AdminUserController::class, 'removeRole'])->name('admin.users.remove-role');
    });

    Route::middleware(['check.role_or_permission:Admin,Content Editor'])->group(function () {
    Route::get('content', [AdminContentController::class, 'index'])->name('admin.content.index');
    Route::put('content', [AdminContentController::class, 'update'])->name('admin.content.update');
    Route::post('content/upload-image', [AdminContentController::class, 'uploadImage'])->name('admin.content.upload-image');
    Route::post('content/upload-video', [AdminContentController::class, 'uploadVideo'])->name('admin.content.upload-video');
    Route::delete('content/delete-image', [AdminContentController::class, 'deleteImage'])->name('admin.content.delete-image');
    Route::get('content/stats', [AdminContentController::class, 'getStats'])->name('admin.content.stats');
    Route::post('content/preview', [AdminContentController::class, 'previewContent'])->name('admin.content.preview');
    Route::post('content/reset-section', [AdminContentController::class, 'resetSection'])->name('admin.content.reset-section');
        
    Route::resource('roles', AdminRolesController::class, ['as' => 'admin']);
    Route::resource('messages', MessageController::class, ['as' => 'admin']);
    Route::resource('events', AdminEventsController::class, ['as' => 'admin']);
    Route::patch('events/{event}/toggle-available', [AdminEventsController::class, 'toggleAvailable'])->name('admin.events.toggle-available');
    Route::patch('events/{event}/toggle-featured', [AdminEventsController::class, 'toggleFeatured'])->name('admin.events.toggle-featured');
    
    Route::get('client-logos', [AdminClientLogoController::class, 'index'])->name('admin.logos.index');
   
    Route::post('client-logos', [AdminClientLogoController::class, 'store'])->name('admin.client-logos.store');
    Route::put('client-logos/{clientLogo}', [AdminClientLogoController::class, 'update'])->name('admin.client-logos.update');
    Route::delete('client-logos/{clientLogo}', [AdminClientLogoController::class, 'destroy'])->name('admin.client-logos.destroy');
    Route::post('client-logos/update-order', [AdminClientLogoController::class, 'updateOrder'])->name('admin.client-logos.update-order');
    Route::post('client-logos/{clientLogo}/toggle-active', [AdminClientLogoController::class, 'toggleActive'])->name('admin.client-logos.toggle-active');
    });

});
