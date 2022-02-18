<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ClassByIdController;
use App\Http\Controllers\ClassListController;
use App\Http\Controllers\CreateClassController;

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
Route::post('/register', RegisterController::class);

Route::post('/login', LoginController::class);

Route::post('/logout', LogoutController::class);

Route::middleware('auth:sanctum')->post('/me', MeController::class);

Route::middleware('auth:sanctum')->post('/create_class', CreateClassController::class);

Route::middleware('auth:sanctum')->post('/check_in', CheckInController::class);

Route::middleware('auth:sanctum')->post('/check_out', CheckOutController::class);

Route::middleware('auth:sanctum')->get('/class_list', ClassListController::class);

Route::middleware('auth:sanctum')->get('/class_list/{class_id}', ClassByIdController::class);

