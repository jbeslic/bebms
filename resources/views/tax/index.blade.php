@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Porez
                </div>
                <div class="card-body">
                    <div><a class="btn btn-primary pull-right" href="{{ route('tax.pdf', [2018]) }}">{{ __('PO-SD 2018') }}</a></div>
                    <a class="btn btn-info" href="{{ route('tax.create') }}">{{ __('Novi') }}</a>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                            <th scope="col">Tvrtka</th>
                            @endif

                            <th scope="col">Datum</th>
                            <th scope="col">Iznos</th>
                            <th scope="col">Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($taxes as $tax)
                        <tr>
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                                <td>{{ $tax->company->name }}</td>
                            @endif
                            <td>{{ \Carbon\Carbon::parse($tax->paid_date)->format('d.m.Y') }}</td>
                            <td>{{ number_format($tax->amount, 2, ',', '.') }}</td>
                            <td>{!! Form::open(["route"=>["tax.destroy", $tax->id], "method" => "DELETE"]); !!}
                                {!! Form::submit("Obriši ", array("class"=>"btn btn-danger")); !!}
                                {!! Form::close(); !!}</td>
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