@extends('layouts.app')
@section('content')
<div class="col-md-12 responsive">
    {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST']) !!}
    <div class="col-md-12">
        <h3>Product Information</h3>
        <div class="col-md-12 row">
            <div class="form-group  col-md-3">
            {{Form::label('genericName', 'Generic Name')}}
            {{Form::text('genericName', $product->genericNames->description, ['class' => 'form-control', 'placeholder' => 'Generic Name', 'disabled' => true])}}
            </div>
            <div class="form-group col-md-3">
            {{Form::label('brandName', 'Brand Name')}}
            {{Form::text('brandName', $product->brand_name, ['class' => 'form-control', 'placeholder' => 'Brand Name', 'disabled' => true])}}
            </div>
            <div class="form-group  col-md-3">
            {{Form::label('manufacturer', 'Manufacturer')}}
            {{Form::text('manufacturer', $product->manufacturers->name , ['class' => 'form-control', 'placeholder' => 'Manufacturer', 'disabled' => true])}}
            </div>
            <div class="form-group col-md-3">
            {{Form::label('drugType', 'Drug Type')}}
            {{-- {{Form::select('drugType', ['L' => 'Large', 'S' => 'Small'], null, ['class' => 'form-control', 'placeholder' => 'Pick a type...'])}} --}}
            {{Form::text('drugType', $product->drugTypes->description , ['class' => 'form-control', 'placeholder' => 'Drug Type', 'disabled' => true])}}
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
                @foreach ($product->inventories->sortByDesc('expiration_date') as $inventory)
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
                            
                    {{-- <div class="col-md-12 row">
                        <div class="form-group col-md-3">
                            {{Form::label('expirationDate', 'Expiration Date')}}
                            {{Form::date('expirationDate', $inventory->expiration_date, ['class' => 'form-control', 'placeholder' => 'Expiration Date', 'disabled' => true])}}
                        </div>
                        <div class="form-group col-md-2">
                            {{Form::label('quantity', 'Quantity')}}
                            {{Form::number('quantity', $inventory->quantity, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Quantity', 'disabled' => true])}}
                        </div>
                        <div class="form-group col-md-2">
                            {{Form::label('remainingQuantity', 'Remaining Quantity')}}
                            {{Form::number('remainingQuantity', $inventory->quantity - $inventory->sold, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Remaining Quantity', 'disabled' => true])}}
                        </div>
                        <div class="form-group col-md-2">
                            {{Form::label('sold', 'Sold')}}
                            {{Form::number('sold', $inventory->sold, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Sold', 'disabled' => true])}}
                        </div>
                    </div> --}}
                    @endif
                @endforeach
            </tbody>
        </table>
        <hr>
        <h3>Prices</h3>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
            {{Form::label('purchasePrice', 'Purchase Price')}}
            {{Form::number('purchasePrice', $product->purchase_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Market Price' , 'step' => 1, 'disabled' => true])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('specialPrice', 'Special Price')}}
            {{Form::number('specialPrice', $product->special_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Special Price' , 'step' => 1, 'disabled' => true])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('walkInPrice', 'Walk-In Price')}}
            {{Form::number('walkInPrice', $product->walk_in_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Walk-In Price' , 'step' => 1, 'disabled' => true])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('promoPrice', 'Promo Price')}}
            {{Form::number('promoPrice', $product->promo_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Promo Price' , 'step' => 1, 'disabled' => true])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('distributorPrice', 'Distributor\'s Price')}}
            {{Form::number('distributorPrice', $product->distributor_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Distributor\'s Price' , 'step' => 1, 'disabled' => true])}}
            </div>
        </div>

        <hr>
        <a class="btn btn-info" href="/products">Back</a>
    </div>
    {!! Form::close() !!}

</div>
@endsection
