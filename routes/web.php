<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(PatientController::class)->group(function () {
    Route::get('/register', 'index');
    Route::get('/login', 'login_show')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::get('/doctor', 'doctor')->name('doctor')->middleware('auth');

});

Route::controller(AppointmentController::class)->group(function () {
    Route::get('/patient', 'patient_show')->name('patient');
    Route::get('/appointment', 'appointment_show')->name('appointment');
    Route::get('/delete/{id}', 'delete')->name('delete_appointment');
    Route::get('/edit/{id}', 'edit_show')->name('edit_appointment');
    Route::post('/add_appointment', 'appointment')->name('add_appointment');
    Route::post('/edit_appointment', 'edit')->name('edit');
});

Route::controller(DoctorController::class)->group(function () {
    Route::get('/doctor', 'doctor')->name('doctor');
    Route::get('/accept/{id}', 'accept')->name('accept');
    Route::get('/reject/{id}', 'reject')->name('reject');
    // Route::post('/accept/{id}', 'storeFile')->name('appointments.storeFile');
    Route::post('/search', 'search')->name('appointments.search');
});
