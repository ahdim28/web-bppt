<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//grouping
$group = ['middleware' => ['language']];
$groupAuth = ['middleware' => ['guest', 'language']];

if (config('custom.language.needLocale')) {
    $group['prefix'] = '{locale?}';
    $groupAuth['prefix'] = '{locale?}';
}

/**
 * backend
 */

//login backend
Route::get('/backend/authentication', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');
Route::post('/backend/authentication', [LoginController::class, 'login'])
    ->middleware('guest');

Route::group($groupAuth, function () {
    //login frontend
    Route::get('/login', [LoginController::class, 'showLoginFrontendForm'])
        ->name('login.frontend')
        ->middleware('guest');
    Route::post('/login', [LoginController::class, 'loginFrontend'])
        ->middleware('guest');

    //register
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])
        ->name('register')
        ->middleware('guest');
    Route::post('/register', [RegisterController::class, 'register'])
        ->middleware('guest');
    Route::get('/register/activate/{email}', [RegisterController::class, 'activate'])
        ->name('register.activate')
        ->middleware('guest');

    //forgot password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.email')
        ->middleware('guest');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->middleware('guest');

    //reset password
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset')
        ->middleware('guest');
    Route::post('/reset-password/send', [ResetPasswordController::class, 'reset'])
        ->name('password.update')
        ->middleware('guest');
});

//--admin panel--//
Route::prefix('admin')->middleware('auth')->group(function () {

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    //notifications
    Route::get('/notification', [DashboardController::class, 'notification'])
        ->name('notification');
    Route::get('/notification/api', [DashboardController::class, 'apiNotif']);

    //logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
    //logout frontend
    Route::post('/logout/frontend', [LoginController::class, 'logoutFrontend'])
        ->name('logout.frontend');
    
});

/**
 * frontend
 */

//sitemap
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])
    ->name('sitemap');
#--rss
Route::get('/feed', [HomeController::class, 'feed'])
    ->name('rss.feed');
Route::get('/feed/post', [HomeController::class, 'post'])
    ->name('rss.post');

//maintenance
Route::get('/maintenance', [HomeController::class, 'maintenance'])
    ->name('is_maintenance');

Route::group($group, function () {
    
    //landing
    Route::get('/landing', [HomeController::class, 'landing'])
        ->name('landing');
    //home
    Route::get('/', [HomeController::class, 'home'])
        ->name('home');
    //search
    Route::get('/search', [HomeController::class, 'search'])
        ->name('home.search');

});