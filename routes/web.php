<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ResponsesController;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminEventsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminContentController;



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




// Admin Routes
Route::middleware(['auth', 'check.role_or_permission:Admin,Operations Manager,Content Editor'])->group(function () {
    
    Route::prefix('admin')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // User Management (Admin and Operations Manager only)
        Route::middleware(['check.role_or_permission:Admin,Operations Manager'])->group(function () {
            Route::resource('users', AdminUserController::class, ['as' => 'admin']);
            Route::post('users/{user}/assign-role', [AdminUserController::class, 'assignRole'])->name('admin.users.assign-role');
            Route::delete('users/{user}/remove-role/{role}', [AdminUserController::class, 'removeRole'])->name('admin.users.remove-role');
        });

        // Content Management (Admin and Content Editor only)
        Route::middleware(['check.role_or_permission:Admin,Content Editor'])->group(function () {
            
            // User Management
                Route::resource('users', AdminUserController::class, ['as' => 'admin']);
                Route::post('users/{user}/assign-role', [AdminUserController::class, 'assignRole'])->name('admin.users.assign-role');
                Route::delete('users/{user}/remove-role/{role}', [AdminUserController::class, 'removeRole'])->name('admin.users.remove-role');

                // Content Management (Admin and Content Editor only)
                Route::middleware(['check.role_or_permission:Admin,Content Editor'])->group(function () {
                Route::get('content', [AdminContentController::class, 'index'])->name('admin.content.index');
                Route::put('content', [AdminContentController::class, 'update'])->name('admin.content.update');
                Route::post('content/upload-image', [AdminContentController::class, 'uploadImage'])->name('admin.content.upload-image');


                  // List all roles
                Route::get('/roles', [AdminRolesController::class, 'index'])->name('adminAllRoles');
                // Show create form
                Route::get('/roles/create', [AdminRolesController::class, 'create'])->name('roles.create');
                // Store new role
                Route::post('/roles', [AdminRolesController::class, 'adminSendCreateRole'])->name('roles.store');
                // Show edit form
                Route::get('/roles/{role}/edit', [AdminRolesController::class, 'edit'])->name('roles.edit');
                // Update role
                Route::put('/roles/{role}', [AdminRolesController::class, 'updateRole'])->name('roles.update');
                // Delete role
                Route::delete('/roles/{role}', [AdminRolesController::class, 'destroy'])->name('roles.destroy');

                // Messages CRUD
                Route::get('messages', [MessageController::class, 'index'])->name('admin.messages.index');

                Route::get('messages/singlemessage/{message}', [MessageController::class, 'singleMessage'])->name('admin.singlemessage.index');

                Route::get('messages/create', [MessageController::class, 'create'])->name('admin.messages.create');
                Route::post('messages', [MessageController::class, 'store'])->name('admin.messages.store');
                Route::get('messages/{message}/edit', [MessageController::class, 'edit'])->name('admin.messages.edit');
                Route::put('messages/{message}', [MessageController::class, 'update'])->name('admin.messages.update');
                Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('admin.messages.destroy');

            Route::get('events', [AdminEventsController::class, 'index'])->name('admin.events.index');
            Route::get('events/create', [AdminEventsController::class, 'create'])->name('admin.events.create');
            Route::post('events', [AdminEventsController::class, 'store'])->name('admin.events.store');
            Route::get('events/{event}', [AdminEventsController::class, 'show'])->name('admin.events.show');
            Route::get('events/{event}/edit', [AdminEventsController::class, 'edit'])->name('admin.events.edit');
            Route::put('events/{event}', [AdminEventsController::class, 'update'])->name('admin.events.update');
            Route::delete('events/{event}', [AdminEventsController::class, 'destroy'])->name('admin.events.destroy');
            Route::patch('events/{event}/toggle-available', [AdminEventsController::class, 'toggleAvailable'])->name('admin.events.toggle-available');
            Route::patch('events/{event}/toggle-featured', [AdminEventsController::class, 'toggleFeatured'])->name('admin.events.toggle-featured');

            // Projects CRUD (placeholder)
            // Route::resource('projects', AdminProjectsController::class, ['as' => 'admin']);

            // Organizers CRUD (placeholder)
            // Route::resource('organizers', AdminOrganizersController::class, ['as' => 'admin']);
        });

    });
});