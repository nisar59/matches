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

Route::group(['prefix'=>'category','middleware' => ['permission:category.view']],function(){
    Route::get('/', 'CategoryController@index');
});

Route::group(['prefix'=>'category','middleware' => ['permission:category.add']],function(){
    Route::get('/create', 'CategoryController@create');
    Route::POST('/store/', 'CategoryController@store');

});
Route::group(['prefix'=>'category','middleware' => ['permission:category.edit']],function(){
    Route::get('/edit/{id}', 'CategoryController@edit');
    Route::POST('/update/{id}', 'CategoryController@update');
});
Route::group(['prefix'=>'category','middleware' => ['permission:category.delete']],function(){
    Route::get('/destroy/{id}', 'CategoryController@destroy');
});