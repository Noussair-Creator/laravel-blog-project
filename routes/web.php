<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

// --- Publicly Accessible Routes ---

Route::get('/', function () {
    return view('welcome');
});

// Public Blog pages
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');


// --- Authenticated User Routes ---

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User's own Post Management (Create, Store, Edit, Update, Destroy)
    // This uses a resource controller but excludes the public index/show routes.
    Route::resource('posts', PostController::class)->except(['index', 'show']);

    // Comment Management
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});


// --- Admin Panel Routes ---

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        // You can add an admin-specific dashboard here later
        // Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('posts', AdminPostController::class);
    });


// --- Laravel Breeze Auth Routes ---
require __DIR__ . '/auth.php';

