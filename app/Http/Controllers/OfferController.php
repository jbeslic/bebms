<?php

namespace App\Http\Controllers;

use App\OfferItem;
use App\Unit;
use App\Product;
use App\Remark;
use Illuminate\Http\Request;
use App\Offer;
use App\Client;
use App\Company;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS2D;
use PDF;
use Carbon\Carbon;
class OfferController extends Controller
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
            $offers = Offer::orderBy('company_id')->get();
        }
        else {
            $offers = Offer::where('company_id', Auth::user()->company_id)->get();
        }

        return view('offer.index')->with('offers', $offers);
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
        //$offer_number = Offer::whereYear('offer_date', date("Y"))->count()+1;
        $companies = Company::all();
        $clients = Auth::user()->is_admin ? Client::all() : Client::where('company_id', Auth::user()->company_id)->get();
        $remarks = Auth::user()->is_admin ? Remark::all() : Remark::where('company_id', Auth::user()->company_id)->get();
        $units = Auth::user()->is_admin ? Unit::all() : Unit::where('company_id', Auth::user()->company_id)->get();
        $products = Auth::user()->is_admin ? Product::all() : Product::where('company_id', Auth::user()->company_id)->get();

        return view ('offer/create')->with(compact('clients', 'remarks', 'units', 'products', 'offer_number', 'datetime', 'city', 'payment_deadline', 'companies'));
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
            'offer_date' => 'required',
            'offer_time' => 'required',
            'city' => 'required|max:30',
            'payment_deadline' => 'required',
        ));

        $offer = new Offer();

        $offer->company_id = Auth::user()->is_admin ? $request->company : Auth::user()->company_id;
        $offer->client_id = $request->client;
        $offer->offer_number = Offer::whereYear('offer_date', date("Y"))->where('company_id', $offer->company_id)->count()+1;
        $offer->offer_date = $request->offer_date;
        $offer->delivery_date = $request->offer_date; //@todo
        $offer->offer_time = $request->offer_time;
        $offer->payment_deadline = $request->payment_deadline;
        $offer->remark_id = $request->remark;
        $offer->payment_type = $request->payment_type;
        $offer->city = $request->city;
        $offer->save();

        foreach ($request->product as $key => $product){
            if(in_array($product, Product::pluck('code')->toArray())){
                if($request->amount[$key]&&$request->price[$key]){
                    $offer_item = new OfferItem();
                    $offer_item->offer_id = $offer->id;
                    $offer_item->product_id = Product::whereCode($product)->whereCompanyId(Auth::user()->company_id)->first()->id;
                    $offer_item->unit_id = $request->unit[$key];
                    $offer_item->amount = $request->amount[$key];
                    $offer_item->price = $request->price[$key];
                    $offer_item->discount = 0;
                    $offer_item->save();
                }
            }
        }

        return redirect()->route('offer.index');
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

        $offer = Offer::find(1);
        $offer->items;

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
        $offer = Offer::find($id);
        $companies = Company::all();
        $items = OfferItem::where('offer_id', $id)->get();
        $clients = Client::where('company_id', $company_id)->get();
        $remarks = Remark::where('company_id', $company_id)->get();
        $products = Product::where('company_id', $company_id)->get();
        $units = Unit::where('company_id', $company_id)->get();
        $uri = url('offer/'.$id);

        return view('offer/edit')->with(compact('offer', 'companies', 'items', 'clients', 'remarks', 'products', 'units', 'uri'));

        //$items = OfferItem::where('offer_id',$id)->join('products', 'offer_items.product_id', '=', 'products.id')->join('units', 'offer_item.unit_id', '=', 'units.id')->get(['offer_items.*', 'products.code', 'products.description','unit.name']);

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
            'offer_date' => 'required',
            'offer_time' => 'required',
            'city' => 'required|max:30',
            'payment_deadline' => 'required',
        ));

        $offer = Offer::find($id);
        $offer->update([
            'company_id' => Auth::user()->is_admin? $request->company : Auth::user()->company_id,
            'client_id' => $request->client,
            'offer_date' => $request->offer_date,
            'offer_time' => $request->offer_time,
            'payment_deadline' => $request->payment_deadline,
            'remark_id' => $request->remark,
            'payment_type' => $request->payment_type,
            'city' => $request->city,
            'is_paid' => $request->is_paid ? 1 : 0,
            'paid' =>$request->is_paid ? $request->paid : null,
        ]);

        $items = OfferItem::where('offer_id', $id)->get();
        foreach($items as $item){
            $item->delete();
        }

        foreach ($request->product as $key => $product){
            if(in_array($product, Product::pluck('code')->toArray())){
                if($request->amount[$key]&&$request->price[$key]){
                    $offer_item = new OfferItem();
                    $offer_item->offer_id = $offer->id;
                    $offer_item->product_id = Product::whereCode($product)->whereCompanyId(Auth::user()->company_id)->first()->id;
                    $offer_item->unit_id = $request->unit[$key];
                    $offer_item->amount = $request->amount[$key];
                    $offer_item->price = $request->price[$key];
                    $offer_item->discount = 0;
                    $offer_item->save();
                }
            }
        }

        return redirect()->route('offer.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::find($id);
        $offer->items()->delete();
        $offer->delete();
        return redirect()->route('offer.index');

    }

    public function createPdf($id)
    {
        $offer = Offer::find($id);

        $data['company'] = Company::find($offer->company_id);
        $data['client'] = Client::find($offer->client_id);
        $data['remark'] = Remark::find($offer->remark_id);
        $data['offer_date'] = Carbon::parse($offer->offer_date)->format('d.m.Y');
        $data['offer_time'] = $offer->offer_time;
        $data['place'] = $offer->city;
        $data['payment_type'] = $offer->payment_type;
        $data['payment_deadline'] = Carbon::parse($offer->payment_deadline)->format('d.m.Y');
        $data['items'] = array();
        $data['offer_number'] = $offer->offer_number;
        $data['total_price'] = $offer->totalPrice();
        foreach ($offer->items as $key => $item){
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
{$data['offer_number']}-{$year}\r
COST\r
Placanje po ponudi {$data['offer_number']}-{$year}\r"; //important to stay formated as this

        //dd($code);

        $data['barcode'] = DNS2D::getBarcodePNG($code, "PDF417");

        $pdf = PDF::loadView('pdf.offer', array('data' => $data));
        return $pdf->download('offer-'.$data['offer_number'].'-'.$year.'.pdf');
    }
}
