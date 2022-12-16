<?php

use App\Http\Controllers\Amo\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/save_tokens', [AuthController::class, 'saveTokens']);
Route::get('/save_leads', [IndexController::class, 'saveLeads']);

