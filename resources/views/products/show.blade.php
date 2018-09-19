@extends('layouts.app')
@section('content')
    <div class="col-md-12 responsive">
        <div class="col-md-12">
            <a class="btn btn-info" href="/products"><span class="fa fa-arrow-left"></span>&nbsp;Back</a>

            @auth
                @if (Auth::user()->role == 'Administrator')
                    <div class="row float-right">
                        <a class="btn btn-info mx-1" href="/products/{{ $product->id }}/edit"><span class="fa fa-edit"></span>&nbsp;Update</a>
                        {!!Form::open(['action' => ['ProductsController@destroy', $product->id], 'method' => 'POST',])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::button('<span class="fa fa-trash"></span>&nbsp;Delete', ['type' => 'submit', 'class' => 'btn btn-danger'])}}
                        {!!Form::close()!!}
                    </div>
                @endif
            @endauth

            <hr>

            <h3 class="text-center">Product Information</h3>
            <div class="col-md-12 row">
                <div class="form-group col-md-6">
                    {{Form::label('genericName', 'Generic Name')}}
                    {{Form::text('genericName', $product->genericNames->description, ['class' => 'form-control', 'placeholder' => 'Generic Name', 'disabled' => true])}}
                </div>
                <div class="form-group col-md-6">
                    {{Form::label('brandName', 'Brand Name')}}
                    {{Form::text('brandName', $product->brand_name, ['class' => 'form-control', 'placeholder' => 'Brand Name', 'disabled' => true])}}
                </div>
            </div>
            <div class="col-md-12 row">
                <div class="form-group  col-md-4">
                    {{Form::label('manufacturer', 'Manufacturer')}}
                    {{Form::text('manufacturer', $product->manufacturers->name , ['class' => 'form-control', 'placeholder' => 'Manufacturer', 'disabled' => true])}}
                </div>
                <div class="form-group col-md-4">
                    {{Form::label('drugType', 'Drug Type')}}
                    {{Form::text('drugType', $product->drugTypes->description , ['class' => 'form-control', 'placeholder' => 'Drug Type', 'disabled' => true])}}
                </div>
                <div class="form-group col-md-4">
                    {{Form::label('status', 'Status')}}
                    {{Form::text('status', $product->status , ['class' => 'form-control', 'placeholder' => 'Status', 'disabled' => true])}}
                </div>
            </div>

            @auth
            <hr>
            <h3 class="text-center">Prices</h3>
            <div class="col-md-12 row">
                <div class="col-md-2">
                    {{Form::label('purchasePrice', 'Purchase Price')}}
                    <div class="input-group mb-3 my-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">&#8369;</span>
                        </div>
                            {{Form::number('purchasePrice', $product->purchase_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Market Price' , 'step' => 1, 'disabled' => true])}}
                    </div>
                </div>
                <div class="col-md-2">
                    {{Form::label('specialPrice', 'Special Price')}}
                    <div class="input-group mb-3 my-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">&#8369;</span>
                        </div>
                    {{Form::number('specialPrice', $product->special_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Special Price' , 'step' => 1, 'disabled' => true])}}
                    </div>
                </div>
                <div class="col-md-2">
                    {{Form::label('walkInPrice', 'Walk-In Price')}}
                    <div class="input-group mb-3 my-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">&#8369;</span>
                        </div>
                    {{Form::number('walkInPrice', $product->walk_in_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Walk-In Price' , 'step' => 1, 'disabled' => true])}}
                    </div>
                </div>
                <div class="col-md-2">
                    {{Form::label('promoPrice', 'Promo Price')}}
                    <div class="input-group mb-3 my-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">&#8369;</span>
                        </div>
                    {{Form::number('promoPrice', $product->promo_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Promo Price' , 'step' => 1, 'disabled' => true])}}
                    </div>
                </div>
                <div class="col-md-2">
                    {{Form::label('distributorPrice', 'Distributor\'s Price')}}
                    <div class="input-group mb-3 my-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">&#8369;</span>
                        </div>
                    {{Form::number('distributorPrice', $product->distributor_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Distributor\'s Price' , 'step' => 1, 'disabled' => true])}}
                    </div>
                </div>
            </div>
            <hr>
            <h3>Inventory Information</h3>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th><center>Expiration Date</center></th>
                        <th><center>Remaining Quantity</center></th>
                    </tr>
                </thead>
                <tbody class="table-sm">
                    @foreach ($product->inventories->sortBy('expiration_date') as $inventory)
                        @if ($inventory->quantity != $inventory->sold)
                                @php
                                    $now = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
                                    // ->modify('+10 months')->format('Y-m-d');
                                @endphp
                                @if($inventory->expiration_date > $now->format('Y-m-d'))
                                    <tr class="table-success">
                                        <td><center>{{$inventory->expiration_date}}</center></td>
                                        <td><center>{{$inventory->quantity - $inventory->sold}}</center></td>
                                    </tr>
                                @else
                                    <tr class="table-danger">
                                        <td><center>{{$inventory->expiration_date}}</center></td>
                                        <td><center>{{$inventory->quantity - $inventory->sold}}</center></td>
                                    </tr>
                                @endif

                        @endif
                    @endforeach
                </tbody>
            </table>
            @endauth
        </div>

    </div>
@endsection
