<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\IndexPageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RegistrationPageController;

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
        Route::get('/', [AuthenticationController::class, 'login'])->name('index');
        Route::get('login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('post/login', [AuthenticationController::class, 'postLogin'])->name('post.login');
    });
    
    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->group(function(){
    Route::middleware(['auth:web', 'disableBackButton', 'admin'])->group(function(){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});




































































































// Route Front End
// Index/Home
Route::get('/', [IndexPageController::class, 'index'])->name('home.index');
Route::get('/home', [IndexPageController::class, 'index'])->name('home.index');

// Registration
Route::get('/registration', [RegistrationPageController::class, 'index'])->name('registration.index');
Route::post('/registration', [RegistrationPageController::class, 'store'])->name('registration.store');

// Verify after regis
Route::get('verify/{token}', [RegistrationPageController::class, 'verify'])->name('registration.verify');

// Invitation
Route::get('/invitation', [RegistrationPageController::class, 'invitation'])->name('registration.invitation');
