<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
}) ->name('dashboard');

//gestion de roles y permisos
Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);