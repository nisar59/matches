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

Route::group(['prefix'=>'products','middleware' => ['permission:products.view']],function(){
    Route::get('/', 'ProductsController@index');
    Route::get('/export-pdf', 'ProductsController@pdfexport');
    Route::get('/stock-report', 'ProductsController@stockreport');
});

Route::group(['prefix'=>'products','middleware' => ['permission:products.add']],function(){
    Route::get('/create', 'ProductsController@create');
    Route::POST('/store/', 'ProductsController@store');

});
Route::group(['prefix'=>'products','middleware' => ['permission:products.edit']],function(){
    Route::get('/edit/{id}', 'ProductsController@edit');
    Route::POST('/update/{id}', 'ProductsController@update');
});
Route::group(['prefix'=>'products','middleware' => ['permission:products.delete']],function(){
    Route::get('/destroy/{id}', 'ProductsController@destroy');
});