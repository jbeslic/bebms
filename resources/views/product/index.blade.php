@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Proizvodi i usluge</div>
                <div class="card-body">
                    <a class="btn btn-info" href="{{ route('product.create') }}">Novi proizvod/usluga</a>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Šifra</th>
                            <th>Opis</th>
                            <th colspan="2" style="text-align:center">Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->description }}</td>
                            <td><a class="btn btn-secondary" href="{{ route('product.edit', [$product->id]) }}">Uredi</a></td>
                            <td>
                                {!! Form::open(["route"=>["product.destroy", $product->id], "method" => "DELETE"]); !!}
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