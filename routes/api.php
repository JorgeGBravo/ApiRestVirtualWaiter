<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommerceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TableController;
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

Route::post('/users/login', [AuthController::class, 'login'])->name('login');

Route::post('/users/registerUser', [UserController::class, 'registerUser'])->name('registerUser');

Route::middleware('auth:sanctum')->post('/users/updateUser', [UserController::class, 'updateUser']);

Route::middleware('auth:sanctum')->post('/users/changePassword', [AuthController::class, 'changePassword'])->name('changePassword');

Route::middleware('auth:sanctum')->post('/user/registerCommerce', [CommerceController::class, 'registerCommerce'])->name('registerCommerce');

Route::middleware('auth:sanctum')->get('/user/commerce/myCommerces', [CommerceController::class, 'myCommerces'])->name('myCommerces');

Route::middleware('auth:sanctum')->post('/user/commerce/update', [CommerceController::class, 'updateCommerces'])->name('updateCommerces');

//Route::middleware('auth:sanctum')->post('commerces/{idCommerce}/table', [TableController::class, 'createTable'])->name('createTable');

Route::post('/commerces/{idCommerce}/table', [TableController::class, 'createTable'])->name('createTable');

