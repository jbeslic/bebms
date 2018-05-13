<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Product;
use App\Remark;
use Illuminate\Http\Request;
use App\Invoice;
use App\Client;
use Carbon\Carbon;
use App\Company;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $time = Carbon::now()->format('H:i');
        $date = Carbon::now()->format('d.m.Y');
        $payment_deadline = Carbon::now()->addDays(10)->format('d.m.Y'); //get hardcoded number of days from conf/settings
        $place = Company::where('id',1)->pluck('city');
        $invoice_number = Invoice::whereYear('invoice_date', date("Y"))->count()+1;
        $clients = Client::all(); //\Auth::user()->company_id
        $remarks = Remark::all();
        $units = Unit::all();
        $products = Product::all();

        return view ('invoice/create')->with(compact('clients', 'remarks', 'units', 'products', 'invoice_number', 'date', 'time', 'place', 'payment_deadline'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
