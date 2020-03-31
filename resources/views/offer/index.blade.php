@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Ponude
                </div>
                <div class="card-body">
                    <a class="btn btn-info" href="{{ route('offer.create') }}">{{ __('Novi') }}</a>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                            <th scope="col">Tvrtka</th>
                            @endif
                            <th scope="col">Klijent</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Iznos</th>
                            <th scope="col" style="text-align:center">Plaćeno</th>
                            <th scope="col" style="text-align:center">PDF</th>
                            <th scope="col" colspan="2" style="text-align:center">Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($offers as $offer)
                        <tr>
                            <th scope="row">{{ $offer->offer_number }}</th>
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                                <td>{{ $offer->company->name }}</td>
                            @endif
                            <td>{{ $offer->client->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($offer->offer_date)->format('d.m.Y') }}</td>
                            <td>{{ number_format($offer->total_price, 2, ',', '.') }}</td>
                            <td align="center">
                                @if($offer->is_paid)
                                    DA
                                @else
                                    NE
                                @endif
                            </td>
                            <td align="center"><a class="btn btn-success" href="{{ route('offer.pdf', [$offer->id]) }}">{{ __('Print') }}</a></td>
                            <td><a class="btn btn-secondary" href="{{ route('offer.edit', [$offer->id]) }}">Uredi</a></td>
                            <td>{!! Form::open(["route"=>["offer.destroy", $offer->id], "method" => "DELETE"]); !!}
                                {!! Form::submit("Obriši ", array("class"=>"btn btn-danger")); !!}
                                {!! Form::close(); !!}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col" colspan="3">Ukupno</th>
                            <th scope="col" colspan="2">{{ number_format($offers->sum('total_price'), 2, ',', '.') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection