<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MammalsController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SentimentController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Classification Routes
Route::get('/mammals', [MammalsController::class, 'index'])->name('mammals');
Route::post('/mammals/predict', [MammalsController::class, 'predict'])->name('mammals.predict');

Route::get('/place', [PlaceController::class, 'index'])->name('place');
Route::post('/classification/place/predict', [PlaceController::class, 'predict'])->name('place.predict');

Route::get('/sentiment', [SentimentController::class, 'index'])->name('sentiment');
Route::post('/sentiment/predict', [SentimentController::class, 'predict'])->name('sentiment.predict');

//Cluster Routes
Route::get('/spending_score', function () {
    return view('clustering.spending_score');
})->name('spending_score');

// Regression Routes