<?php

namespace App\Http\Controllers;


use App\Company;
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

        $pdf = PDF::loadView('pdf.posd', array('data' => $data))->setPaper('a4', 'landscape');
        return $pdf->download('PO-SD-'.$year.'.pdf');
    }

}
