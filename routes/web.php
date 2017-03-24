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

Route::get('/search/equipos', 'BiomedicalController@equipos');

Route::get('/search/personas/{number}',array('as'=>'test','uses'=>'BiomedicalController@personas'));

Route::get('/search/asignaciones', 'BiomedicalController@asignaciones');

Route::post('/create/persona', 'BiomedicalController@store_persona');

Route::post('/create/asignacion', 'BiomedicalController@store_asignacion');

Route::post('/delete/asignacion', 'BiomedicalController@delete_asignacion');