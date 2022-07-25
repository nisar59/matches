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

Route::group(['prefix'=>'expenses','middleware' => ['permission:expenses.view']],function(){
    Route::get('/', 'ExpensesController@index');
    Route::get('/report', 'ExpensesController@report');
});

Route::group(['prefix'=>'expenses','middleware' => ['permission:expenses.add']],function(){
    Route::get('/create', 'ExpensesController@create');
    Route::POST('/store/', 'ExpensesController@store');

});
Route::group(['prefix'=>'expenses','middleware' => ['permission:expenses.edit']],function(){
    Route::get('/edit/{id}', 'ExpensesController@edit');
    Route::POST('/update/{id}', 'ExpensesController@update');
});
Route::group(['prefix'=>'expenses','middleware' => ['permission:expenses.delete']],function(){
    Route::get('/destroy/{id}', 'ExpensesController@destroy');
});