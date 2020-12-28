<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("cashRegister/create", "CashRegister\CreateCashRegisterController")->name("cashRegister.create");
Route::post("movement/create", "Movement\CreateMovementController")->name("movement.create");
Route::get('movement/getMovementsByDate', 'Movement\GetMovementsController')->name('movement.getMovementsByDate');
Route::get('movement/getAllMovements', 'Movement\GetAllMovementsController')->name('movement.getAllMovements');
Route::get('cashRegister/status', 'CashRegister\StatusCashRegisterController')->name('cashRegister.status');
Route::post('cashRegister/empty', 'CashRegister\EmptyCashRegisterController')->name('cashRegister.empty');
