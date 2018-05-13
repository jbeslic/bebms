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
                            <th scope="col">Client</th>
                            <th scope="col">Date</th>
                            <th scope="col">Price</th>
                            <th scope="col">PDF</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <th scope="row">{{ $invoice->invoice_number }}</th>
                            <td>{{ $invoice->client->name }}</td>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>{{ $invoice->totalPrice() }}</td>
                            <td><a class="btn btn-success" href="{{ route('invoice.pdf', ['id' => $invoice->id]) }}">{{ __('Print') }}</a></td>
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