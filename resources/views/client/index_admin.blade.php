@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Klijenti</div>
                <div class="card-body">
                    <a class="btn btn-info" href="{{ route('client.create') }}">Novi klijent</a>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Klijent pripada:</th>
                            <th>Naziv</th>
                            <th>Adresa</th>
                            <th>Poštanski broj</th>
                            <th>Mjesto</th>
                            <th>OIB</th>
                            <th colspan="2" style="text-align:center">Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td>{{ substr($client->company_name, 0, 12).'...' }}
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->address }}</td>
                            <td>{{ $client->zip_code }}</td>
                            <td>{{ $client->city }}</td>
                            <td>{{ $client->oib }}</td>
                            <td><a class="btn btn-secondary" href="{{ route('client.edit', ['id' => $client->id]) }}">Uredi</a></td>
                            <td>
                                {!! Form::open(["route"=>["client.destroy", $client->id], "method" => "DELETE"]); !!}
                                {!! Form::submit("Obriši ", array("class"=>"btn btn-warning")); !!}
                                {!! Form::close(); !!}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection