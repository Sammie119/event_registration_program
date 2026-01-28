<?php

use App\Http\Controllers\RegistrantController;
use Illuminate\Support\Facades\Route;

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

Route::controller(RegistrantController::class)->group(function () {
    Route::get('/', 'index')->name('registrant.index');
    Route::post('/registration', 'store')->name('registrant.store');

    Route::get('/registrant_page', 'create')->name('registrant_page');
    Route::post('/registrant_login', 'registrationLogin')->name('registrant_login');

//    Route::get('/registrant_complete', 'show')->name('registrant_complete');
    Route::post('/registrant_complete', 'registrationComplete')->name('registrant_complete');
    Route::get('/registrant_complete_return', 'registrationCompleteReturn')->name('registrant_complete_return');

    Route::post('/make_payment', 'registrantMakePayment')->name('make_payment');

    Route::post('/registrant_logout', 'registrantLogout')->name('registrant_logout');
});

