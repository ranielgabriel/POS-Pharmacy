@extends('layouts.app')
@section('content')
<div class="container container-fluid">
    <h1>Add a Customer</h1>
    <hr>
    {!! Form::open(['action' => 'CustomersController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    <div class="col-md-12">
        <div id="productInformationContainer" class="container">

            <h3>Customer Information</h3>
            <div class="col-md-12 row">
                <div class="form-group col-md-3">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name',])}}
                </div>
                <div class="form-group col-md-3">
                {{Form::label('contactNumber', 'Contact Number')}}
                {{Form::text('contactNumber', '', ['class' => 'form-control', 'placeholder' => 'Contact Number',])}}
                </div>
                <div class="form-group col-md-6">
                {{Form::label('address', 'Address')}}
                {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address',])}}
                </div>
            </div>

            <div class="form-group col-md-12">
                {{Form::label('details', 'Details')}}
                {{Form::textarea('details', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Details',])}}
            </div>
        </div>

        <hr>
        <a class="btn btn-info" href="/customers">Cancel</a>
        {{ Form::submit('Add Customer', ['class' => 'btn btn-primary'])}}
    </div>
    {!! Form::close() !!}

</div>
@endsection