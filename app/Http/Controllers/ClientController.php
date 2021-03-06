<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Company;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
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
        if(Auth::user()->is_admin){
            $clients = Client::join('companies', 'clients.company_id', '=', 'companies.id')->orderBy('company_id')->get(['clients.*', 'companies.name as company_name']);
            return view('client/index_admin')->with('clients', $clients);
        }

        $clients = Client::where('company_id', Auth::user()->company_id)->get();
        return view('client/index')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin){
            $companies = Company::all();
            return view('client/create')->with(compact('companies'));
        }

        return view('client/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $this->validate($request, array(
            
        ));

        $client = new Client;
        $client->company_id = Auth::user()->is_admin ? $request->company: Auth::user()->company_id;
        $client->name = $request->name;
        $client->address = $request->address;
        $client->zip_code = $request->zip_code;
        $client->city = $request->city;
        $client->oib = $request->oib;

        $client->save();

        return redirect()->route('client.index');
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
        $client = Client::find($id);
        $uri = url('client/'.$id);
        return view ('client.edit')->with(compact('client', 'uri'));
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
        $client = Client::find($id);
        $client->update([
            'name' => $request->name,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'oib' => $request->oib
        ]);
 
        return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::where('id', $id)->delete();
        return redirect()->route('client.index');
    }
}
