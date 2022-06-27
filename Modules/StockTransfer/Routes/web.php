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

Route::group(['prefix'=>'stocktransfer','middleware' => ['permission:stocktransfer.view']],function(){
    Route::get('/', 'StockTransferController@index');
});

Route::group(['prefix'=>'stocktransfer','middleware' => ['permission:stocktransfer.add']],function(){
    Route::get('/create', 'StockTransferController@create');
    Route::POST('/store/', 'StockTransferController@store');

});
Route::group(['prefix'=>'stocktransfer','middleware' => ['permission:stocktransfer.edit']],function(){
    Route::get('/edit/{id}', 'StockTransferController@edit');
    Route::POST('/update/{id}', 'StockTransferController@update');
});
Route::group(['prefix'=>'stocktransfer','middleware' => ['permission:stocktransfer.delete']],function(){
    Route::get('/destroy/{id}', 'StockTransferController@destroy');
});