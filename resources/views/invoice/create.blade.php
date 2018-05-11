@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Novi račun</div>
                	<div class="card-body">
	                	<div class="form-row">
	                		<div class="form-group col-md-8">
	                			{{ Form::label('client', 'Kupac:') }}
	                			<select name="client" class="form-control">
	                				@foreach ($clients as $client)
	                				<option value="{{ $client->id }}">{{ $client->name }}, Adresa: {{ $client->address }}, Mjesto: {{ $client->city }}, OIB: {{ $client->oib }}</option>
	                				@endforeach
	                			</select>
	                		</div>
	                	</div>
	                	<div class="form-row">
	                		<div class="form-group col-md-3"> <!-- Date input -->
						        <label class="control-label" for="invoice_date">Datum izdavanja:</label>
						        <input class="form-control" id="invoice_date" name="invoice_date" placeholder="DD.MM.YYYY" type="text"/>
						    </div>
	                	</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
      var date_input=$('input[name="invoice_date"]'); //our date input has the name "date"
      var container=$('.card-body');
      var options={
        format: 'dd.mm.yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      console.log(container);
      date_input.datepicker(options);
    })
</script>
@endsection