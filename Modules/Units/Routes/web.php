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

Route::prefix('units')->group(function() {
    Route::get('/', 'UnitsController@index');
});


Route::group(['prefix'=>'units','middleware' => ['permission:units.view']],function(){
    Route::get('/', 'UnitsController@index');
});

Route::group(['prefix'=>'units','middleware' => ['permission:units.add']],function(){
    Route::get('/create', 'UnitsController@create');
    Route::POST('/store/', 'UnitsController@store');

});
Route::group(['prefix'=>'units','middleware' => ['permission:units.edit']],function(){
    Route::get('/edit/{id}', 'UnitsController@edit');
    Route::POST('/update/{id}', 'UnitsController@update');
});
Route::group(['prefix'=>'units','middleware' => ['permission:units.delete']],function(){
    Route::get('/destroy/{id}', 'UnitsController@destroy');
});