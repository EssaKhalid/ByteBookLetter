<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\GlobalSearch;
use App\Livewire\Posts\Create;
use App\Livewire\Posts\Edit;
use App\Livewire\Posts\Feed;
use App\Livewire\Posts\FollowingFeed;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users\{Show as ProfileShow, Edit as ProfileEdit};


Route::get('/', function() { return view('home'); })->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/feed', Feed::class)->name('feed');
    Route::get('/following', FollowingFeed::class)->name('following');
    Route::get('/post/create', Create::class)->name('post.create');
    Route::get('/post/{post}/edit', Edit::class)->name('post.edit');
    Route::get('/profile/edit', ProfileEdit::class)->name('profile.edit');
    Route::get('/@{user:name}', ProfileShow::class)->name('profile.show');
});
