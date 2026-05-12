<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PostList;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/create', function () {
    return view('livewire.create-post');
} );
