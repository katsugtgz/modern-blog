<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FilterPresetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\PostController as FrontPostController;
use App\Http\Controllers\CategoryController as FrontCategoryController;
use App\Http\Controllers\TagController as FrontTagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetupController;

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    
    // User profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Posts management
    Route::get('/posts/create', [FrontPostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [FrontPostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [FrontPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [FrontPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [FrontPostController::class, 'destroy'])->name('posts.destroy');
    
    // Comments
    Route::post('/posts/{post}/comments', [AdminCommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [AdminCommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    
    // Image uploads
    Route::post('/images/upload', [ImageController::class, 'store'])->name('images.store');
    Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');
    Route::patch('/images/{image}/reorder', [ImageController::class, 'reorder'])->name('images.reorder');
    
    // Filter presets
    Route::resource('filter-presets', FilterPresetController::class);
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories management
    Route::resource('categories', AdminCategoryController::class);
    
    // Tags management
    Route::resource('tags', AdminTagController::class);
    
    // Posts management
    Route::resource('posts', AdminPostController::class);
    
    // Comments management
    Route::resource('comments', AdminCommentController::class);
});

// Public routes
Route::get('/posts', [FrontPostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [FrontPostController::class, 'show'])->name('posts.show');
Route::get('/categories/{slug}', [FrontCategoryController::class, 'show'])->name('categories.show');
Route::get('/tags/{slug}', [FrontTagController::class, 'show'])->name('tags.show');
Route::get('/authors/{user}', [UserController::class, 'show'])->name('authors.show');

Route::get('/admin/logout', [LoginController::class, 'destroy'])->name('admin.logout');

// Temporary setup route - REMOVE THIS IN PRODUCTION
Route::get('/setup-admin', [SetupController::class, 'setupAdmin']);

require __DIR__.'/auth.php';