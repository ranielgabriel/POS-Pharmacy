@extends('layouts.app')
@section('content')

<div class="container">
    <h1>Add a product</h1>
    {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST']) !!}
    <div class="form-group">
        {{Form::label('brandName', 'Brand Name')}}
        {{Form::text('brandName', '', ['class' => 'form-control', 'placeholder' => 'Brand Name'])}}

        {{Form::label('marketedBy', 'Marketed By')}}
        {{Form::text('marketedBy', '', ['class' => 'form-control', 'placeholder' => 'Marketed By'])}}

        {{Form::label('quantity', 'Quantity')}}
        {{Form::number('quantity', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Quantity'])}}

        {{Form::label('retailPrice', 'Retail Price')}}
        {{Form::number('retailPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Retail Price' , 'step' => 'any'])}}

        {{Form::label('wholesalePrice', 'Wholesale Price')}}
        {{Form::number('wholesalePrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Wholesale Price' , 'step' => 'any'])}}
        <hr>
        <a class="btn btn-danger" href="/products">Cancel</a>
        {{Form::submit('Add Product', ['class' => 'btn btn-primary'])}}
    </div>
    {!! Form::close() !!}

</div>

@endsection()