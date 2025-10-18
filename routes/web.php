<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/cats', [FrontController::class, 'cats'])->name('cats');
Route::get('/cats/{cat}', [FrontController::class, 'catDetail'])->name('cats.detail');
Route::get('/events', [FrontController::class, 'events'])->name('events');
Route::get('/activity', [FrontController::class, 'activity'])->name('activity');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontController::class, 'submitContact'])->name('contact.submit');
Route::get('/privacy', [FrontController::class, 'privacy'])->name('privacy');
