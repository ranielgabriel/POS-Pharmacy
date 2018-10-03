@extends('layouts.app')
@section('content')
    <div class="col-md-12 responsive">
        <h3 class="text-center">Update Customer Information</h3>
        <hr>
        <div class="col-md-12">
            <div id="productInformationContainer" class="container">
                {!! Form::open(['action' => ['CustomersController@update', $customer->id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
                <h3 class="text-center">Customer Information</h3>
                <div class="col-md-12 row">
                    <div class="form-group col-md-3">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', $customer->name, ['class' => 'form-control', 'placeholder' => 'Name',])}}
                    </div>
                    <div class="form-group col-md-3">
                        {{Form::label('contactNumber', 'Contact Number')}}
                        {{Form::text('contactNumber', $customer->contact_number, ['class' => 'form-control', 'placeholder' => 'Contact Number',])}}
                    </div>
                    <div class="form-group col-md-6">
                        {{Form::label('address', 'Address')}}
                        {{Form::text('address', $customer->address, ['class' => 'form-control', 'placeholder' => 'Address',])}}
                    </div>
                </div>

                <div class="form-group col-md-12">
                    {{Form::label('details', 'Details')}}
                    {{Form::textarea('details', $customer->details, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Details', 'style' => 'resize:none',])}}
                </div>
            </div>
        </div>
        <hr>
        <a class="btn btn-danger" href="/customers/{{$customer->id}}"><span class="fa fa-times"></span>&nbsp;Cancel</a>
        {{Form::hidden('_method', 'PUT')}}
        <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span>&nbsp;Save Changes</button>
    </div>
@endsection