<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

// ========================================
// トップページ
// ========================================
Route::get('/', [FrontController::class, 'index'])->name('home');

// ========================================
// 団体情報
// ========================================
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/support', [FrontController::class, 'support'])->name('support');

// ========================================
// 保護猫
// ========================================
Route::get('/cats', [FrontController::class, 'cats'])->name('cats');
Route::get('/cats/{cat}', [FrontController::class, 'catDetail'])->name('cats.detail');

// ========================================
// 譲渡会
// ========================================
Route::get('/events', [FrontController::class, 'events'])->name('events');

// ========================================
// 譲渡条件
// ========================================
Route::get('/requirements', [FrontController::class, 'requirements'])->name('requirements');

// ========================================
// 活動報告
// ========================================
Route::get('/activity', [FrontController::class, 'activity'])->name('activity');

// ========================================
// 記事（お役立ち情報）
// ========================================
Route::get('/articles', [FrontController::class, 'articles'])->name('articles');
Route::get('/articles/{article:slug}', [FrontController::class, 'articleDetail'])->name('articles.detail');

// ========================================
// お問い合わせ
// ========================================
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontController::class, 'submitContact'])->name('contact.submit');

// ========================================
// 法的情報
// ========================================
Route::get('/privacy', [FrontController::class, 'privacy'])->name('privacy');

// ========================================
// サイトマップ
// ========================================
Route::get('/sitemap', [FrontController::class, 'sitemap'])->name('sitemap');

// ========================================
// お気に入り
// ========================================
Route::post('/favorites/{cat}', [FrontController::class, 'addFavorite'])->name('favorites.add');
Route::delete('/favorites/{cat}', [FrontController::class, 'removeFavorite'])->name('favorites.remove');
Route::get('/favorites', [FrontController::class, 'favorites'])->name('favorites');
Route::get('/api/favorites/user', [FrontController::class, 'getUserFavorites']);
