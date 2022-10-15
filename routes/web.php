<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Client\UniversityController;
use App\Http\Controllers\HomeController;
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

// Default Application Route
Route::get('/', function (){
    return view('welcome');
});

//Events CRUD Routes
Route::resource('events',EventController::class);

// External API Universities
Route::get('/universities', [UniversityController::class, 'getUniversities'])->name('universities');

//Auth Routes
Route::get('/home', [HomeController::class, 'index'])->name('home');
Auth::routes();


