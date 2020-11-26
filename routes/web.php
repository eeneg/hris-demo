<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index');

Auth::routes(['register' => false]);

Route::post('/generateId', 'PDFcontroller@employeeId');

Route::post('/generatePDS', 'PDFcontroller@pds');

Route::get('{path}', 'HomeController@index')->where( 'path','([-a-z0-9_\s]+)' );


// Route::get('/workExpFormat', 'Helpers@workExperienceFormat');
// Route::get('/volWorkFormat', 'Helpers@voluntaryWorksFormat');
// Route::get('/trainingFormat', 'Helpers@trainingFormat');
// Route::get('/makePlantilla', 'Helpers@makePlantilla');
// Route::get('/initSettings', 'Helpers@initSettings');