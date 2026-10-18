<?php

use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/resume', 'pages::resume-print')->name('resume.print');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::livewire('/login', 'pages::admin.login')->middleware('guest')->name('login');

    Route::middleware('auth')->group(function () {
        Route::livewire('/', 'pages::admin.dashboard')->name('dashboard');
        Route::livewire('/profile', 'pages::admin.profile')->name('profile');
        Route::livewire('/experiences', 'pages::admin.experiences')->name('experiences');
        Route::livewire('/projects', 'pages::admin.projects')->name('projects');
        Route::livewire('/skills', 'pages::admin.skill-groups')->name('skill-groups');
        Route::livewire('/education', 'pages::admin.education')->name('education');
        Route::livewire('/messages', 'pages::admin.messages')->name('messages');
        Route::post('/logout', LogoutController::class)->name('logout');
    });
});
