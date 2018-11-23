<?php

namespace App\Http\Controllers;


use App\Company;
use App\Invoice;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function posd($year)
    {

        $data = array();
        $data['company'] = Company::find(Auth::user()->company_id);

        $data['invoice'][1] = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('invoice_date', [Carbon::create($year, 1, 0), Carbon::create($year, 3, 31)])->get()->sum('total_price');
        $data['invoice'][2] = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('invoice_date', [Carbon::create($year, 4, 0), Carbon::create($year, 6, 30)])->get()->sum('total_price');
        $data['invoice'][3] = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('invoice_date', [Carbon::create($year, 7, 0), Carbon::create($year, 9, 30)])->get()->sum('total_price');
        $data['invoice'][4] = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('invoice_date', [Carbon::create($year, 10, 0), Carbon::create($year, 12, 31)])->get()->sum('total_price');

        $data['invoice']['sum'] = collect($data['invoice'])->sum();


        $pdf = PDF::loadView('pdf.posd', array('data' => $data))->setPaper('a4', 'landscape');
        return $pdf->download('PO-SD-'.$year.'.pdf');
    }

}
