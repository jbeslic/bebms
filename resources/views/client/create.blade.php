@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Novi klijent</div>

                <div class="card-body">
                   {!! Form::open(array('route' => 'client.store')) !!}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('name', 'Naziv klijenta:') }}
                            {{ Form::text('name', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('oib', 'OIB:') }}
                            {{ Form::text('oib', null, array('class'=>'form-control', 'maxlength'=>'11', 'required'=>'')) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('address', 'Adresa:') }}
                            {{ Form::text('address', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('zip_code', 'Poštanski broj:') }}
                            {{ Form::text('zip_code', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('city', 'Mjesto:') }}
                            {{ Form::text('city', null, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                    </div>
                    </br>
                    {{ Form::submit('Spremi', array('class'=>'btn btn-success btn-block')) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection