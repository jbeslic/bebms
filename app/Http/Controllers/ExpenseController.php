<?php

namespace App\Http\Controllers;

use App\Associate;
use App\Expense;
use App\Project;
use App\Unit;
use App\Remark;
use Illuminate\Http\Request;
use App\Client;
use App\Company;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ExpenseController extends Controller
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
        $query = Expense::select(
            'companies.name as company_name',
            'projects.name as project_name',
            'associates.name as associate_name',
            'expenses.*'
        )
            ->leftJoin('projects', 'projects.id', '=', 'expenses.project_id')
            ->leftJoin('companies', 'projects.company_id', '=', 'companies.id')
            ->leftJoin('associates', 'expenses.associate_id', '=', 'associates.id')
            ->whereYear('expenses.expense_date', $year);

        if(!Auth::user()->is_admin){
            $query = $query->where('projects.company_id', Auth::user()->company_id);
        }
        $expenses = $query->get();

        return view('expense.index')->with('expenses', $expenses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $datetime = Carbon::now();
        $companies = Company::all();
        $associates = Auth::user()->is_admin ? Associate::all() : Associate::where('company_id', Auth::user()->company_id)->get();
        $projects = Auth::user()->is_admin ? Project::all() : Project::where('company_id', Auth::user()->company_id)->get();
        $units = Auth::user()->is_admin ? Unit::all() : Unit::where('company_id', Auth::user()->company_id)->get();

        return view ('expense/create')->with(compact( 'associates', 'units', 'datetime', 'projects', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, array(
            'amount' => 'numeric|required',
            'price' => 'numeric|required',
            'expense_date' => 'required',
            'description' => 'required',
            'currency' => 'required',
        ));

        $expense = new Expense();
        $expense->project_id = $request->project_id;
        $expense->associate_id = $request->associate_id;
        $expense->expense_date = $request->expense_date;
        $expense->currency = $request->currency;
        $expense->unit_id = $request->unit_id;
        $expense->amount = $request->amount;
        $expense->price = $request->price;
        $expense->discount = $request->discount;
        $expense->description = $request->description;



        if($request->currency == 'EUR'){
            $client = new \GuzzleHttp\Client();
            $req = $client->get('http://api.hnb.hr/tecajn/v1?valuta=EUR');
            $response = $req->getBody();
            $data = json_decode($response, true);

            $expense->hnb_middle_exchange = str_replace(',', '.', str_replace('.', '', $data[0]["Srednji za devize"]));
        }

        $expense->save();

        return redirect()->route('expense.index');
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

        $expense = Expense::find(1);
        $expense->items;

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
        $expense = Expense::find($id);
        $companies = Company::all();
        $associates = Auth::user()->is_admin ? Associate::all() : Associate::where('company_id', Auth::user()->company_id)->get();
        $projects = Auth::user()->is_admin ? Project::all() : Project::where('company_id', Auth::user()->company_id)->get();
        $units = Auth::user()->is_admin ? Unit::all() : Unit::where('company_id', Auth::user()->company_id)->get();

        $uri = url('expense/'.$id);

        return view('expense/edit')->with(compact('expense', 'companies', 'projects', 'associates', 'units', 'uri'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'amount' => 'numeric|required',
            'price' => 'numeric|required',
            'expense_date' => 'required',
            'description' => 'required',
            'currency' => 'required',
        ));

        $expense = Expense::find($id);
        $expense->project_id = $request->project_id;
        $expense->associate_id = $request->associate_id;
        $expense->expense_date = $request->expense_date;
        $expense->currency = $request->currency;
        $expense->hnb_middle_exchange = $request->hnb_middle_exchange;
        $expense->unit_id = $request->unit_id;
        $expense->amount = $request->amount;
        $expense->price = $request->price;
        $expense->discount = $request->discount;
        $expense->description = $request->description;

        return redirect()->route('expense.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();
        return redirect()->route('expense.index');

    }

}