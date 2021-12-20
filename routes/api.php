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

Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');

Route::group(['middleware' => 'auth:api'],function(){
    Route::get('role','Api\RoleController@index');
    Route::get('role/{id}','Api\RoleController@show');
    Route::post('role','Api\RoleController@store');
    Route::put('role/{id}','Api\RoleController@update');
    Route::delete('role/{id}','Api\RoleController@destroy');
});

Route::group(['middleware' => 'auth:api'],function(){
    Route::get('karyawan','Api\KaryawanController@index');
    Route::get('karyawan/{id}','Api\KaryawanController@show');
    Route::post('karyawan','Api\KaryawanController@store');
    Route::put('karyawan/{id}','Api\KaryawanController@update');
    Route::delete('karyawan/{id}','Api\KaryawanController@destroy');
});

Route::group(['middleware' => 'auth:api'],function(){
    Route::get('customer','Api\CustomerController@index');
    Route::get('customer/{id}','Api\CustomerController@show');
    Route::post('customer','Api\CustomerController@store');
    Route::put('customer/{id}','Api\CustomerController@update');
    Route::delete('customer/{id}','Api\CustomerController@destroy');
});

Route::group(['middleware' => 'auth:api'],function(){
    Route::get('produk','Api\ProdukController@index');
    Route::get('produk/{id}','Api\ProdukController@show');
    Route::post('produk','Api\ProdukController@store');
    Route::put('produk/{id}','Api\ProdukController@update');
    Route::delete('produk/{id}','Api\ProdukController@destroy');
});

Route::group(['middleware' => 'auth:api'],function(){
    Route::get('promo','Api\PromoController@index');
    Route::get('promo/{id}','Api\PromoController@show');
    Route::post('promo','Api\PromoController@store');
    Route::put('promo/{id}','Api\PromoController@update');
    Route::delete('promo/{id}','Api\PromoController@destroy');
});

Route::group(['middleware' => 'auth:api'],function(){
    Route::get('perawatan','Api\PerawatanController@index');
    Route::get('perawatan/{id}','Api\PerawatanController@show');
    Route::post('perawatan','Api\PerawatanController@store');
    Route::put('perawatan/{id}','Api\PerawatanController@update');
    Route::delete('perawatan/{id}','Api\PerawatanController@destroy');
});