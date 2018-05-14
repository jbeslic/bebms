@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Uredi podatke o obrtu</div>

                <div class="card-body">
                    {!! Form::open(array('url' => $uri, 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('name', 'Naziv obrta:') }}
                            {{ Form::text('name', $company->name, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('owner', 'Vlasnik:') }}
                            {{ Form::text('owner', $company->owner, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('address', 'Adresa:') }}
                            {{ Form::text('address', $company->address, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('zip_code', 'Poštanski br:') }}
                            {{ Form::text('zip_code', $company->zip_code, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('city', 'Mjesto:') }}
                            {{ Form::text('city', $company->city, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('oib', 'OIB:') }}
                            {{ Form::text('oib', $company->oib, array('class'=>'form-control', 'maxlength'=>'11', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('iban', 'IBAN:') }}
                            {{ Form::text('iban', $company->iban, array('class'=>'form-control', 'maxlength'=>'34', 'required'=>'')) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('bank_info', 'Banka:') }}
                            {{ Form::text('bank_info', $company->bank_info, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('activity', 'Djelatnost:') }}
                            {{ Form::text('activity', $company->activity, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('logo', 'Logo:') }}
                            {{ Form::file('logo', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            {{ Form::submit('Spremi', array('class'=>'btn btn-success btn-block')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection