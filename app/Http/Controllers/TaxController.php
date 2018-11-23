<?php

namespace App\Http\Controllers;


use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;

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



        $pdf = PDF::loadView('pdf.offer', array('data' => $data));
        return $pdf->download('PO-SD-'.$year.'.pdf');
    }

}
