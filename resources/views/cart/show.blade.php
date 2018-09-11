@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <h3>Cart</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th><label class="small">Generic Name</label></th>
                        <th><label class="small">Brand Name</label></th>
                        <th><label class="small">Manufacturer</label></th>
                        <th><label class="small">Drug Type</label></th>
                        <th><label class="small">Price</label></th>
                        <th><label class="small">Expiration Date</label></th>
                        <th><label class="small">Quantity</label></th>
                        <th><label class="small">Action</label></th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($cart as $item)
                        <tr>
                            <td>{{$item->product->genericNames->description}}</td>
                            <td>{{$item->product->brand_name}}</td>
                            <td>{{$item->product->manufacturers->name}}</td>
                            <td>{{$item->product->drugTypes->description}}</td>
                            <td>{{Form::select('prices', [$item->product->purchase_price => '&#8369; ' . $item->product->purchase_price, $item->product->promo_price => '&#8369; ' . $item->product->promo_price, $item->product->special_price => '&#8369; ' . $item->product->special_price, $item->product->walk_in_price => '&#8369; ' . $item->product->walk_in_price, $item->product->distributor_price => '&#8369; ' . $item->product->distributor_price, ] , null, ['class' => 'form-control', 'placeholder' => 'Pick a price...', 'id' => 'prices'])}}</td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    <hr>
    <a class="btn btn-info" href="/products">Back</a>
</div>
@endsection