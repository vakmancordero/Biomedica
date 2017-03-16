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

Route::get('/', function () {
    return view('home');
});

Route::get('/angular/type', function () {
    return view('angular-templates.type');
});

Route::get('/search/equipos', 'BiomedicalController@equipos');

Route::get('/search/personas/{number}',array('as'=>'test','uses'=>'BiomedicalController@personas'));

Route::post('/create/persona', 'BiomedicalController@store');