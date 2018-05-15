@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Uredi proizvod/uslugu</div>

                <div class="card-body">
                   {!! Form::open(array('url' => $uri, 'method' => 'PUT')) !!}
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            {{ Form::label('code', 'Šifra:') }}
                            {{ Form::text('code', $product->code, array('class'=>'form-control', 'required'=>'')) }}
                        </div>
                        <div class="form-group col-md-9">
                            {{ Form::label('description', 'Opis:') }}
                            {{ Form::text('description', $product->description, array('class'=>'form-control',  'required'=>'')) }}
                        </div>
                    </div>
                    {{ Form::submit('Spremi', array('class'=>'btn btn-success')) }}
                    </br>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection