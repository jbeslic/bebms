<?php

namespace App\Http\Controllers;

use App\InvoiceItem;
use App\Unit;
use App\Product;
use App\Remark;
use Illuminate\Http\Request;
use App\Invoice;
use App\Client;
use App\Company;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS2D;
use PDF;
use Carbon\Carbon;
class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->is_admin){
            $invoices = Invoice::orderBy('company_id')->get();
        }
        else {
            $invoices = Invoice::where('company_id', Auth::user()->company_id)->get();
        }

        return view('invoice.index')->with('invoices', $invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datetime = Carbon::now();
        $payment_deadline = Carbon::now()->addDays(10); //get hardcoded number of days from conf/settings
        $place = Company::where('id', Auth::user()->company_id)->pluck('city');
        //$invoice_number = Invoice::whereYear('invoice_date', date("Y"))->count()+1;
        $companies = Company::all();
        $clients = Auth::user()->is_admin ? Client::all() : Client::where('company_id', Auth::user()->company_id)->get();
        $remarks = Remark::all();
        $units = Unit::all();
        $products = Product::all();

        return view ('invoice/create')->with(compact('clients', 'remarks', 'units', 'products', 'invoice_number', 'datetime', 'place', 'payment_deadline', 'companies'));
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
        $invoice = new Invoice();

        $invoice->company_id = Auth::user()->is_admin ? $request->company : Auth::user()->company_id;
        $invoice->client_id = $request->client;
        $invoice->invoice_number = Invoice::whereYear('invoice_date', date("Y"))->where('company_id', $invoice->company_id)->count()+1;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->delivery_date = $request->invoice_date; //@todo
        $invoice->invoice_time = $request->invoice_time;
        $invoice->payment_deadline = $request->payment_deadline;
        $invoice->remark_id = $request->remark;
        $invoice->payment_type = $request->payment_type;
        $invoice->city = $request->place;
        $invoice->save();

        foreach ($request->product as $key => $product){
            if(in_array($product, Product::pluck('code')->toArray())){
                $invoice_item = new InvoiceItem();
                $invoice_item->invoice_id = $invoice->id;
                $invoice_item->product_id = Product::whereCode($product)->first()->id;
                $invoice_item->unit_id = $request->unit[$key];
                $invoice_item->amount = $request->amount[$key];
                $invoice_item->price = $request->price[$key];
                $invoice_item->discount = 0;
                $invoice_item->save();
            }
        }

        return redirect()->route('invoice.index');
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

        $invoice = Invoice::find(1);
        $invoice->items;

        return view('home');

        dd($invoice->items);

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

    public function createPdf($id)
    {
        $invoice = Invoice::find($id);

        $data['company'] = Company::find($invoice->company_id);
        $data['client'] = Client::find($invoice->client_id);
        $data['remark'] = Remark::find($invoice->remark_id);
        $data['invoice_date'] = Carbon::parse($invoice->invoice_date)->format('d.m.Y');
        $data['invoice_time'] = $invoice->invoice_time;
        $data['place'] = $invoice->city;
        $data['payment_type'] = $invoice->payment_type;
        $data['payment_deadline'] = Carbon::parse($invoice->payment_deadline)->format('d.m.Y');
        $data['items'] = array();
        $data['invoice_number'] = $invoice->invoice_number;
        $data['total_price'] = $invoice->totalPrice();
        foreach ($invoice->items as $key => $item){
            $items['product'] = $item->product;
            $items['unit'] = $item->unit;
            $items['amount'] = $item->amount;
            $items['price_per_unit'] = $item->price;
            $items['price'] = $item->total_price;

            $data['items'][] = $items;
        }



        $value = sprintf( '%015d', $data['total_price'] * 100);
        $year = date('Y');
        $code = "HRVHUB30\r
HRK\r
$value\r
{$data['client']->name}\r
{$data['client']->address}\r
{$data['client']->zip_code} {$data['client']->city}\r
{$data['company']->name}\r
{$data['company']->address}\r
{$data['company']->zip_code} {$data['company']->city}\r
{$data['company']->iban}\r
HR00\r
{$data['invoice_number']}-{$year}\r
COST\r
Placanje po racunu {$data['invoice_number']}-{$year}\r"; //important to stay formated as this

        //dd($code);

        $data['barcode'] = DNS2D::getBarcodePNG($code, "PDF417");

        $pdf = PDF::loadView('pdf.invoice', array('data' => $data));
        return $pdf->download('invoice-'.$data['invoice_number'].'-'.$year.'.pdf');
    }
}
