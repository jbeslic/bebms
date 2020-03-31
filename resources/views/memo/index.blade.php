@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Dopisi
                </div>
                <div class="card-body">
                    <a class="btn btn-info" href="{{ route('memo.create') }}">{{ __('Novi') }}</a>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                            <th scope="col">Tvrtka</th>
                            @endif
                            <th scope="col">Klijent</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Print</th>
                            <th scope="col">Akcije</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($memos as $memo)
                        <tr>
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                                <td>{{ $memo->company->name }}</td>
                            @endif
                            <td>{{ $memo->client->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($memo->created_at)->format('d.m.Y') }}</td>
                            <td align="center"><a class="btn btn-success" href="{{ route('memo.pdf', [$memo->id]) }}">{{ __('Print') }}</a></td>
                            <td><a class="btn btn-secondary" href="{{ route('memo.edit', [$memo->id]) }}">Uredi</a></td>
                            <td>{!! Form::open(["route"=>["memo.destroy", $memo->id], "method" => "DELETE"]); !!}
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