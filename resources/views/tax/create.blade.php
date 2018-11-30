@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Novi porez</div>
                {!! Form::open(array('route' => 'tax.store')) !!}
                	<div class="card-body">
                        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                {{ Form::label('company', 'Tvrtka:') }}
                                <select name="company" class="form-control">
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}, {{ $company->address }}, {{ $company->zip_code }} {{ $company->city }}, OIB: {{ $company->oib }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-row">
	                		<div class="form-group col-md-2"> <!-- Date input -->
                                {{ Form::label('paid_date', 'Datum:') }}
                                {{ Form::date('paid_date', null , array('class'=>'form-control')) }}
						    </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('amount', 'Iznos:') }}
                                {{ Form::text('amount', null, array('class'=>'form-control')) }}
                            </div>
	                	</div>

                        {{ Form::submit('Spremi', array('class'=>'btn btn-success')) }}

                    </div>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection