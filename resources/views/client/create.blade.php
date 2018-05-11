@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Novi klijent</div>

                <div class="card-body">
                   {!! Form::open(array('route' => 'client.store')) !!}

                    {{ Form::label('name', 'Naziv klijenta:') }}
                    {{ Form::text('name', null, array('class'=>'form-control', 'required'=>'')) }}
                    {{ Form::label('address', 'Adresa:') }}
                    {{ Form::text('address', null, array('class'=>'form-control', 'required'=>'')) }}
                    {{ Form::label('city', 'Mjesto:') }}
                    {{ Form::text('city', null, array('class'=>'form-control', 'required'=>'')) }}
                    {{ Form::label('oib', 'OIB:') }}
                    {{ Form::text('oib', null, array('class'=>'form-control', 'maxlength'=>'11', 'required'=>'')) }}
                    
                    </br>
                    {{ Form::submit('Spremi', array('class'=>'btn btn-success btn-block')) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection