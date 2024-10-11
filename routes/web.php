<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexPageController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserParticipantController;
use App\Http\Controllers\RegistrationPageController;
use App\Http\Controllers\AttendanceParticipantController;
use App\Http\Controllers\ZoomContoller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['web', 'disableBackButton'])->group(function(){
    Route::middleware(['disableRedirectToLoginPage'])->group(function(){
        Route::get('login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('post/login', [AuthenticationController::class, 'postLogin'])->name('post.login');
    });
    
    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['auth:web', 'disableBackButton', 'admin'])->group(function(){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('instansi', InstansiController::class);
        Route::resource('zoom', ZoomContoller::class);
        Route::resource('admin', AdminController::class);
        Route::resource('receptionist', ReceptionistController::class);
        Route::resource('tenant', TenantController::class);
        Route::resource('participant', ParticipantController::class);
        Route::get('resend-email-verification/{token}', [AuthenticationController::class, 'resendEmailVerification'])->name('resend-email-verification');
        Route::get('resend-digital-invitation/{token}', [AuthenticationController::class, 'resendDigitalInvitation'])->name('resend-digital-invitation');
        Route::resource('attendance-participant', AttendanceParticipantController::class);
        Route::get('history', [UserParticipantController::class, 'history'])->name('history');
    });
});

Route::prefix('receptionist')->name('receptionist.')->group(function(){
    Route::middleware(['auth:web', 'disableBackButton', 'receptionist'])->group(function(){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('scan', [ParticipantController::class, 'scan'])->name('scan');
        Route::get('attendance/{qrcode}', [ParticipantController::class, 'attendance'])->name('attendance');
        Route::resource('participant', ParticipantController::class);
        Route::get('resend-email-verification/{token}', [AuthenticationController::class, 'resendEmailVerification'])->name('resend-email-verification');
        Route::get('resend-digital-invitation/{token}', [AuthenticationController::class, 'resendDigitalInvitation'])->name('resend-digital-invitation');
        Route::resource('attendance-participant', AttendanceParticipantController::class);
        Route::get('participant/autocomplete', [ParticipantController::class, 'autocomplete'])->name('participant.autocomplete');
    });
});

Route::prefix('tenant')->name('tenant.')->group(function(){
    Route::middleware(['auth:web', 'disableBackButton', 'tenant'])->group(function(){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('scan', [UserParticipantController::class, 'scan'])->name('scan');
        Route::get('point/{qrcode}', [UserParticipantController::class, 'point'])->name('point');
        Route::get('history', [UserParticipantController::class, 'history'])->name('history');
    });
});














































































// Route Front End
// Index/Home
Route::get('/', [IndexPageController::class, 'index'])->name('index');
Route::get('/index', [IndexPageController::class, 'index'])->name('index');

// Registration
Route::get('/registration', [RegistrationPageController::class, 'index'])->name('registration.index');
Route::post('/registration', [RegistrationPageController::class, 'store'])->name('registration.store');

// Verify after regis
Route::get('verify/{token}', [RegistrationPageController::class, 'verify'])->name('registration.verify');
Route::post('verify/sendmail/{token}', [RegistrationPageController::class, 'sendmailQRCode'])->name('registration.sendmail');

Route::get('registration/download-pdf/{token}', [RegistrationPageController::class, 'downloadPdf'])->name('registration.downloadPdf');
Route::post('registration/sendmail/{token}', [RegistrationPageController::class, 'sendmailQRCode'])->name('registration.sendmail');
