@extends('layouts.app')
@section('content')
<div class="col-md-12">
    @if($cart->count() <= 0)
        <div class="alert alert-info">
            <strong>Oops!</strong> You don't have anything in your cart. <a href="/products/" class="alert-link">Click here to add something in your cart.</a>.
        </div>
    @else
        <h1>Cart</h1>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th><p class="small text-center">Generic Name</p></th>
                            <th><p class="small text-center">Brand Name</p></th>
                            <th><p class="small text-center">Manufacturer</p></th>
                            <th><p class="small text-center">Drug Type</p></th>
                            <th><p class="small text-center">Price</p></th>
                            <th><p class="small text-center">Expiration Date</p></th>
                            <th><p class="small text-center">Quantity</p></th>
                            <th><p class="small text-center">Action</p></th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($cart as $item)
                        {!!Form::open(['action' => ['CartsController@destroy', $item->id], 'method' => 'POST',])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                            <tr>
                                <td>{{$item->product->genericNames->description}}</td>
                                <td>{{$item->product->brand_name}}</td>
                                <td>{{$item->product->manufacturers->name}}</td>
                                <td>{{$item->product->drugTypes->description}}</td>
                                <td>{{Form::select('prices', [$item->product->purchase_price => 'Purchase: &#8369; ' . $item->product->purchase_price, $item->product->promo_price => 'Promo: &#8369; ' . $item->product->promo_price, $item->product->special_price => 'Special: &#8369; ' . $item->product->special_price, $item->product->walk_in_price => 'Walk-in: &#8369; ' . $item->product->walk_in_price, $item->product->distributor_price => 'Distributor\'s: &#8369; ' . $item->product->distributor_price, ] , null, ['class' => 'form-control', 'placeholder' => 'Pick a price...', 'id' => 'prices'])}}</td>
                                @php
                                    $expirationDatesToDisplay = array();
                                @endphp
                                @foreach ($item->product->inventories->sortBy('expiration_date') as $inventory)
                                    @if($inventory->quantity != $inventory->sold)
                                        <?php $expirationDatesToDisplay[$inventory->expiration_date] = $inventory->expiration_date;?>
                                    @endif
                                @endforeach
                                <td>{{Form::select('expirationDate', $expirationDatesToDisplay , null, ['class' => 'form-control', 'placeholder' => 'Pick an expiration date...', 'id' => 'expirationDate'])}}</td>
                                <td>{{Form::number('quantity', null, ['class' => 'form-control', 'placeholder' => 'Quantity', 'min' => 0, 'step' => 1 ])}}</td>
                                <td>
                                    <center>
                                        {{Form::button('<span class="fa fa-times"></span>', ['type' => 'submit', 'class' => 'btn btn-danger'])}}
                                    </center>
                                </td>
                            </tr>
                            {!!Form::close()!!}
                        @endforeach
                    </tbody>
                </table>

            </div>
        <hr>
        <a class="btn btn-info" href="/products">Back</a>
        <a class="btn btn-primary" href="/products">Checkout</a>
    @endif
</div>
@endsection