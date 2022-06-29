<?php

use App\Http\Controllers\HobbyController;
use App\Http\Controllers\hobbyTagController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('startseite');
});

Route::get('/info', function () {
    return view('info');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/impressum', function () {
    return view('impressum');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('hobby', HobbyController::class);
Route::resource('tags', TagController::class);
Route::resource('user', UserController::class);

Route::get('/hobby/tag/{tag_id}', [App\Http\Controllers\hobbyTagController::class, 'getFilteredHobbies'])->name('hobby_tag');

Route::get('/hobby/{hobby_id}/tag/{tag_id}/attach', [hobbyTagController::class, 'attachTag'])->name('hobby_tag_attach')->middleware('auth');
Route::get('/hobby/{hobby_id}/tag/{tag_id}/detach', [hobbyTagController::class, 'detachTag'])->name('hobby_tag_detach')->middleware('auth');

//Bilder von Hobby Löschen
Route::get('/delete-image/hobby/{hobby_id}', [App\Http\Controllers\HobbyController::class, 'deleteImages']);
//Bilder von User Löschen
Route::get('/delete-image/user/{user_id}', [App\Http\Controllers\UserController::class, 'deleteImages']);
