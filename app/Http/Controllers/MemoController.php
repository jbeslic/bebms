<?php

namespace App\Http\Controllers;

use App\Client;
use App\Company;
use App\Memo;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        if(Auth::user()->is_admin){
            $memos = Memo::orderBy('company_id')->get();
        }
        else {
            $memos = Memo::where('company_id', Auth::user()->company_id)->get();
        }

        return view('memo.index')->with('memos', $memos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $companies = Company::all();
        $clients = Auth::user()->is_admin ? Client::all() : Client::where('company_id', Auth::user()->company_id)->get();


        return view ('memo/create')->with(compact('clients', 'companies'));
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
        $memo = new Memo();

        $memo->company_id = Auth::user()->is_admin ? $request->company : Auth::user()->company_id;
        $memo->client_id = $request->client;
        $memo->content = $request->data_content;
        $memo->save();

        return redirect()->route('memo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $memo = Memo::find($id);
        $companies = Company::all();
        $clients = Client::where('company_id', Auth::user()->company_id)->get();
        $uri = url('memo/'.$id);

        return view('memo/edit')->with(compact('memo', 'companies', 'clients', 'uri'));
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
        $memo = Memo::find($id);
        $memo->update([
            'company_id' => Auth::user()->is_admin? $request->company : Auth::user()->company_id,
            'client_id' => $request->client,
            'content' => $request->data_content,
        ]);

        return redirect()->route('memo.index');
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
        $memo = Memo::find($id);
        $memo->delete();
        return redirect()->route('memo.index');
    }

    public function createPdf($id)
    {
        $memo = Memo::find($id);
        $year = date('Y');

        $data['company'] = Company::find($memo->company_id);
        $data['client'] = Client::find($memo->client_id);
        $data['content'] = $memo->content;

        $pdf = PDF::loadView('pdf.memo', array('data' => $data));
        return $pdf->download('memo-'.$memo->id.'-'.$year.'.pdf');
    }
}
