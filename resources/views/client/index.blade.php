@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Klijenti</div>

                <div class="card-body">

                    @foreach($clients as $client)
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <h5>Naziv klijenta:</h5>
                            <p><strong>{{ $client->name }}</strong></p>
                        </div>
                        <div class="form-group col-md-3">
                            <h5>Adresa:</h5>
                            <p><strong>{{ $client->address }}</strong></p>
                        </div>
                        <div class="form-group col-md-3">
                            <h5>Mjesto:</h5>
                            <p><strong>{{ $client->city }}</strong></p>
                        </div>
                        <div class="form-group col-md-3">
                            <h5>OIB:</h5>
                            <p><strong>{{ $client->oib }}</strong></p>
                        </div>
                            {{ Form::button('Uredi', array('class' => 'btn btn-primary')) }}
                    </div>
                        <hr>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection