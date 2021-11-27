<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ApplicationController;

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
Route::get('storage/{filename}', function ($filename){
    return Image::make(storage_path('public/' . $filename))->response();
});
Route::get('/{any}', function () {
    return view('application');
})->where('any', '.*');
// Route::get('/{any}', [ApplicationController::class, 'index'])->where('any', '.*');
