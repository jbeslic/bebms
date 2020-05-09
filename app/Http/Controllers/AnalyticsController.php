<?php

namespace App\Http\Controllers;

use App\Company;
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
        $invoices = Invoice::select('*', DB::raw('MONTH(invoice_date) as invoice_month'));
        if (Auth::user()->is_admin) {
            $invoices->whereIn('company_id', [Company::BEDEV, Company::NIMU]);
        } else {
            $invoices->where('company_id', Auth::user()->company_id);
        }

        $invoices = $invoices->whereYear('invoice_date', $year)
            ->get()
            ->load('items')
            ->groupBy('invoice_month')
            ->transform(function ($invoices) {
                return $invoices->sum('total_hrk_price');
            });
        $invoiceSum = $invoices->sum();
            $invoices = $invoices->toArray();

        $taxes = Tax::select('*', DB::raw('MONTH(paid_date) as paid_month'));
        if (Auth::user()->is_admin) {
            $taxes->whereIn('company_id', [Company::BEDEV, Company::NIMU]);
        } else {
            $taxes->where('company_id', Auth::user()->company_id);
        }
        $taxes = $taxes->where('company_id', Auth::user()->company_id)
            ->whereYear('paid_date', $year)
            ->get()
            ->groupBy('paid_month')
            ->transform(function ($taxes) {
                return $taxes->sum('amount');
            });
        $taxSum = $taxes->sum();
        $taxes = $taxes->toArray();


        $expenses = Expense::select('expenses.*', DB::raw('MONTH(expenses.expense_date) as expense_month'))
            ->leftJoin('projects', 'projects.id', '=', 'expenses.project_id')
            ->whereYear('expenses.expense_date', $year);
        if (Auth::user()->is_admin) {
            $expenses->whereIn('company_id', [Company::BEDEV, Company::NIMU]);
        } else {
            $expenses->where('company_id', Auth::user()->company_id);
        }
        $expenses = $expenses->where('projects.company_id', Auth::user()->company_id)
            ->get()
            ->groupBy('expense_month')
            ->transform(function ($expenses) {
                return $expenses->sum('total_hrk_price');
            });
        $expenseSum = $expenses->sum() + $taxSum;
        $expenses = $expenses->toArray();

        for ($m = 1; $m <= 12; ++$m) {
            $labels[] = date('F', mktime(0, 0, 0, $m, 1));
            if (!isset($invoices[$m])) {
                $invoices[$m] = 0;
            }
            if (!isset($taxes[$m])) {
                $taxes[$m] = 0;
            }
            if (!isset($expenses[$m])) {
                $expenses[$m] = 0;
            }

            $expenses[$m] = $expenses[$m] + $taxes[$m];
        }
        ksort($expenses);
        ksort($invoices);
        ksort($labels);
        $expenses = collect(array_values($expenses))->toJson();
        $invoices = collect(array_values($invoices))->toJson();
        $labels = collect(array_values($labels))->toJson();

        $data = compact(
            'labels',
            'expenses',
            'invoices',
            'expenseSum',
            'invoiceSum'
        );

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
