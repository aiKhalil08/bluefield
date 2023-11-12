<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PictureController;

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


// THE FOLLOWING DECLARATOINS DEFINE ROUTES FOR THE ADMIN

// Route::get('/make', function () {
//     dump(Hash::make('admin12345'));
// });

Route::get('/admin/login', [AdminAuthController::class, 'show_login_form']);
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::middleware(['auth:staff', 'only_admin'])->group(function () {
    Route::get('/admin/home', [StaffController::class, 'home']);
});
Route::get('logout/{admin}', [AdminAuthController::class, 'logout']);#;->name('admin.login');

Route::get('/confirm_password', function () {
    if (request()->input == 'admin') {
        return response()->json(['message'=>'authorized'], 200);
    }
});

// THE FOLLOWING DECLARATOINS DEFINE ROUTES FOR THE STAFF MODEL

Route::resource('staff', StaffController::class)
->missing(function() {
    $view = request()->expectsJson ? 'json.missing' : 'nojson.missing';
    return response()->view($view);
});



// THE FOLLOWING DECLARATOINS DEFINE ROUTES FOR THE DOCTOR MODEL

Route::resource('doctor', DoctorController::class)
->missing(function() {
    $view = request()->expectsJson ? 'json.missing' : 'nojson.missing';
    return response()->view($view);
});

Route::fallback(function () {
    return response()->view('fallback');
});