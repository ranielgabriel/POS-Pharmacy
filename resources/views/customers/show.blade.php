@extends('layouts.app')
@section('content')
<div class="col-md-12 responsive">
    <div class="col-md-12">
        <a class="btn btn-info" href="/customers"><span class="fa fa-arrow-left"></span>&nbsp;Back</a>

        @auth
            @if (Auth::user()->role == 'Administrator')
                <div class="row float-right">
                    <a class="btn btn-info mx-1" href="/customers/{{ $customer->id }}/edit"><span class="fa fa-edit"></span>&nbsp;Update</a>
                    {!!Form::open(['action' => ['CustomersController@destroy', $customer->id], 'method' => 'POST',])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::button('<span class="fa fa-trash"></span>&nbsp;Delete', ['type' => 'submit', 'class' => 'btn btn-danger'])}}
                    {!!Form::close()!!}
                </div>
            @endif
        @endauth

        <hr>
        <div id="productInformationContainer" class="container">

            <h3 class="text-center">Customer Information</h3>
            <div class="col-md-12 row">
                <div class="form-group col-md-3">
                    {{Form::label('name', 'Name')}}
                    {{Form::text('name', $customer->name, ['class' => 'form-control', 'placeholder' => 'Name', 'readonly'])}}
                </div>
                <div class="form-group col-md-3">
                    {{Form::label('contactNumber', 'Contact Number')}}
                    {{Form::text('contactNumber', $customer->contact_number, ['class' => 'form-control', 'placeholder' => 'Contact Number', 'readonly'])}}
                </div>
                <div class="form-group col-md-6">
                    {{Form::label('address', 'Address')}}
                    {{Form::text('address', $customer->address, ['class' => 'form-control', 'placeholder' => 'Address', 'readonly'])}}
                </div>
            </div>

            <div class="form-group col-md-12">
                {{Form::label('details', 'Details')}}
                {{Form::textarea('details', $customer->details, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Details', 'style' => 'resize:none', 'readonly'])}}
            </div>
        </div>
    </div>

</div>
@endsection