<?php

namespace App\Http\Controllers;


use App\Company;
use App\Tax;
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
        $data['year'] = $year;
        $data['company'] = Company::find(Auth::user()->company_id);

        $data['invoice'][1] = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('paid', [Carbon::create($year, 1, 0), Carbon::create($year, 3, 31)])->get()->sum('total_hrk_price');
        $data['invoice'][2] = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('paid', [Carbon::create($year, 4, 0), Carbon::create($year, 6, 30)])->get()->sum('total_hrk_price');
        $data['invoice'][3] = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('paid', [Carbon::create($year, 7, 0), Carbon::create($year, 9, 30)])->get()->sum('total_hrk_price');
        $data['invoice'][4] = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('paid', [Carbon::create($year, 10, 0), Carbon::create($year, 12, 31)])->get()->sum('total_hrk_price');

        $data['invoice']['sum'] = collect($data['invoice'])->sum();

        $data['tax'][1] = Tax::whereCompanyId(Auth::user()->company_id)->whereBetween('paid_date', [Carbon::create($year, 1, 0), Carbon::create($year, 3, 31)])->get()->sum('amount');
        $data['tax'][2] = Tax::whereCompanyId(Auth::user()->company_id)->whereBetween('paid_date', [Carbon::create($year, 4, 0), Carbon::create($year, 6, 30)])->get()->sum('amount');
        $data['tax'][3] = Tax::whereCompanyId(Auth::user()->company_id)->whereBetween('paid_date', [Carbon::create($year, 7, 0), Carbon::create($year, 9, 30)])->get()->sum('amount');
        $data['tax'][4] = Tax::whereCompanyId(Auth::user()->company_id)->whereBetween('paid_date', [Carbon::create($year, 10, 0), Carbon::create($year, 12, 31)])->get()->sum('amount');

        $data['tax']['sum'] = collect($data['tax'])->sum();


        $pdf = PDF::loadView('pdf.posd', array('data' => $data))->setPaper('a4', 'landscape');
        return $pdf->stream('PO-SD-'.$year.'.pdf');
    }

    public function index()
    {
        //
        if(Auth::user()->is_admin){
            $taxes = Tax::orderBy('company_id')->get();
        }
        else {
            $taxes = Tax::where('company_id', Auth::user()->company_id)->get();
        }

        return view('tax.index')->with('taxes', $taxes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();

        return view ('tax/create')->with('companies', $companies);
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
            'amount' => 'nullable|numeric',
            'paid_date' => 'required',
        ));

        $tax = new Tax();

        $tax->company_id = Auth::user()->is_admin ? $request->company : Auth::user()->company_id;

        $tax->paid_date = $request->paid_date;
        $tax->amount = $request->amount;

        $tax->save();

        return redirect()->route('tax.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tax = Tax::find($id);
        $tax->delete();
        return redirect()->route('tax.index');

    }




}
