<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;

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

Route::get('/bluefield/{name?}', function($name = 'Patient X') {
    return 'Hello, <strong>'.$name.'</strong>. Welcome to Bluefield clinic.';
});


// The following declarations define routes for the Doctor model

Route::resource('doctor', DoctorController::class);