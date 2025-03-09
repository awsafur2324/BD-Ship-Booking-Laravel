<?php

use App\Http\Controllers\app\destination_controller;
use App\Http\Controllers\app\miniShipSearch_Controller;
use App\Http\Controllers\auth\profileController;
use App\Http\Controllers\auth\userController;
use App\Http\Controllers\booking_invoice_controller;
use App\Http\Controllers\bookingController;
use App\Http\Controllers\dashbordController;
use App\Http\Controllers\discount_controller;
use App\Http\Controllers\downloadFile_controller;
use App\Http\Controllers\nextDay_controller;
use App\Http\Controllers\refundRequest_controller;
use App\Http\Controllers\shipAssignController;
use App\Http\Controllers\shipManager_controller;
use App\Http\Controllers\shipUpdate_controller;
use App\Http\Middleware\ForgetPassToken_middleware;
use App\Http\Middleware\verifyDiscountStatus;
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
    //----- Booking routes -----//
    Route::get('/api/my-bookings', [bookingController::class, 'my_bookings']);
    Route::get('/api/booking/refund-check/{invoiceID}', [bookingController::class, 'checkRefundStatus']);
    Route::post('/api/booking/refund_request', [bookingController::class, 'insertRefundRequest']);
    //----- Refund request routes -----//
    Route::get('/api/Manager-RefundRequests', [refundRequest_controller::class, 'getAllRefundRequest']);
    Route::post('/api/AcceptRefund', [refundRequest_controller::class, 'acceptRefundRequest']);
    Route::get('/api/view-user-refund-requests', [refundRequest_controller::class, 'viewUserRefundRequests']);
    Route::get('/api/view-manager-refund-requests', [refundRequest_controller::class, 'viewManagerRefundRequests']);
    //----- ship list routes -----//
    Route::get('/api/getShipList', [shipManager_controller::class, 'getShipList']);
    Route::post('/api/deleteShip', [shipManager_controller::class, 'deleteShip']);
    Route::post('/api/departure-date', [shipManager_controller::class, 'findDepartureDate']);
    Route::get('/api/getAllShips', [shipManager_controller::class, 'getAllShips']);
    // ----- update ship routes -----//
    Route::post('/api/update-ship-details', [shipUpdate_controller::class, 'updateShipDetails']);
    Route::post('/api/refund-policies/update', [shipUpdate_controller::class, 'updateRefundPolicy']);
    Route::post('/api/update-departure-based', [shipUpdate_controller::class, 'updateDepartureBased']);
    Route::get('/api/ban-Departure-route/{departure_id}', [shipUpdate_controller::class, 'banDepartureRoute']);
    Route::get('/api/getBanShipList', [shipUpdate_controller::class, 'getBanShipList']);
    Route::post('/api/ban-ship-activate', [shipUpdate_controller::class, 'activateBannedRoute']);
    //----- Add Day-routes -----//
    Route::post('/api/check-duplicate-date', [nextDay_controller::class, 'checkDuplicateDepartureDate']);
    Route::post('/api/get-available-dates', [nextDay_controller::class, 'getAvailableDates']);
    Route::post('/api/addNextDay', [nextDay_controller::class, 'insertAnotherDay']);
    // ----- Add Discount -----//
    Route::post('/api/discount', [discount_controller::class, 'addDiscount']);
    Route::get('/api/discount-list', [discount_controller::class, 'getDiscountTable']);
    Route::post('/api/discount-update', [discount_controller::class, 'updateDiscount']);
    Route::post('/api/discount/inactive', [discount_controller::class, 'inactiveDiscount']);
    //----- Request for manager -----//
    Route::get('/api/get-user-info', [profileController::class, 'getManagerStatus']);
    Route::get('/api/request-manager-To-pending', [profileController::class, 'changeManager_status']);
    Route::get('/api/get-all-managers-requests', [profileController::class, 'getManagersRequests']);
    Route::post('/api/acceptManagerRequest', [profileController::class, 'acceptManagerRequest']);
    Route::post('/api/rejectManagerRequest', [profileController::class, 'rejectManagerRequest']);
    Route::get('/api/view-all-managers', [profileController::class, 'getAllManagers']);
    // ----- Download Ticket -----//
    Route::get('/booking/download-ticket/{id}', [downloadFile_controller::class, 'downloadTicket']);
});

