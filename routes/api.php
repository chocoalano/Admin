<?php

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
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::middleware('auth:api')->group( function () {
    Route::get('auth','AuthController@auth');
    Route::post('logout','AuthController@logout');
    Route::post('update-account','AuthController@update_account');
    Route::post('update-account-pass','AuthController@update_account_pass');
    Route::get('/agent/info-pengunjung', 'AgentController@infoPengunjung');
    Route::get('/agent/truncate', 'AgentController@truncate');
    Route::resource('/agent', 'AgentController');
    Route::resource('/user', 'UserController');
    Route::resource('/content', 'ContentController');
    Route::resource('/gallery', 'GalleryController');
    Route::resource('/config/medsos', 'ConfigMedsosController');
    Route::resource('/config/page', 'ConfigPageController');
    Route::resource('/config/seo', 'ConfigSeoController');
    Route::resource('/config/service', 'ConfigServiceController');
    Route::resource('/config/slider', 'ConfigSliderController');
    Route::resource('/config/regist', 'ServiceRegistController');
});
Route::resource('/contents', 'SiteController');
Route::get('/img', 'SiteController@galeri');
Route::get('/template', 'SiteController@template');
Route::get('/medsos', 'SiteController@medsos');
Route::get('/carousel', 'SiteController@carousel');
Route::get('/service', 'SiteController@service');
Route::post('/userposted', 'SiteController@service');
Route::post('/client-agent', 'SiteController@agentPost');
Route::get('/seo/{page}', 'SiteController@seo');
