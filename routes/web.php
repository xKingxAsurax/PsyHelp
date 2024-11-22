<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RatingController;

Route::get('/', function () {
    return view('home');
});

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
Route::get('/request-service', [ServiceController::class, 'showRequestForm'])->name('request.service');
Route::post('/request-service', [ServiceController::class, 'requestService']);

Route::get('/emergency', [ServiceController::class, 'showEmergency'])->name('emergency');
Route::get('/service-history', [ServiceController::class, 'showHistory'])->name('service.history');
Route::get('/reports', [ReportController::class, 'showReports'])->name('reports');
Route::post('/generate-report', [ReportController::class, 'generateReport'])->name('generate.report');
Route::get('/ratings', [RatingController::class, 'showRatings'])->name('ratings');
Route::post('/submit-rating', [RatingController::class, 'submitRating'])->name('submit.rating');