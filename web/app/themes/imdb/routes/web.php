<?php

declare(strict_types=1);

use App\Http\Controllers\Review;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

Route::get('/register', [User::class, 'signUpView'])->name('sign-up');
Route::post('/register', [User::class, 'signUp'])->name('sign-up.post');

Route::get('/inloggen', [User::class, 'signInView'])->name('sign-in');
Route::post('/inloggen', [User::class, 'signIn'])->name('sign-in.post');
Route::get('/account', [User::class, 'accountView'])->name('account');

Route::post('/store-movie', [User::class, 'saveMovie'])->name('saveMovie');

Route::get('/sign-off', [User::class, 'signOff'])->name('sign-off');

Route::group(['prefix' => 'reviews'], function () {
    Route::post('/add', [Review::class, 'addReview'])->name('addReview');
    Route::post('/delete', [Review::class, 'deleteReview'])->name('deleteReview');
    Route::post('/edit', [Review::class, 'editReview'])->name('editReview');
});
