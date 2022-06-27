<?php

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

Route::group(['prefix'=>'warehousesandshops','middleware' => ['permission:warehousesandshops.view']],function(){
    Route::get('/', 'WarehousesAndShopsController@index');
});

Route::group(['prefix'=>'warehousesandshops','middleware' => ['permission:warehousesandshops.add']],function(){
    Route::get('/create', 'WarehousesAndShopsController@create');
    Route::POST('/store/', 'WarehousesAndShopsController@store');

});
Route::group(['prefix'=>'warehousesandshops','middleware' => ['permission:warehousesandshops.edit']],function(){
    Route::get('/edit/{id}', 'WarehousesAndShopsController@edit');
    Route::POST('/update/{id}', 'WarehousesAndShopsController@update');
});
Route::group(['prefix'=>'warehousesandshops','middleware' => ['permission:warehousesandshops.delete']],function(){
    Route::get('/destroy/{id}', 'WarehousesAndShopsController@destroy');
});