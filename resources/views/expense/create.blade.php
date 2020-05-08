@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Novi trošak</div>
                    {!! Form::open(array('route' => 'expense.store')) !!}
                    <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    {{ Form::label('project', 'Projekt:') }}
                                    <select name="project_id" class="form-control">
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }} [{{ $project->company->name }}]</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('associate', 'Suradnik:') }}
                                <select name="associate_id" class="form-control">
                                    @foreach ($associates as $associate)
                                        <option value="{{ $associate->id }}">{{ $associate->name }} [{{ $associate->company->name }}]</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3"> <!-- Date input -->
                                {{ Form::label('expense_date', 'Datum:') }}
                                {{ Form::date('expense_date', $datetime , array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('remark', 'Valuta:') }}
                                <select name="currency" class="form-control">
                                    <option value="HRK">HRK</option>
                                    <option value="EUR">EURO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                {{ Form::label('units', 'JM:') }}
                                <select name="unit_id" class="form-control">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('amount', 'Količina:') }}
                                {{ Form::text('amount', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'amount')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('price', 'Cijena:') }}
                                {{ Form::text('price', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'price')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('discount', 'Popust:') }}
                                {{ Form::text('discount', null, array('class'=>'form-control', 'placeholder' => '0', 'name' => 'discount')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('description', 'Opis:') }}
                                {{ Form::textarea('description', null, array('class'=>'form-control', 'rows' => 2, 'placeholder' => '0', 'name' => 'description')) }}
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