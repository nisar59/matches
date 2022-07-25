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
Route::group(['prefix'=>'purchases','middleware' => ['permission:purchases.view']],function(){
    Route::get('/', 'PurchasesController@index');
    Route::POST('/search', 'PurchasesController@create');
    Route::get('/add-sub-units/{id}', 'PurchasesController@addsubunits');
    Route::POST('/payment-methods-fields', 'PurchasesController@payment_methods_fields');
    Route::get('/show/{id}', 'PurchasesController@show');
    Route::get('/remove-sub-unit/{id}', 'PurchasesController@removesubunit');
    Route::get('/remove-pro/{id}', 'PurchasesController@removepro');
    Route::get('/payment-transactions/{id}', 'PurchasesController@paymenttransactions');
    Route::get('/export-pdf', 'PurchasesController@pdfexport');
    Route::get('/report', 'PurchasesController@report');

});

Route::group(['prefix'=>'purchases','middleware' => ['permission:purchases.add']],function(){
    Route::get('/create', 'PurchasesController@create');
    Route::POST('/store/', 'PurchasesController@store');

});
Route::group(['prefix'=>'purchases','middleware' => ['permission:purchases.edit']],function(){
    Route::get('/edit/{id}', 'PurchasesController@edit');
    Route::POST('/update/{id}', 'PurchasesController@update');
});
Route::group(['prefix'=>'purchases','middleware' => ['permission:purchases.delete']],function(){
    Route::get('/destroy/{id}', 'PurchasesController@destroy');
});