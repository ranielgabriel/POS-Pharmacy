@extends('layouts.app')
@section('content')

<div class="container container-fluid">
    <h1>Add a Product</h1>
    <hr>
    {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST']) !!}
    <div class="col-md-12">
        <h3>Product Information</h3>
        <div class="col-md-12 row">
            <div class="form-group col-md-3">
            {{Form::label('brandName', 'Brand Name')}}
            {{Form::text('brandName', '', ['class' => 'form-control', 'placeholder' => 'Brand Name'])}}
            </div>
            <div class="form-group  col-md-3">
            {{Form::label('genericName', 'Generic Name')}}
            {{Form::text('genericName', '', ['class' => 'form-control', 'placeholder' => 'Generic Name'])}}
            </div>
            <div class="form-group  col-md-3">
            {{Form::label('manufacturer', 'Manufacturer')}}
            {{Form::text('manufacturer', '', ['class' => 'form-control', 'placeholder' => 'Manufacturer'])}}
            </div>
            <div class="form-group col-md-3">
            {{Form::label('drugType', 'Drug Type')}}
            {{Form::text('drugType', '', ['class' => 'form-control', 'placeholder' => 'Drug Type'])}}
            </div>
        </div>

        <hr>
        <h3>Inventory Information</h3>
        <div class="col-md-12 row">
            <div class="form-group  col-md-5">
            {{Form::label('nameOfSupplier', 'Name of Supplier')}}
            {{Form::text('nameOfSupplier', '', ['class' => 'form-control', 'placeholder' => 'Name of Supplier'])}}
            </div>
            <div class="form-group col-md-3">
            {{Form::label('expirationDate', 'Expiration Date')}}
            {{Form::date('expirationDate', '', ['class' => 'form-control', 'placeholder' => 'Expiration Date'])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('quantity', 'Quantity')}}
            {{Form::number('quantity', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Quantity'])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('batchNumber', 'Batch Number')}}
            {{Form::number('batchNumber', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Batch Number' , 'step' => 'any'])}}
            </div>
        </div>

        <hr>
        <h3>Prices</h3>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
            {{Form::label('marketPrice', 'Market Price')}}
            {{Form::number('marketPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Market Price' , 'step' => 'any'])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('specialPrice', 'Special Price')}}
            {{Form::number('specialPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Special Price' , 'step' => 'any'])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('walkInPrice', 'Walk-In Price')}}
            {{Form::number('walkInPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Walk-In Price' , 'step' => 'any'])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('promoPrice', 'Promo Price')}}
            {{Form::number('promoPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Promo Price' , 'step' => 'any'])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('distributorPrice', 'Distributor\'s Price')}}
            {{Form::number('distributorPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Distributor\'s Price' , 'step' => 'any'])}}
            </div>
        </div>

        <hr>
        <a class="btn btn-danger" href="/products">Cancel</a>
        {{ Form::submit('Add Product', ['class' => 'btn btn-primary'])}}
    </div>
    {!! Form::close() !!}

</div>

@endsection()