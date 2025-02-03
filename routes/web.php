<?php

use App\Http\Controllers\RouteController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BinController;
use App\Http\Controllers\RequestController;
// routes/web.php
Route::get('/',[BinController::class,'index']);

Route::get('/bins/create',[BinController::class,'create'])->name('bins.create');
Route::post('/bins',[BinController::class,'store'])->name('locations.store');
Route::get('/bins',[BinController::class,'index'])->name('bins.index');
Route::any('/bins/{bin}',[BinController::class,'delete'])->name('bin.delete');
Route::get('/requests-by-driver', [RequestController::class, 'showByDriver'])->name('requests.byDriver');
Route::get('/routes-by-driver', [RouteController::class, 'showByDriver'])->name('routes.byDriver');
Route::get('/requests/create',[RequestController::class,'create'])->name('requests.create');
Route::post('/requests',[RequestController::class,'store'])->name('requests.store');
Route::get('/requests',[RequestController::class,'index'])->name('requests.index');
Route::any('/requests/{request}',[RequestController::class,'delete'])->name('request.delete');
Route::get('/routes/assign',[RequestController::class,'assignRequests'])->name('requests.assign');
Route::get('/routesAs/assign',[RouteController::class,'assignRoutes'])->name('routes.assign');
Route::post('/routes/assign/store/{userRequest}/{route}',[RequestController::class,'storeAssign'])->name('requests.assign.store');
Route::post('/routesAs/assign/store/{route}/{driver}',[RouteController::class,'storeAssign'])->name('routes.assign.store');

Route::get('/routes/create',[RouteController::class,'create'])->name('routes.create');
Route::post('/routes',[RouteController::class,'store'])->name('routes.store');
Route::get('/routes',[RouteController::class,'index'])->name('routes.index');
Route::any('/routes/{route}',[RouteController::class,'delete'])->name('route.delete');

Route::get('/drivers/create',[DriverController::class,'create'])->name('drivers.create');
Route::post('/drivers',[DriverController::class,'store'])->name('drivers.store');
Route::get('/drivers',[DriverController::class,'index'])->name('drivers.index');
Route::any('/drivers/{driver}',[DriverController::class,'delete'])->name('driver.delete');

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('login', function () {
    return view('auth.login'); // Βεβαιώσου ότι το view υπάρχει
});
