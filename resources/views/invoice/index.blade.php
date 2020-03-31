@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Računi
                </div>
                <div class="card-body">
                    <a class="btn btn-info" href="{{ route('invoice.create') }}">{{ __('Novi') }}</a>
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
                        @foreach($invoices as $invoice)
                        <tr>
                            <th scope="row">{{ $invoice->invoice_number }}</th>
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                                <td>{{ $invoice->company->name }}</td>
                            @endif
                            <td>{{ $invoice->client->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d.m.Y') }}</td>
                            <td>{{ number_format($invoice->total_hrk_price, 2, ',', '.') }}</td>
                            <td align="center">
                                @if($invoice->is_paid)
                                    DA
                                @else
                                    NE
                                @endif
                            </td>
                            <td align="center"><a class="btn btn-success" href="{{ route('invoice.pdf', [$invoice->id]) }}">{{ __('Print') }}</a></td>
                            <td><a class="btn btn-secondary" href="{{ route('invoice.edit', [$invoice->id]) }}">Uredi</a></td>
                            <td>{!! Form::open(["route"=>["invoice.destroy", $invoice->id], "method" => "DELETE"]); !!}
                                {!! Form::submit("Obriši ", array("class"=>"btn btn-danger")); !!}
                                {!! Form::close(); !!}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col" colspan="3">Ukupno</th>
                            <th scope="col" colspan="2">{{ number_format($invoices->sum('total_hrk_price'), 2, ',', '.') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection