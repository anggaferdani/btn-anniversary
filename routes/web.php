<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZoomContoller;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SpinController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HadirController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexPageController;
use App\Http\Controllers\QuizAdminController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserParticipantController;
use App\Http\Controllers\RegistrationPageController;
use App\Http\Controllers\AttendanceParticipantController;
use App\Http\Controllers\RegisterController;

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

// Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('post/register', [RegisterController::class, 'postRegister'])->name('post.register');

// Route::get('hadir', [HadirController::class, 'hadir'])->name('hadir');
Route::post('post/hadir', [HadirController::class, 'postHadir'])->name('post.hadir');
Route::get('check/{qrcode}', [HadirController::class, 'check'])->name('check');
Route::get('check/{qrcode}/ok', [HadirController::class, 'checkOk'])->name('check.ok');

Route::get('/quiz', [QuizController::class, 'join'])->name('join');
Route::post('/join/post', [QuizController::class, 'joinPost'])->name('join.post');
Route::get('/quiz/{token}', [QuizController::class, 'quiz'])->name('quiz');
Route::get('/spin', [SpinController::class, 'index'])->name('admin.spin.index');
//admin.spin.index
Route::post('/quiz/{token}/post', [QuizController::class, 'quizPost'])->name('quiz.post');
Route::get('/result/{token}', [QuizController::class, 'result'])->name('result');

Route::get('/online-event', [EventController::class, 'onlineEvent'])->name('online-event');

Route::middleware(['web', 'disableBackButton'])->group(function(){
    Route::middleware(['disableRedirectToLoginPage'])->group(function(){
        Route::get('login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('post/login', [AuthenticationController::class, 'postLogin'])->name('post.login');
    });

    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['auth:web', 'disableBackButton', 'admin'])->group(function(){
        Route::get('ajax/leaderboard', [EventController::class, 'ajaxLeaderboard'])->name('ajax.leaderboard');
        Route::get('ajax/leaderboard/quiz', [QuizController::class, 'ajaxLeaderboard'])->name('ajax.leaderboard.quiz');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('instansi', InstansiController::class);
        Route::resource('zoom', ZoomContoller::class);
        Route::resource('quiz', QuizAdminController::class);
        Route::resource('admin', AdminController::class);
        Route::resource('receptionist', ReceptionistController::class);
        Route::resource('tenant', TenantController::class);
        Route::resource('participant', ParticipantController::class);
        Route::put('participant/hadir/{id}', [ParticipantController::class, 'hadir'])->name('participant.hadir');
        Route::put('participant/onsite/{id}', [ParticipantController::class, 'onsite'])->name('participant.onsite');
        Route::get('resend-email-verification/{token}', [AuthenticationController::class, 'resendEmailVerification'])->name('resend-email-verification');
        Route::get('resend-digital-invitation/{token}', [AuthenticationController::class, 'resendDigitalInvitation'])->name('resend-digital-invitation');
        Route::resource('attendance-participant', AttendanceParticipantController::class);
        Route::get('download/id/{token}', [ParticipantController::class, 'downloadId'])->name('download.id');
        Route::get('download/qr/{token}', [ParticipantController::class, 'downloadQr'])->name('download.qr');
        Route::get('history', [UserParticipantController::class, 'history'])->name('history');
        Route::get('spin', [EventController::class, 'spin'])->name('spin');
        Route::get('leaderboard', [EventController::class, 'leaderboard'])->name('leaderboard');
        Route::get('leaderboard/quiz', [QuizController::class, 'leaderboard'])->name('leaderboard.quiz');
        Route::get('history/quiz', [QuizController::class, 'history'])->name('history.quiz');
    });
});

Route::prefix('receptionist')->name('receptionist.')->group(function(){
    Route::middleware(['auth:web', 'disableBackButton', 'receptionist'])->group(function(){
        Route::get('participant/autocomplete', [ParticipantController::class, 'autocomplete'])->name('participant.autocomplete');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('scan', [ParticipantController::class, 'scan'])->name('scan');
        Route::get('attendance/{qrcode}', [ParticipantController::class, 'attendance'])->name('attendance');
        Route::get('attendance/{qrcode}/ok', [ParticipantController::class, 'attendanceOk'])->name('attendance.ok');
        Route::resource('participant', ParticipantController::class);
        Route::get('resend-email-verification/{token}', [AuthenticationController::class, 'resendEmailVerification'])->name('resend-email-verification');
        Route::get('resend-digital-invitation/{token}', [AuthenticationController::class, 'resendDigitalInvitation'])->name('resend-digital-invitation');
        Route::resource('attendance-participant', AttendanceParticipantController::class);
    });
});

Route::prefix('tenant')->name('tenant.')->group(function(){
    Route::middleware(['auth:web', 'disableBackButton', 'tenant'])->group(function(){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('scan', [UserParticipantController::class, 'scan'])->name('scan');
        Route::get('participant/autocomplete', [UserParticipantController::class, 'autocomplete'])->name('participant.autocomplete');
        Route::get('point/{qrcode}', [UserParticipantController::class, 'point'])->name('point');
        Route::get('point/{qrcode}/ok', [UserParticipantController::class, 'pointOk'])->name('point.ok');
        Route::get('history', [UserParticipantController::class, 'history'])->name('history');
    });
});














































































// Route Front End
// Index/Home
Route::get('/', [IndexPageController::class, 'index'])->name('index');
Route::get('/index', [IndexPageController::class, 'index'])->name('index');

// Registration
// Route::get('/registration', [RegistrationPageController::class, 'index'])->name('registration.index');
// Route::get('/registration/online', [RegistrationPageController::class, 'indexOnline'])->name('registration.index.online');
Route::post('/registration/store', [RegistrationPageController::class, 'store'])->name('registration.store');
Route::post('/registration/store/online', [RegistrationPageController::class, 'storeOnline'])->name('registration.store.online');

// Verify after regis
Route::get('verify/{token}', [RegistrationPageController::class, 'verify'])->name('registration.verify');
Route::post('verify/sendmail/{token}', [RegistrationPageController::class, 'sendmailQRCode'])->name('registration.sendmail');

Route::post('registration/send-image/{token}', [RegistrationPageController::class, 'sendImage'])->name('registration.sendImage');
Route::get('registration/download-image/{token}', [RegistrationPageController::class, 'downloadImage'])->name('registration.downloadImage');
