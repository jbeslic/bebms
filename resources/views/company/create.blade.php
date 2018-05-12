@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Opći podaci o obrtu</div>

                <div class="card-body">
                    {!! Form::open(array('route' => 'company.store')) !!}

                    {{ Form::label('company_name', 'Naziv obrta:') }}
                    {{ Form::text('company_name', null, array('class'=>'form-control', 'required'=>'')) }}
                    {{ Form::label('owner', 'Vlasnik:') }}
                    {{ Form::text('owner', null, array('class'=>'form-control', 'required'=>'')) }}
                    {{ Form::label('address', 'Adresa:') }}
                    {{ Form::text('address', null, array('class'=>'form-control', 'required'=>'')) }}
                    {{ Form::label('oib', 'OIB:') }}
                    {{ Form::text('oib', null, array('class'=>'form-control', 'maxlength'=>'11', 'required'=>'')) }}
                    {{ Form::label('iban', 'IBAN:') }}
                    {{ Form::text('iban', null, array('class'=>'form-control', 'maxlength'=>'34', 'required'=>'')) }}
                    {{ Form::label('bank_info', 'Banka:') }}
                    {{ Form::text('bank_info', null, array('class'=>'form-control', 'required'=>'')) }}
                    {{ Form::label('activity', 'Djelatnost:') }}
                    {{ Form::text('activity', null, array('class'=>'form-control', 'required'=>'')) }}
                    </br>
                    {{ Form::submit('Spremi', array('class'=>'btn btn-success btn-block')) }}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection