<?php

use App\Http\Controllers\AdminController;
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

Route::controller(AdminController::class)->group(function() {
    Route::get('/showUsers','index');
    Route::get('/editUser/{id}','editUser');
    Route::post('/updateUser/{id}','updateUser');
    Route::get('/deleteUser/{id}','destroyU');
    Route::get('/showVehicule','showV');
    Route::get('/addVehicule','addVehicule');
    Route::post('/storeVehicule','storeVehicule');
    Route::get('/editVehicule/{id}','editVeh');
    Route::post('/updateVehicule/{id}','updateVeh');
    Route::get('/deleteVehicule/{id}','destroy');
    Route::get('/showReservation','showReservation');
    Route::get('/createReservation', [AdminController::class, 'createReservation'])->name('createReservation');
Route::post('/storeReservation', [AdminController::class, 'storeReservation'])->name('storeReservation');
Route::get('/editReservation/{id}', [AdminController::class, 'editReservation'])->name('editReservation');
Route::put('/updateReservation/{id}', [AdminController::class, 'updateReservation'])->name('updateReservation');
Route::delete('/destroyReservation/{id}', [AdminController::class, 'destroyReservation'])->name('destroyReservation');
    Route::get('/addUser', [AdminController::class, 'addUser'])->name('addUser'); 
Route::post('/storeUser', [AdminController::class, 'storeUser'])->name('storeUser'); 


});