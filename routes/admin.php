<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DoctorController;

Route::get('/', function () {
    return view('admin.dashboard');
}) ->name('dashboard');

//gestion de roles y permisos
Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
Route::resource('users', App\Http\Controllers\Admin\UserController::class);
Route::resource('patients', App\Http\Controllers\Admin\PatientController::class);
Route::resource('doctors', DoctorController::class);
Route::get('doctors/{doctor}/schedule', [DoctorController::class, 'schedule'])
    ->name('doctors.schedule');
Route::resource('appointments', AppointmentController::class);
Route::get('appointments/{appointment}/consultation', [AppointmentController::class, 'consultation'])
    ->name('appointments.consultation');