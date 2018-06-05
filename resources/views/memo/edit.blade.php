@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Novi dopis</div>
                    {!! Form::open(array('url' => $uri, 'method' => 'PUT')) !!}
                    <div class="card-body">
                        <div class="form-row">
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                                <div class="form-group col-md-6">
                                    {{ Form::label('company', 'Tvrtka:') }}
                                    <select name="company" class="form-control">
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"  @if($company->id == $memo->company_id) selected @endif>
                                                {{ $company->name }}, {{ $company->address }}, {{ $company->zip_code }} {{ $company->city }}, OIB: {{ $company->oib }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="form-group col-md-6">
                                {{ Form::label('client', 'Kupac:') }}
                                <select name="client" class="form-control">
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @if($client->id == $memo->client_id) selected @endif>
                                            {{ $client->name }}, {{ $client->address }}, {{ $client->zip_code }} {{ $client->city }}, OIB: {{ $client->oib }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12"> <!-- content -->
                                {{ Form::label('Content', 'Content:') }}
                                {{ Form::textarea('data_content', $memo->content, array('class'=>'form-control')) }}
                            </div>
                        </div>


                        {{ Form::submit('Spremi', array('class'=>'btn btn-success')) }}

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection