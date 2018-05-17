@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Uredi račun br.{{$invoice->invoice_number}}</div>
                {!! Form::open(array('url' => $uri, 'method' => 'PUT')) !!}
                	<div class="card-body">
	                	<div class="form-row">
	                		<div class="form-group col-md-6">
	                			{{ Form::label('client', 'Kupac:') }}
                                <select name="client" class="form-control">
                                    @foreach ($clients as $client)
                                        @if($client->id == $invoice->client_id)
                                            <option value="{{ $client->id }}" selected>
                                        @else
                                             <option value="{{ $client->id }}">
                                        @endif       
                                            {{ $client->name }}, {{ $client->address }}, {{ $client->zip_code }} {{ $client->city }}, OIB: {{ $client->oib }}</option>
                                    @endforeach
                                </select>
                            </div>
	                		<div class="form-group col-md-2"> <!-- Date input -->
                                {{ Form::label('invoice_date', 'Datum:') }}
                                {{ Form::date('invoice_date', $invoice->invoice_date , array('class'=>'form-control')) }}
						    </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('invoice_time', 'Vrijeme:') }}
                                {{ Form::time('invoice_time', $invoice->invoice_time, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('city', 'Mjesto:') }}
                                {{ Form::text('city', $invoice->city, array('class'=>'form-control')) }}
                            </div>
	                	</div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('remark', 'Napomena:') }}
                                <select name="remark" class="form-control">
                                    @foreach ($remarks as $remark)
                                        @if($remark->id == $invoice->remark_id)
                                            <option value="{{ $remark->id }}" selected>
                                        @else
                                            <option value="{{ $remark->id }}">
                                        @endif        
                                            {{ $remark->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('payment_type', 'Način plaćanja:') }}
                                <select name="payment_type" class="form-control">
                                    @if($invoice->payment_type == 'Gotovina')
                                        <option value="Transakcijski račun">Transakcijski račun</option>
                                        <option value="Gotovina" selected>Gotovina</option>
                                    @else
                                        <option value="Transakcijski račun" selected>Transakcijski račun</option>
                                        <option value="Gotovina">Gotovina</option>
                                    @endif    
                                </select>
                            </div>
                            <div class="form-group col-md-3"> <!-- Date input -->
                                {{ Form::label('payment_deadline', 'Dospijeće plaćanja:') }}
                                {{ Form::date('payment_deadline', $invoice->payment_deadline, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        @for($i = 0; $i < 5; $i++)
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('products', 'Stavke:') }}
                                <select name="product[{{$i}}]" class="form-control">
                                    <option value="0">Izaberi...</option>
                                    @foreach ($products as $product)
                                        @if($i<count($items))
                                            @if($items[$i]->product_id==$product->id)
                                                <option value="{{ $product->code }}" selected>{{ $product->description }}</option>
                                            @else
                                                <option value="{{ $product->code }}">{{ $product->description }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $product->code }}">{{ $product->description }}</option>
                                        @endif     
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('units', 'JM:') }}
                                <select name="unit[{{$i}}]" class="form-control">
                                    @foreach ($units as $unit)
                                        @if($i<count($items))
                                            @if($items[$i]->unit_id==$unit->id)
                                                <option value="{{ $unit->id }}" selected>{{ $unit->name }}</option>
                                            @else
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endif     
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('amount', 'Količina:') }}
                                @if($i<count($items))
                                    {{ Form::text('amount', $items[$i]->amount, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'amount['.$i.']')) }}
                                @else
                                    {{ Form::text('amount', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'amount['.$i.']')) }}
                                @endif        
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('price', 'Cijena:') }}
                                @if($i<count($items))
                                    {{ Form::text('price', $items[$i]->price, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'price['.$i.']')) }}
                                @else
                                    {{ Form::text('price', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'price['.$i.']')) }}
                                @endif        
                            </div>
                        </div>
                        @endfor
                        <div class="form-row">
                            <div class="form-group col-md-1">
                                {{ Form::label('is_paid', 'Plaćeno:') }}
                                @if($invoice->is_paid)
                                    {{ Form::checkbox('paid', 1 , true, array('class'=>'form-control')) }}
                                @else
                                    {{ Form::checkbox('paid', 1 , null, array('class'=>'form-control')) }}
                                @endif    
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('paid', 'Datum uplate:') }}
                                {{ Form::date('paid', $invoice->paid , array('class'=>'form-control')) }}
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