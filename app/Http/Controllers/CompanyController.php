<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Illuminate\Support\Facades\Storage;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::find(1);
        return view('company/index')->with(compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'logo' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        Storage::putFile('public', $request->file('logo'));
        $url = Storage::url($request->file('logo')->hashName());
        

        $company = new Company;
        $company->name = $request->name;
        $company->owner = $request->owner;
        $company->address = $request->address;
        $company->zip_code = $request->zip_code;
        $company->city = $request->city;
        $company->oib = $request->oib;
        $company->iban = $request->iban;
        $company->bank_info = $request->bank_info;
        $company->activity = $request->activity;
        $company->logo_path = env('APP_URL').$url;
        $company->save();

        return redirect()->route('company.index');
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
        $company = Company::find($id);
        $uri = url('company/'.$id);
        return view('company/edit')->with(compact('company', 'uri'));
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
        $this->validate($request, [
            'logo' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        $company = Company::find($id);

        if($request->file('logo')==null){
            $url=$company->logo_path;
        }
        else{
            Storage::putFile('public', $request->file('logo'));
            $url = env('APP_URL').Storage::url($request->file('logo')->hashName());
        };
            
        $company->update([
            'name' => $request->name,
            'owner' => $request->owner,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'oib' => $request->oib,
            'iban' => $request->iban,
            'bank_info' => $request->bank_info,
            'activity' => $request->activity,
            'logo_path' => $url
        ]);
        return redirect()->route('company.index');
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
