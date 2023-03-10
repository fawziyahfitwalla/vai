<?php

use App\Http\Controllers\appointmentsController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

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

Route::controller(MainController::class)->group(function(){

    Route::get('login', 'index')->name('login');

    Route::get('registration', 'registration')->name('registration');

    Route::get('logout', 'logout')->name('logout');

    Route::post('validate_registration', 'validate_registration')->name('sample.validate_registration');

    Route::post('validate_login', 'validate_login')->name('sample.validate_login');

    Route::get('dashboard', 'dashboard')->name('dashboard');

});

Route::get('/', function () {
    //return view('welcome');
    return redirect('login');
});

Route::post('user/add', [userController::class, 'addUser'])->name('user.add')->middleware('role:0');
Route::get('users', [userController::class, 'getAllUsers'])->name('users.list')->middleware('role:0');
Route::get('users/doctors', [userController::class, 'getDoctors']);
Route::get('users/patients', [userController::class, 'getPatients']);
Route::post('make-appointment', [appointmentsController::class, 'makeAppointment'])->name('appointment.make')->middleware('role:0,2');
Route::get('cancel-appointment', [appointmentsController::class, 'cancelAppointment'])->name('appointment.cancel');
Route::get('completed-appointment', [appointmentsController::class, 'completeAppointment'])->name('appointment.complete');
Route::get('change-appointment', [appointmentsController::class, 'changeAppointment']);
Route::get('booked-appointment', [appointmentsController::class, 'getAppointmentsByDate'])->name('appointment.booked');
Route::get('user/add/', function(){

        return view('add_user');

})->middleware('role:0');
Route::get('make-appointment', [appointmentsController::class, 'makeAppointmentForm'])->name('appointment.make.form')->middleware('role:0,2');




/*$router->group([],function () use ($router) {
    $router->get('add/user', ['uses' => 'userController@addUser']);
}); */
