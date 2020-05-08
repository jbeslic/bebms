@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Troškovi
                </div>
                <div class="card-body">
                    <a class="btn btn-info" href="{{ route('expense.create') }}">{{ __('Novi') }}</a>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                            <th scope="col">Tvrtka</th>
                            @endif
                            <th scope="col">Projekt</th>
                            <th scope="col">Suradnik</th>
                            <th scope="col">Opis</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Iznos</th>
                            <th scope="col" colspan="2" style="text-align:center">Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                            <th scope="row">{{ $expense->expense_number }}</th>
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                                <td>{{ $expense->company_name }}</td>
                            @endif
                            <td>{{ $expense->project_name }}</td>
                            <td>{{ $expense->associate_name }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d.m.Y') }}</td>
                            <td>{{ number_format($expense->total_hrk_price, 2, ',', '.') }}</td>
                            <td>{!! Form::open(["route"=>["expense.destroy", $expense->id], "method" => "DELETE"]); !!}
                                {!! Form::submit("Obriši ", array("class"=>"btn btn-danger")); !!}
                                {!! Form::close(); !!}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col" colspan="5">Ukupno</th>
                            <th scope="col" colspan="2">{{ number_format($expenses->sum('total_hrk_price'), 2, ',', '.') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection