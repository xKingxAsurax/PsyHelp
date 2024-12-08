<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PatientController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DataCollectionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Psychologist\ProfileController as PsychologistProfileController;
use App\Http\Controllers\Client\SettingsController as ClientSettingsController;
use App\Http\Controllers\Psychologist\SettingsController as PsychologistSettingsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\PasswordConfirmationController;
use App\Http\Controllers\Auth\AuthController as AuthenticationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RatingController;

// Ruta principal pública
Route::get('/', function () {
    return view('home');
})->name('home');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/register', [LoginRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [LoginRegisterController::class, 'register']);
    Route::get('/login', [LoginRegisterController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginRegisterController::class, 'login']);
    
    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])
        ->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])
        ->name('password.update');
});

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Rutas del dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas de perfil
    Route::get('/profile', [ClientProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ClientProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ClientProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/confirm-password', [PasswordConfirmationController::class, 'show'])
        ->name('password.confirm');
    Route::post('/confirm-password', [PasswordConfirmationController::class, 'store']);
    
    // Rutas de configuración
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Servicios
    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/{service}', [ServiceController::class, 'show'])->name('services.show');
    });

    // Cerrar sesión
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rutas para citas (appointments)
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
        Route::get('/create', [AppointmentController::class, 'create'])->name('create');
        Route::post('/', [AppointmentController::class, 'store'])->name('store');
        Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
        Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('edit');
        Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('update');
        Route::delete('/{appointment}', [AppointmentController::class, 'destroy'])->name('destroy');
        Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('my');
    });

    // Rutas de verificación de email
    Route::get('/email/verify', [EmailVerificationPromptController::class, 'show'])
        ->name('verification.notice');
        
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('verification.send');
        
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
    Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
    Route::post('/offers/{offer}/counter-offer', [OfferController::class, 'makeCounterOffer'])->name('offers.counter-offer');

    Route::post('/location/update', [LocationController::class, 'updateLocation'])
         ->name('location.update');
    Route::get('/psychologists/nearby', [LocationController::class, 'getNearbyPsychologists'])
         ->name('psychologists.nearby');

    // Rutas para la recopilación de datos
    Route::middleware(['auth'])->group(function () {
        Route::post('/api/collect-data', [DataCollectionController::class, 'store'])
             ->name('data.collect');
        
        Route::get('/api/data/summary', [DataCollectionController::class, 'summary'])
             ->name('data.summary')
             ->middleware('role:admin');
    });

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
    Route::put('/settings/privacy', [SettingsController::class, 'updatePrivacy'])->name('settings.privacy');

    // Rutas para clientes
    Route::middleware(['auth', 'role:cliente'])->group(function () {
        Route::get('/client/settings', [ClientSettingsController::class, 'edit'])
             ->name('client.settings.edit');
        Route::patch('/client/settings', [ClientSettingsController::class, 'update'])
             ->name('client.settings.update');
    });

    // Rutas para psicólogos
    Route::middleware(['auth', 'role:psicólogo'])->group(function () {
        Route::get('/psychologist/settings', [PsychologistSettingsController::class, 'edit'])
             ->name('psychologist.settings.edit');
        Route::match(['post', 'patch'], '/psychologist/settings', [PsychologistSettingsController::class, 'update'])
             ->name('psychologist.settings.update');
    });

    Route::middleware(['auth'])->group(function () {
        Route::post('/payments/process', [PaymentController::class, 'process'])->name('payments.process');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    });

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Rutas de notificaciones
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Rutas de valoraciones
    Route::post('/appointments/{appointment}/rate', [RatingController::class, 'store'])->name('appointments.rate');

    Route::middleware(['auth'])->group(function () {
        Route::get('/emergency', [EmergencyController::class, 'show'])->name('emergency');
        Route::post('/emergency', [EmergencyController::class, 'store'])->name('emergency.store');
        Route::get('/emergency/contacts', [EmergencyController::class, 'contacts'])->name('emergency.contacts');
    });
});

// Rutas de emergencia (accesibles sin autenticación)
Route::prefix('emergency')->group(function () {
    Route::get('/', [EmergencyController::class, 'show'])->name('emergency');
    Route::post('/request', [EmergencyController::class, 'store'])->name('emergency.store');
    Route::get('/contacts', [EmergencyController::class, 'contacts'])->name('emergency.contacts');
});

// Rutas específicas para psicólogos
Route::middleware(['auth', 'role:psicólogo'])->group(function () {
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/profile/edit', [PsychologistProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['post', 'patch'], '/profile/update', [PsychologistProfileController::class, 'update'])->name('profile.update');
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::post('/agenda/citas', [AgendaController::class, 'store'])->name('agenda.store');
    Route::put('/agenda/citas/{appointment}', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/agenda/citas/{appointment}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
});

// Rutas específicas para clientes
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.my');
    Route::get('/find-psychologist', [PsychologistController::class, 'index'])->name('psychologists.index');
    Route::get('/client/profile', [ClientProfileController::class, 'edit'])
         ->name('client.profile.edit');
    Route::patch('/client/profile', [ClientProfileController::class, 'update'])
         ->name('client.profile.update');
});

// Rutas para psicólogos
Route::middleware(['auth', 'role:psicólogo'])->group(function () {
    Route::get('/psychologist/profile', [PsychologistProfileController::class, 'edit'])
         ->name('psychologist.profile.edit');
    Route::patch('/psychologist/profile', [PsychologistProfileController::class, 'update'])
         ->name('psychologist.profile.update');
});

Route::post('/submit-rating', [RatingController::class, 'store'])->name('submit.rating');