<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Invoice;
use App\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year = $request->year ?? date('Y');
        $invoices = Invoice::select('*', DB::raw('MONTH(invoice_date) as invoice_month'))
            ->where('company_id', Auth::user()->company_id)
            ->whereYear('invoice_date', $year)
            ->get()
            ->load('items')
            ->groupBy('invoice_month')
            ->transform(function ($invoices){
                return $invoices->sum('total_hrk_price');
            })->toArray();

        $taxes = Tax::select('*', DB::raw('MONTH(paid_date) as paid_month'))
            ->where('company_id', Auth::user()->company_id)
            ->whereYear('paid_date', $year)
            ->get()
            ->groupBy('paid_month')
            ->transform(function ($taxes){
                return $taxes->sum('amount');
            })->toArray();


        $expenses = Expense::select('expenses.*', DB::raw('MONTH(expenses.expense_date) as expense_month'))
            ->leftJoin('projects', 'projects.id', '=', 'expenses.project_id')
            ->whereYear('expenses.expense_date', $year)
            ->where('projects.company_id', Auth::user()->company_id)
            ->get()
            ->groupBy('expense_month')
            ->transform(function ($expenses){
                return $expenses->sum('total_hrk_price');
            })->toArray();

        for($m=1; $m<=12; ++$m){
            $labels[] = date('F', mktime(0, 0, 0, $m, 1));
            if(!isset($invoices[$m])){
                $invoices[$m] = 0;
            }
            if(!isset($taxes[$m])){
                $taxes[$m] = 0;
            }
            if(!isset($expenses[$m])){
                $expenses[$m] = 0;
            }

            $expenses[$m] = $expenses[$m] + $taxes[$m];
        }

        $expenses = collect($expenses)->toJson();
        $invoices = collect($invoices)->toJson();
        $labels = collect($labels)->toJson();

        $data = compact(
            'labels',
            'expenses',
            'invoices'
        );

        dd($data);

        return view('analytics.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
