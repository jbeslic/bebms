<?php

namespace App\Http\Controllers;

use Milon\Barcode\DNS2D;
use PDF;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdf()
    {

        $code = "HRVHUB30\r
HRK\r
000000000012355\r
ZELJKO SENEKOVIC\r
IVANECKA ULICA 125\r
42000 VARAZDIN\r
2DBK d.d.\r
ALKARSKI PROLAZ 13B\r
21230 SINJ\r
HR1210010051863000160\r
HR01\r
7269-68949637676-00019\r
COST\r
Troskovi za 1. mjesec\r";

        $data = array();
        $data['barcode'] = DNS2D::getBarcodePNG($code, "PDF417");

        $pdf = PDF::loadView('pdf.invoice', array('data' => $data));
        return $pdf->download('invoice.pdf');
    }
}