Route::post('/api/miniSearch', [miniShipSearch_Controller::class, 'miniShipSearch']);
Route::post('/api/filter', [destination_controller::class, 'index']);
Route::get('/api/suggest-ship-name', [destination_controller::class, 'suggestShipName']);
Route::get('/api/suggest-departure-from', [destination_controller::class, 'suggestDepartureFrom']);
Route::get('/api/suggest-arrival-to', [destination_controller::class, 'suggestArrivalTo']);

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
Route::get('/', [discount_controller::class, 'getDiscount'])->middleware([verifyDiscountStatus::class]);
Route::view('/about', 'pages.app.about-page');
Route::view('/contact', 'pages.app.contact-page');
Route::view('/find-destination', 'pages.app.find-destination-page');
Route::get('/booking/{id}/{departure_id}/{arrival_id}', [bookingController::class, 'shipView'])->middleware([verifyToken::class, verifyDiscountStatus::class]); //dynamic route for booking page


// -------- Dashboard routes ----------//
Route::middleware([verifyToken::class])->group(function () {
    Route::get('/dashboard/admin', [dashbordController::class, 'adminDashboard']);
    Route::get('/dashboard/manager', [dashbordController::class, 'managerDashboard']);
    Route::get('/dashboard/user', [dashbordController::class, 'userDashboard']);
    Route::get('/dashboard/profile', [profileController::class, 'profilePageShow']);
    Route::view('/dashboard/ship-assign', 'pages.dashboard.assignShip-page');
    Route::view('/dashboard/my-Bookings', 'pages.dashboard.my-booking-page');
    Route::view('/dashboard/ship-list', 'pages.dashboard.ship-list');
    Route::view('/dashboard/view-all-ships', 'pages.dashboard.view-all-ship-page');
    Route::get('/dashboard/ship-list/{ship_id}/{updateType}', [shipManager_controller::class, 'editShip']);
    Route::get('/dashboard/ship-list/{ship_id}/{updateType}/{departure_id}', [shipManager_controller::class, 'findDepartureBaseData']);
    Route::view('/dashboard/ban-routes', 'pages.dashboard.ban-routes-page');
    Route::view('/dashboard/add-day', 'pages.dashboard.add-next-day-page');
    Route::get('/dashboard/add-day/{ship_id}', [nextDay_controller::class, 'viewNextDay']);
    Route::view('/dashboard/add-discount', 'pages.dashboard.discount-page');
    Route::view('/dashboard/discount-manager', 'pages.dashboard.discount-manager-page');
    Route::get('/discount/edit/{id}', [discount_controller::class, 'editPageShow']);
    Route::view('/dashboard/refund-request', 'pages.dashboard.refund-request_page');
    Route::view('/dashboard/refund-view', 'pages.dashboard.user-refund-view-page');
    Route::view('/dashboard/refund-view-all', 'pages.dashboard.manager-refund-view-page');
    Route::view('/dashboard/request-for-manager', 'pages.dashboard.request-for-manager');
    Route::view('/dashboard/verify-manager', 'pages.dashboard.verify-manager-page');
    Route::view('/dashboard/view-all-managers', 'pages.dashboard.view-all-managers-page');
    Route::get('/admin/export-sales-report', [downloadFile_controller::class, 'exportSalesReport'])->name('export.sales.report');
    Route::get('/admin/export-booking-history', [downloadFile_controller::class, 'exportBookingHistory'])->name('export.booking.history');
    Route::get('/admin/export/refund-history', [downloadFile_controller::class, 'exportRefundHistory'])->name('export.refund.history');
    Route::get('/admin/export/manager-booking-history', [downloadFile_controller::class, 'exportManagerBookingHistory'])->name('export.manager.booking.history');
    Route::get('/admin/export/manager-sales-history', [downloadFile_controller::class, 'exportManagerSalesHistory'])->name('export.manager.sales.report');
    Route::get('/admin/export/manager-refund-history', [downloadFile_controller::class, 'exportManagerRefundHistory'])->name('export.manager.refund.history');

});


//-------- SSC Comarz ----------//
// Invoice and payment
Route::post("/booking-invoice", [booking_invoice_controller::class, 'booking_create_invoice'])->middleware([verifyToken::class]);
Route::get("/InvoiceList", [booking_invoice_controller::class, 'InvoiceList']);
Route::get("/InvoiceProductList/{invoice_id}", [booking_invoice_controller::class, 'InvoiceProductList']);


//payment
Route::post("/PaymentSuccess", [booking_invoice_controller::class, 'PaymentSuccess']);
Route::post("/PaymentCancel", [booking_invoice_controller::class, 'PaymentCancel']);
Route::post("/PaymentFail", [booking_invoice_controller::class, 'PaymentFail']);
