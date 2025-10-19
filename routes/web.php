<?php

use Illuminate\Support\Facades\Route;

Route::get('/donation', function () {
    return view('donation-form');
});

Route::post('/donation', function () {
    return "test";
})->name('donation.store');

Route::get('/privacy', function () {
    return 'privacy';
})->name('privacy');
