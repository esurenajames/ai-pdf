<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfConverterController;
use App\Http\Controllers\ImageConverterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Inertia\Inertia;

// Public routes accessible to guests only
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        sleep(1);
        return Inertia::render('Home');
    })->name('home');

    Route::get('/login', function () {
        sleep(1);
        return Inertia::render('Login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/signup', function () {
        sleep(1);
        return Inertia::render('Signup');
    })->name('signup');

    Route::post('/signup', [AuthController::class, 'signup']);
});

// Authenticated routes accessible only to logged-in users
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        sleep(1);
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/quiz', function () {
        sleep(1);
        return Inertia::render('Quiz');
    })->name('quiz');

    Route::post('/quiz', [QuizController::class, 'generateQuiz'])->name('quiz');
    Route::post('/quiz/download-pdf', [QuizController::class, 'generatePdf'])->name('quiz.download-pdf');

    Route::get('/convert', function () {
        sleep(1);
        return Inertia::render('PdfConverter');
    })->name('convert');
    Route::get('/convert', [PdfConverterController::class, 'index'])->name('convert');
    Route::post('/convert', [PdfConverterController::class, 'convert']);

    Route::get('/image', function () {
        sleep(1);
        return Inertia::render('ImageConverter');
    })->name('image');
    Route::post('/image', [ImageConverterController::class, 'convert'])->name('image.convert');
    Route::get('/download', [ImageConverterController::class, 'download'])->name('image.download');

    Route::get('/settings', function () {
        sleep(1);
        return Inertia::render('Settings');
    })->name('settings');

    Route::post('/settings', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
