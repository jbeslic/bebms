@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Uredi ponudu br.{{$offer->offer_number}}</div>
                {!! Form::open(array('url' => $uri, 'method' => 'PUT')) !!}
                	<div class="card-body">
                        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                {{ Form::label('company', 'Tvrtka:') }}
                                <select name="company" class="form-control">
                                    @foreach ($companies as $company)
                                        @if($company->id == $offer->company_id)
                                            <option value="{{ $company->id }}" selected>
                                        @else
                                            <option value="{{ $company->id }}">
                                        @endif        
                                        {{ $company->name }}, {{ $company->address }}, {{ $company->zip_code }} {{ $company->city }}, OIB: {{ $company->oib }} </option>
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
                                        @if($client->id == $offer->client_id)
                                            <option value="{{ $client->id }}" selected>
                                        @else
                                             <option value="{{ $client->id }}">
                                        @endif       
                                            {{ $client->name }}, {{ $client->address }}, {{ $client->zip_code }} {{ $client->city }}, OIB: {{ $client->oib }}</option>
                                    @endforeach
                                </select>
                            </div>
	                		<div class="form-group col-md-2"> <!-- Date input -->
                                {{ Form::label('offer_date', 'Datum:') }}
                                {{ Form::date('offer_date', $offer->offer_date , array('class'=>'form-control')) }}
						    </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('offer_time', 'Vrijeme:') }}
                                {{ Form::time('offer_time', $offer->offer_time, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('city', 'Mjesto:') }}
                                {{ Form::text('city', $offer->city, array('class'=>'form-control')) }}
                            </div>
	                	</div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                {{ Form::label('remark', 'Napomena:') }}
                                <select name="remark" class="form-control">
                                    @foreach ($remarks as $remark)
                                        @if($remark->id == $offer->remark_id)
                                            <option value="{{ $remark->id }}" selected>
                                        @else
                                            <option value="{{ $remark->id }}">
                                        @endif        
                                            {{ $remark->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-1">
                                {{ Form::label('currency', 'Valuta:') }}
                                <select name="currency" class="form-control">
                                    <option value="HRK">HRK</option>
                                    <option value="EUR" @if($offer->currency == 'EUR') selected @endif>EURO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('hnb_middle_exchange', 'HNB srednji:') }}
                                {{ Form::text('hnb_middle_exchange', $offer->hnb_middle_exchange, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('payment_type', 'Način plaćanja:') }}
                                <select name="payment_type" class="form-control">
                                    @if($offer->payment_type == 'Gotovina')
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
                                {{ Form::date('payment_deadline', $offer->payment_deadline, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        @for($i = 0; $i < 5; $i++)
                        <div class="form-row">
                            <div class="form-group col-md-3">
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
                            <div class="form-group col-md-3">
                                {{ Form::label('amount', 'Količina:') }}
                                @if($i<count($items))
                                    {{ Form::text('amount', $items[$i]->amount, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'amount['.$i.']')) }}
                                @else
                                    {{ Form::text('amount', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'amount['.$i.']')) }}
                                @endif        
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('price', 'Cijena:') }}
                                @if($i<count($items))
                                    {{ Form::text('price', $items[$i]->price, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'price['.$i.']')) }}
                                @else
                                    {{ Form::text('price', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'price['.$i.']')) }}
                                @endif        
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('discount', 'Popust:') }}
                                {{ Form::text('discount', $items[$i]->discount ?? null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'discount['.$i.']')) }}

                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('description', 'Opis:') }}
                                {{ Form::textarea('description', $items[$i]->description ?? null, array('class'=>'form-control', 'rows' => 2, 'placeholder' => '0', 'name' => 'description['.$i.']')) }}
                            </div>
                        </div>
                        @endfor
                        <div class="form-row">
                            <div class="form-group col-md-1">
                                {{ Form::label('is_paid', 'Plaćeno:') }}
                                @if($offer->is_paid)
                                    {{ Form::checkbox('is_paid', 1 , true, array('class'=>'form-control')) }}
                                @else
                                    {{ Form::checkbox('is_paid', 1 , null, array('class'=>'form-control')) }}
                                @endif    
                            </div>
                            <div class="form-group col-md-2">
                                {{ Form::label('paid', 'Datum uplate:') }}
                                {{ Form::date('paid', $offer->paid , array('class'=>'form-control')) }}
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