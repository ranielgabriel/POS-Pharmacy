@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <hr>
        {!! Form::open(['action' => 'SuppliersController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
        <div class="col-md-12">
            <h3>Supplier Information</h3>
                <div class="col-md-12">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {{Form::label('supplierName', 'Supplier Name')}}
                            {{Form::text('supplierName', '', ['class' => 'form-control', 'placeholder' => 'Supplier Name', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('address', 'Address')}}
                            {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address', 'required'])}}
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('ltoNumber', 'LTO Number')}}
                            {{Form::number('ltoNumber', '' , ['class' => 'form-control', 'placeholder' => 'LTO Number', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('expirationDate', 'Expiration Date')}}
                            {{Form::date('expirationDate', '' , ['class' => 'form-control', 'placeholder' => 'Expiration Date', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('contactPerson', 'Contact Person')}}
                            {{Form::text('contactPerson', '' , ['class' => 'form-control', 'placeholder' => 'Contact Person', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('contactNumber', 'Contact Number')}}
                            {{Form::text('contactNumber', '' , ['class' => 'form-control', 'placeholder' => 'Contact Number', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('emailAddress', 'Email Address')}}
                            {{Form::text('emailAddress', '' , ['class' => 'form-control', 'placeholder' => 'Email Address', 'required'])}}
                        </div>
                    </div>
                </div>
            <hr>
            <a class="btn btn-info" href="/suppliers">Cancel</a>
            {{ Form::submit('Add Supplier', ['class' => 'btn btn-primary'])}}
        </div>

    </div>
@endsection