@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Opći podaci o obrtu</div>

                <div class="card-body">
                    {!! Form::open(array('route' => 'company.store', 'enctype' => 'multipart/form-data')) !!}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('name', 'Naziv obrta:') }}
                            {{ Form::text('name', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('owner', 'Vlasnik:') }}
                            {{ Form::text('owner', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('address', 'Adresa:') }}
                            {{ Form::text('address', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('zip_code', 'Poštanski br:') }}
                            {{ Form::text('zip_code', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('city', 'Mjesto:') }}
                            {{ Form::text('city', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('oib', 'OIB:') }}
                            {{ Form::text('oib', null, array('class'=>'form-control', 'maxlength'=>'11', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('iban', 'IBAN:') }}
                            {{ Form::text('iban', null, array('class'=>'form-control', 'maxlength'=>'34', 'required'=>'')) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('bank_info', 'Banka:') }}
                            {{ Form::text('bank_info', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('activity', 'Djelatnost:') }}
                            {{ Form::text('activity', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('logo', 'Logo:') }}
                            {{ Form::file('logo', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('color', 'Boja:') }}
                            {{ Form::text('color', null, array('class'=>'form-control', 'required'=>'')) }}
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