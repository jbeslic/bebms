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
Route::group(['middleware'=>'auth'], function(){
    Route::resource('/product', 'ProductController');
    Route::resource('/client', 'ClientController');
    Route::resource('/invoice', 'InvoiceController');
    Route::resource('/company', 'CompanyController');
    Route::resource('/memo', 'MemoController');
    Route::get('/memo/{id}/pdf', 'MemoController@createPdf')->name('memo.pdf');
    Route::get('/invoice/{id}/pdf', 'InvoiceController@createPdf')->name('invoice.pdf');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/pdf', 'HomeController@pdf')->name('pdf');
