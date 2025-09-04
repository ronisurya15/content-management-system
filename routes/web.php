<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

// Public Blog
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Login
Route::prefix('auth')->group(function () {
    Route::get('/signin', [AuthController::class, 'signin'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');
});

// Admin Area
Route::prefix('admin')->middleware('auth')->group(function () {
    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Article
    Route::prefix('article')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('article.index');
        Route::get('/create', [ArticleController::class, 'create'])->name('article.create');
        Route::post('/', [ArticleController::class, 'store'])->name('article.store');
        Route::get('/edit/{id}', [ArticleController::class, 'edit'])->name('article.edit');
        Route::put('/{id}', [ArticleController::class, 'update'])->name('article.update');
        Route::delete('/{id}', [ArticleController::class, 'destroy'])->name('article.destroy');
    });

    // Comments
    Route::prefix('comments')->group(function () {
        Route::resource('comments', CommentController::class);
        Route::put('/update', [CommentController::class, 'update'])->name('comments.update');
        Route::put('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
        Route::put('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Tag
    Route::resource('tag', TagController::class);

    // Category
    Route::resource('category', CategoryController::class);
});
