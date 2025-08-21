<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = [];
    if (auth()->check()) {
        // Fetch posts for the authenticated user with comment counts
        $posts = auth()->user()->usersCoolPosts()->withCount('comments')->latest()->get();
    }
    return view('home', ['posts' => $posts]);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
Route::put('/edit-post/{post}', [PostController::class, 'actuallyUpdatePost']);
Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);

// New routes for post viewing and comments
Route::get('/post/{post}', [PostController::class, 'showPost'])->name('post.show');
Route::post('/post/{post}/comment', [PostController::class, 'addComment'])->name('comment.store');
Route::put('/comment/{comment}', [PostController::class, 'updateComment'])->name('comment.update');
Route::delete('/comment/{comment}', [PostController::class, 'deleteComment'])->name('comment.delete');
