@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Novi račun</div>
                {!! Form::open(array('route' => 'invoice.store')) !!}
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
	                		<div class="form-group col-md-6">
	                			{{ Form::label('client', 'Kupac:') }}
                                <select name="client" class="form-control">
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}, {{ $client->address }}, {{ $client->zip_code }} {{ $client->city }}, OIB: {{ $client->oib }}</option>
                                    @endforeach
                                </select>
                            </div>
	                		<div class="form-group col-md-2"> <!-- Date input -->
                                {{ Form::label('invoice_date', 'Datum:') }}
                                {{ Form::date('invoice_date', $datetime , array('class'=>'form-control')) }}
						    </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('invoice_time', 'Vrijeme:') }}
                                {{ Form::time('invoice_time', $datetime, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('city', 'Mjesto:') }}
                                {{ Form::text('city', $city[0], array('class'=>'form-control')) }}
                            </div>
	                	</div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('remark', 'Napomena:') }}
                                <select name="remark" class="form-control">
                                    @foreach ($remarks as $remark)
                                        <option value="{{ $remark->id }}">{{ $remark->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('payment_type', 'Način plaćanja:') }}
                                <select name="payment_type" class="form-control">
                                    <option value="Transakcijski račun">Transakcijski račun</option>
                                    <option value="Gotovina">Gotovina</option>   
                                </select>
                            </div>
                            <div class="form-group col-md-3"> <!-- Date input -->
                                {{ Form::label('payment_deadline', 'Dospijeće plaćanja:') }}
                                {{ Form::date('payment_deadline', $payment_deadline, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        @for($i = 0; $i < 5; $i++)
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                {{ Form::label('products', 'Stavke:') }}
                                <select name="product[{{$i}}]" class="form-control">
                                    <option value="0" selected>Izaberi...</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->code }}">{{ $product->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('units', 'JM:') }}
                                <select name="unit[{{$i}}]" class="form-control">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('amount', 'Količina:') }}
                                {{ Form::text('amount', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'amount['.$i.']')) }}
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('price', 'Cijena:') }}
                                {{ Form::text('price', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'price['.$i.']')) }}
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('discount', 'Popust:') }}
                                {{ Form::text('discount', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'discount['.$i.']')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('description', 'Opis:') }}
                                {{ Form::textarea('description', null, array('class'=>'form-control', 'rows' => 2, 'placeholder' => '0', 'name' => 'description['.$i.']')) }}
                            </div>
                        </div>
                        @endfor


                        {{ Form::submit('Spremi', array('class'=>'btn btn-success')) }}

                    </div>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection