<?php

namespace App\Http\Controllers;

use App\InvoiceItem;
use App\Unit;
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
    public function index(Request $request)
    {
        //
        $year = $request->year ?? date('Y');
        if(Auth::user()->is_admin){
            $invoices = Invoice::orderBy('company_id')->whereYear('invoice_date', $year)->get();
        }
        else {
            $invoices = Invoice::where('company_id', Auth::user()->company_id)->whereYear('invoice_date', $year)->get();
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
        $city = Company::where('id', Auth::user()->company_id)->pluck('city');
        $companies = Company::all();
        $clients = Auth::user()->is_admin ? Client::all() : Client::where('company_id', Auth::user()->company_id)->get();
        $remarks = Auth::user()->is_admin ? Remark::all() : Remark::where('company_id', Auth::user()->company_id)->get();
        $units = Auth::user()->is_admin ? Unit::all() : Unit::where('company_id', Auth::user()->company_id)->get();

        return view ('invoice/create')->with(compact('clients', 'remarks', 'units', 'datetime', 'city', 'payment_deadline', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, array(
            'amount.*' => 'nullable|numeric',
            'price.*' => 'nullable|numeric',
            'invoice_date' => 'required',
            'invoice_time' => 'required',
            'city' => 'required|max:30',
            'payment_deadline' => 'required',
        ));

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
        $invoice->city = $request->city;
        $invoice->currency = $request->currency;

        if($request->currency == 'EUR'){
            $client = new \GuzzleHttp\Client();
            $req = $client->get('http://api.hnb.hr/tecajn/v1?valuta=EUR');
            $response = $req->getBody();
            $data = json_decode($response, true);

            $invoice->hnb_middle_exchange = str_replace(',', '.', str_replace('.', '', $data[0]["Srednji za devize"]));
        }

        $invoice->save();

        foreach ($request->description as $key => $description){
            if($request->amount[$key]&&$request->price[$key]){
                $invoice_item = new InvoiceItem();
                $invoice_item->invoice_id = $invoice->id;
                $invoice_item->unit_id = $request->unit[$key];
                $invoice_item->amount = $request->amount[$key];
                $invoice_item->price = $request->price[$key];
                $invoice_item->discount = $request->discount[$key];
                $invoice_item->description = $request->description[$key];
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $invoice = Invoice::find($id);
        $companies = Company::all();
        $items = InvoiceItem::where('invoice_id', $id)->get();
        $clients = Client::where('company_id', $company_id)->get();
        $remarks = Remark::where('company_id', $company_id)->get();
        $units = Unit::where('company_id', $company_id)->get();
        $uri = url('invoice/'.$id);

        return view('invoice/edit')->with(compact('invoice', 'companies', 'items', 'clients', 'remarks', 'units', 'uri'));

        //$items = InvoiceItem::where('invoice_id',$id)->join('products', 'invoice_items.product_id', '=', 'products.id')->join('units', 'invoice_item.unit_id', '=', 'units.id')->get(['invoice_items.*', 'products.code', 'products.description','unit.name']);

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
        $this->validate($request, array(
            'amount.*' => 'nullable|numeric',
            'price.*' => 'nullable|numeric',
            'invoice_date' => 'required',
            'invoice_time' => 'required',
            'city' => 'required|max:30',
            'payment_deadline' => 'required',
        ));

        $invoice = Invoice::find($id);
        $invoice->update([
            'company_id' => Auth::user()->is_admin? $request->company : Auth::user()->company_id,
            'client_id' => $request->client,
            'invoice_date' => $request->invoice_date,
            'invoice_time' => $request->invoice_time,
            'payment_deadline' => $request->payment_deadline,
            'remark_id' => $request->remark,
            'payment_type' => $request->payment_type,
            'city' => $request->city,
            'currency' => $request->currency,
            'hnb_middle_exchange' => $request->hnb_middle_exchange,
            'is_paid' => $request->is_paid ? 1 : 0,
            'paid' => $request->is_paid ? $request->paid : null,
        ]);

        $items = InvoiceItem::where('invoice_id', $id)->get();
        foreach($items as $item){
            $item->delete();
        }

        foreach ($request->description as $key => $description){
            if($request->amount[$key]&&$request->price[$key]){
                $invoice_item = new InvoiceItem();
                $invoice_item->invoice_id = $invoice->id;
                $invoice_item->unit_id = $request->unit[$key];
                $invoice_item->amount = $request->amount[$key];
                $invoice_item->price = $request->price[$key];
                $invoice_item->discount = $request->discount[$key];
                $invoice_item->description = $request->description[$key];
                $invoice_item->save();
            }
        }

        return redirect()->route('invoice.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->items()->delete();
        $invoice->delete();
        return redirect()->route('invoice.index');

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
        $data['currency'] = $invoice->currency;
        $data['hnb_middle_exchange'] = $invoice->hnb_middle_exchange;
        $data['payment_type'] = $invoice->payment_type;
        $data['payment_deadline'] = Carbon::parse($invoice->payment_deadline)->format('d.m.Y');
        $data['items'] = array();
        $data['invoice_number'] = $invoice->invoice_number;
        $data['total_price'] = $invoice->total_price;
        $data['total_hrk_price'] = $invoice->total_hrk_price;
        $data['discount_price'] = $invoice->discount_price;

        foreach ($invoice->items as $key => $item){
            $items['price'] = $item->price;
            $items['total_price'] = $item->total_price;
            $items['total_hrk_price'] = $item->total_hrk_price;
            $items['unit'] = $item->unit;
            $items['discount'] = $item->discount;
            $items['description'] = $item->description;
            $items['amount'] = $item->amount;
            $items['price_per_unit'] = $item->price;
            
            $data['items'][] = $items;
        }



        $value = sprintf( '%015d', $data['total_hrk_price'] * 100);
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
        $data['year'] = $year;

        $data['barcode'] = DNS2D::getBarcodePNG($code, "PDF417");

        $pdf = PDF::loadView('pdf.invoice', array('data' => $data));
        return $pdf->download('invoice-'.$data['invoice_number'].'-'.$year.'.pdf');
    }
}
