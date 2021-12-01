<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\CommentController::class, 'show']);
Route::get('/comments', [App\Http\Controllers\CommentController::class, 'index']);
Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store']);
