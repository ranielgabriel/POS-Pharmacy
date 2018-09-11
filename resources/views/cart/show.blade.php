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
                    <tbody class="" id="tableCart">
                        @foreach ($cart as $item)
                        {!!Form::open(['action' => ['CartsController@destroy', $item->id], 'method' => 'POST',])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                            <tr>
                                <td hidden id="productId{{$loop->iteration}}">{{$item->product_id}}</td>
                                <td>{{$item->product->genericNames->description}}</td>
                                <td>{{$item->product->brand_name}}</td>
                                <td>{{$item->product->manufacturers->name}}</td>
                                <td>{{$item->product->drugTypes->description}}</td>
                                <td>{{Form::select('prices' . $loop->iteration, [$item->product->purchase_price => 'Purchase: &#8369; ' . $item->product->purchase_price, $item->product->promo_price => 'Promo: &#8369; ' . $item->product->promo_price, $item->product->special_price => 'Special: &#8369; ' . $item->product->special_price, $item->product->walk_in_price => 'Walk-in: &#8369; ' . $item->product->walk_in_price, $item->product->distributor_price => 'Distributor\'s: &#8369; ' . $item->product->distributor_price, ] , null, ['class' => 'form-control priceSelect', 'placeholder' => 'Pick a price...', 'id' => 'price' . $loop->iteration])}}</td>
                                @php
                                    $expirationDatesToDisplay = array();
                                @endphp
                                @foreach ($item->product->inventories->sortBy('expiration_date') as $inventory)
                                    @if($inventory->quantity != $inventory->sold)
                                        <?php $expirationDatesToDisplay[$inventory->expiration_date] = $inventory->expiration_date;?>
                                    @endif
                                @endforeach
                                <td>{{Form::select('expirationDate' . $loop->iteration, $expirationDatesToDisplay , null, ['class' => 'form-control expirationSelect', 'placeholder' => 'Pick an expiration date...', 'id' => 'expirationDate' . $loop->iteration])}}</td>
                                <td>{{Form::number('quantity' . $loop->iteration, null, ['class' => 'form-control quantityNumber', 'placeholder' => 'Quantity', 'min' => 0, 'step' => 1 , 'id' => 'quantity' . $loop->iteration])}}</td>
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

@section('formLogic')
<script>
    $('document').ready(function(){
        console.log('Page is ready.');

        $("#tableCart tr .expirationSelect").on({
            change:  function(){
                        // alert(this.rowIndex);
                        var row = this.parentNode.parentNode;
                        var rowIndex = this.parentNode.parentNode.rowIndex;
                        // console.log($("#productId"+rowIndex).html());
                        // console.log($("#expirationDate"+rowIndex).val());
                        searchProductQuantityInfo($("#productId"+rowIndex).html(), $("#expirationDate"+rowIndex).val(), rowIndex);
                    }
        });

        $(".quantityNumber").keyup(function(){
            if($(this).val() > $(this).attr('max')){
                $(this).val($(this).attr('max'));
            }
        });

        function searchProductQuantityInfo(productId, expirationDate, rowIndex) {
            $.ajax({
                url: '/searchProductQuantityInfo',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: productId,
                    expirationDate: expirationDate
                },
                success: function (msg) {

                    // if the response is not null
                    if (msg['inventories'] != null) {
                        console.log(msg);
                        $("#quantity"+rowIndex).val(msg['inventories']['quantity'] - msg['inventories']['sold']);
                        $("#quantity"+rowIndex).attr({
                            "max" : (msg['inventories']['quantity'] - msg['inventories']['sold']),
                            "min" : 0
                        });
                    }
                }
            });
        }
    });
</script>
@endsection