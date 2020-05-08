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
    Route::resource('/client', 'ClientController');
    Route::resource('/invoice', 'InvoiceController');
    Route::resource('/offer', 'OfferController');
    Route::resource('/company', 'CompanyController');
    Route::resource('/memo', 'MemoController');
    Route::resource('/tax', 'TaxController');
    Route::resource('/expense', 'ExpenseController');
    Route::get('/memo/{id}/pdf', 'MemoController@createPdf')->name('memo.pdf');
    Route::get('/invoice/{id}/pdf', 'InvoiceController@createPdf')->name('invoice.pdf');
    Route::get('/offer/{id}/pdf', 'OfferController@createPdf')->name('offer.pdf');
    Route::get('/offer/{id}/invoice', 'OfferController@createInvoice')->name('offer.invoice');
    Route::get('/po-sd/{year}/pdf', 'TaxController@posd')->name('tax.pdf');
});

Route::get('/', function () {

    if(auth()->user()) return redirect(route('company.index'));

    return redirect('https://www.bedev.hr/');
});

Auth::routes();

