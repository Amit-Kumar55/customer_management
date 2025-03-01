<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UIController;

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

Route::get('/login', function () {
    return view('auth.login');
})->name('loginPage');

Route::post('/login', [UIController::class, 'loginUser'])->name('loginUser');

Route::get('/customers', [UIController::class, 'showCustomers'])->middleware('auth')->name('customers');
Route::get('/customer/create', [UIController::class, 'showCreateCustomer'])->middleware('auth');
Route::post('/customer/store', [UIController::class, 'storeCustomer'])->middleware('auth');
Route::get('/customer/edit/{id}', [UIController::class, 'editCustomer'])->middleware('auth');
Route::post('/customer/update/{id}', [UIController::class, 'updateCustomer'])->middleware('auth');
Route::delete('/customer/delete/{id}', [UIController::class, 'deleteCustomer'])->middleware('auth');