<?php

use App\Http\Controllers\app\destination_controller;
use App\Http\Controllers\app\miniShipSearch_Controller;
use App\Http\Controllers\auth\profileController;
use App\Http\Controllers\auth\userController;
use App\Http\Controllers\bookingController;
use App\Http\Controllers\shipAssignController;
use App\Http\Middleware\ForgetPassToken_middleware;
use App\Http\Middleware\verifyToken;
use Illuminate\Support\Facades\Route;

//----------------------------------------------------------------------------------
// Api routes
//----------------------------------------------------------------------------------

//-------- Auth API routes ----------//
Route::post('/api/register', [userController::class, 'register']);
Route::post('/api/verifyOtp', [userController::class, 'Email_verifyOtp']); //registration verification
Route::post('/api/login', [userController::class, 'login']);
Route::post('/api/forgotPassword', [userController::class, 'forgotPassword_sendOtp']);
Route::post('/api/forgotPasswordOtp', [userController::class, 'forgotPassword_verifyOtp'])->middleware([ForgetPassToken_middleware::class]);
Route::post('/api/resetPassword', [userController::class, 'resetPassword'])->middleware([ForgetPassToken_middleware::class]);
Route::get('/api/logout', [userController::class, 'UserLogout']);

Route::middleware([verifyToken::class])->group(function () {
    //---- Auth profile routes -----//
    Route::get('/api/profileData', [profileController::class, 'getUserProfile']);
    Route::post('/api/updateProfile', [profileController::class, 'updateProfile']);
    Route::get('/api/deleteProfile', [profileController::class, 'deleteProfile']);
    //----- Ship assign routes -----//
    Route::post('/api/assignShip', [shipAssignController::class, 'assignShip']);
    Route::post('/api/booking/create', [bookingController::class, 'setBookingData']);
    Route::get('/api/booking/list', [bookingController::class, 'viewBookings']);
    
});

Route::post('/api/miniSearch', [miniShipSearch_Controller::class, 'miniShipSearch']);
Route::post('/api/filter', [destination_controller::class, 'index']);

//----------------------------------------------------------------------------------
// Web routes
//----------------------------------------------------------------------------------
// Route::view('/', 'welcome');
//-------- Auth routes ----------//
Route::view('/login', 'pages.auth.login-page');
Route::view('/register', 'pages.auth.register-page');
Route::view('/register-otpVerify', 'pages.auth.register-otpVerify-page');
Route::view('/forgotPassword', 'pages.auth.forgetpass-page');
Route::view('/forgotPassword-otpVerify', 'pages.auth.forgetpass-OTP-page');
Route::view('/resetPassword', 'pages.auth.resetPass-page');

//-------- App Pages ----------//
Route::view('/', 'pages.app.home-page');
Route::view('/about', 'pages.app.about-page');
Route::view('/contact', 'pages.app.contact-page');
Route::view('/find-destination', 'pages.app.find-destination-page');
Route::get('/booking/{id}/{departure_id}', [bookingController::class, 'shipView'])->middleware([verifyToken::class]); //dynamic route for booking page


// -------- Dashboard routes ----------//
Route::view('/dashboard', 'pages.dashboard.dashboard-home')->middleware([verifyToken::class]);
Route::view('/dashboard/profile', 'pages.dashboard.profile-page')->middleware([verifyToken::class]);
Route::view('/dashboard/ship-assign', 'pages.dashboard.assignShip-page')->middleware([verifyToken::class]);
Route::view('/dashboard/my-Bookings', 'pages.dashboard.my-booking-page')->middleware([verifyToken::class]);
