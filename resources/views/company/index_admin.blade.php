@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			@foreach($companies as $company)
				<div class="card">
					<div class="card-header">
						Podaci o tvrtki
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-4">
								<h5>Naziv:</h5><p><strong>{{ $company->name }}</strong></p>
								<h5>Vlasnik:</h5><p><strong>{{ $company->owner }}</strong></p>
								<h5>Adresa:</h5><p><strong>{{ $company->address }}</strong></p>
								<h5>Mjesto:</h5><p><strong>{{ $company->zip_code }} {{ $company->city }}</strong></p>
							</div>
							<div class="form-group col-md-4">
								<h5>OIB:</h5><p><strong>{{ $company->oib }}</strong></p>
								<h5>IBAN:</h5><p><strong>{{ $company->iban }}</strong></p>
								<h5>Banka:</h5><p><strong>{{ $company->bank_info }}</strong></p>
								<h5>Djelatnost:</h5><p><strong>{{ $company->activity }}</strong></p>
							</div>
							<div class="form-group col-md-4">
								<img src="{{ asset('storage/'.$company->logo_path) }}" class="img-fluid img-thumbnail" height="200" width="200" alt="Company logo!">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-4 col-md-offset-8">
								<a class="btn btn-info" href="{{ route('company.edit', ['id' => $company->id]) }}">Uredi</a>
							</div>
						</div>
					</div>
				</div>
			@endforeach
        </div>
    </div>
</div>
@endsection