<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ContactController::class, 'index']);

Route::post('/contacts/confirm', [ContactController::class, 'confirm']);

Route::post('/contacts', [ContactController::class, 'store']);

Route::get('/thanks', [ContactController::class, 'thanks']);

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth');

Route::get('/admin/contacts/{id}', [AdminController::class, 'show'])
    ->middleware('auth');

Route::delete('/admin/contacts/{id}', [AdminController::class, 'destroy'])
    ->middleware('auth');

Route::post('/admin/tags', [TagController::class, 'store'])
    ->middleware('auth');

Route::get('/admin/tags/{id}/edit', [TagController::class, 'edit'])
    ->middleware('auth');

Route::put('/admin/tags/{id}', [TagController::class, 'update'])
    ->middleware('auth');