<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MammalsController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SentimentController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/mammals', [MammalsController::class, 'index'])->name('mammals');
Route::post('/mammals/predict', [MammalsController::class, 'predict'])->name('mammals.predict');

Route::get('/place', [PlaceController::class, 'index'])->name('place');
Route::post('/classification/place/predict', [PlaceController::class, 'predict'])->name('place.predict');

Route::get('/sentiment', [SentimentController::class, 'index'])->name('sentiment');
Route::post('/sentiment/predict', [SentimentController::class, 'predict'])->name('sentiment.predict');