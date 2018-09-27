@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        @if($cart->count() <= 0)
            <div class="alert alert-info">
                <strong>Oops!</strong> You don't have anything in your cart. <a href="/products/" class="alert-link">Click here to add something in your cart.</a>.
            </div>
        @else
            <h1 class="text-center"><span class="fa fa-shopping-cart">&nbsp;</span>Cart</h1>
                <div class="table-responsive rounded">
                    <table class="table table-striped table-hover" id="myTable">
                        <thead class="thead-dark text-center small">
                            <tr class="align-middle">
                                <th></th>
                                <th>Generic Name</th>
                                <th>Brand Name</th>
                                <th>Manufacturer</th>
                                <th>Drug Type</th>
                                <th>Expiration Date</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Sub-Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-sm" id="tableCart">
                            @foreach ($cart->sortBy('product.brand_name')->sortBy('product.genericNames.description') as $item)
                            {!!Form::open(['action' => ['CartsController@destroy', $item->id], 'method' => 'POST',])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                                <tr class="text-center">
                                    <td class="align-middle" hidden id="productId{{$loop->iteration}}">{{$item->product_id}}</td>
                                    <td class="align-middle" hidden id="inventoryId{{$loop->iteration}}"></td>
                                    <td class="align-middle" hidden id="cartId{{$loop->iteration}}">{{$item->id}}</td>
                                    <td class="align-middle"><a data-product-id="{{$item->product_id}}" class="btn btn-primary addProductToCart" href="#" role="button"><span class="fa fa-plus-circle"></span></a></td>
                                    {{-- <td class="align-middle">{{ link_to_action('CartsController@store', $title = 'Add', $parameters = ['productId' => $item->product_id, 'userId' => Auth::user()->id], $attributes = ['class' => 'btn btn-primary']) }}</td> --}}
                                    <td class="align-middle"><small id="genericName{{$loop->iteration}}">{{$item->product->genericNames->description}}</small></td>
                                    <td class="align-middle"><small id="brandName{{$loop->iteration}}" class="text-center">{{$item->product->brand_name}}</small></td>
                                    <td class="align-middle"><small id="manufacturer{{$loop->iteration}}" class="text-center">{{$item->product->manufacturers->name}}</small></td>
                                    <td class="align-middle"><small id="drugType{{$loop->iteration}}" class="text-center">{{$item->product->drugTypes->description}}</small></td>
                                    @php
                                        $expirationDatesToDisplay = array();
                                    @endphp
                                    @foreach ($item->product->inventories->sortBy('expiration_date') as $inventory)
                                        @if($inventory->quantity > $inventory->sold)
                                            <?php $expirationDatesToDisplay[$inventory->expiration_date] = $inventory->expiration_date;?>
                                        @endif
                                    @endforeach
                                    <td class="align-middle">{{Form::select('expirationDate' . $loop->iteration, $expirationDatesToDisplay , null, ['class' => 'form-control expirationSelect', 'placeholder' => 'Pick an expiration date...', 'id' => 'expirationDate' . $loop->iteration])}}</td>
                                    <td class="align-middle">{{Form::number('quantity' . $loop->iteration, null, ['class' => 'form-control quantityNumber', 'placeholder' => 'Quantity', 'min' => 0, 'step' => 1 , 'disabled', 'data-loop-iteration' => $loop->iteration , 'id' => 'quantity' . $loop->iteration])}}</td>
                                    <td class="align-middle">{{Form::select('prices' . $loop->iteration, [$item->product->purchase_price => 'Purchase: &#8369; ' . $item->product->purchase_price, $item->product->promo_price => 'Promo: &#8369; ' . $item->product->promo_price, $item->product->special_price => 'Special: &#8369; ' . $item->product->special_price, $item->product->walk_in_price => 'Walk-in: &#8369; ' . $item->product->walk_in_price, $item->product->distributor_price => 'Distributor\'s: &#8369; ' . $item->product->distributor_price, ] , null, ['class' => 'form-control priceSelect', 'placeholder' => 'Pick a price...', 'data-loop-iteration' => $loop->iteration, 'id' => 'price' . $loop->iteration])}}</td>
                                    <td class="align-middle" id="subTotal{{$loop->iteration}}">&#8369; 0.00</td>
                                    <td class="align-middle">
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
            <div class="row col-md-12 form-inline">
                {{Form::label('customerName', 'Sold to:', ['class' => 'col-md-1'])}}
                {{Form::text('customerName', '', ['class' => 'form-control col-md-11', 'placeholder' => 'Name of Customer', 'id' => 'customerName'])}}
            </div>
            <hr>
            <a class="btn btn-info" href="/products"><span class="fa fa-arrow-left"></span>&nbsp;Back</a>
            <button id="btnCheckout" class="btn btn-primary" data-toggle="modal" data-target="#modalCart">Checkout</button>
        @endif
    </div>

    <div id="modalCart" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Selling to: <strong id="nameOfCustomer">Sample Name</strong>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive rounded">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead-dark table-sm">
                                <tr class="text-center small">
                                    <th>Generic Name</th>
                                    <th>Brand Name</th>
                                    {{-- <th><p class="small text-center">Manufacturer</p></th> --}}
                                    <th>Drug Type</th>
                                    <th>Expiration Date</th>
                                    {{-- <th><p class="small text-center">Quantity</p></th> --}}
                                    <th>Quantity x Price</th>
                                    <th>Sub-Total</th>
                                </tr>
                            </thead>
                            <tbody id="modalCartTBody" class="table-sm text-center">
                            </tbody>
                            <tfoot class="thead-dark table-sm small">
                                <tr class="">
                                    <th class="align-middle" colspan="5">Total Amount</th>
                                    <th class="align-middle text-center" colspan="1"><strong class="text-center" id="totalAmount">0.00</strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success col-md-12" href="#" role="button" id="btnConfirm"><strong>Confirm</strong>&nbsp;<span class="fa fa-check"></span></a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('formLogic')
    <script>
        var tableRowCount;
        var inventoryList = {};

        $('document').ready(function(){

            console.log('Page is ready.');

            tableRowCount = $('#tableCart tr').length;

            $("#tableCart tr .expirationSelect").on({
                change:  function(){
                            // alert(this.rowIndex);
                            var row = this.parentNode.parentNode;
                            var rowIndex = this.parentNode.parentNode.rowIndex;
                            // console.log($("#expirationDate"+rowIndex).val());

                            if($(this).val() == ""){
                                console.log($(this).val());
                                $("#quantity"+rowIndex).attr({
                                    "max" : 0,
                                    "min" : 0,
                                    "disabled" : true
                                });

                                $("#quantity"+rowIndex).val('');
                            }

                            searchProductQuantityInfo($("#productId"+rowIndex).html(), $("#expirationDate"+rowIndex).val(), rowIndex);
                        }
            });

            $(".quantityNumber").keyup(function(){
                computeSubTotal($(this).data('loop-iteration'));
                if(parseInt($(this).val()) > parseInt($(this).attr('max'))){
                    $(this).val($(this).attr('max'));
                    return;
                }
            });

            $(".priceSelect").change(function(){
                computeSubTotal($(this).data('loop-iteration'));
            });

            $("#btnCheckout").click(function(){
                console.log('Checkout is clicked.');
                
                if(checkAllFields()){
                    alert('Please select an expiration date, quantity, price of item(s), and write the name of the customer.');
                    return false;
                }

                // console.log(checkAllFields());
                $('#modalCartTBody').html('');
                $('#nameOfCustomer').html($('#customerName').val());
                // console.log(tableRowCount);
                var code = '';
                var totalAmount=0;
                for(var i = 1; i <= tableRowCount; i++){
                    inventory = {
                        productId : parseInt($('#productId'+i).html()),
                        cartId : parseInt($('#cartId'+i).html()),
                        inventoryId : parseInt($('#inventoryId'+i).html()),
                        inventorySold : parseInt($('#quantity'+i).val()),
                        priceSold : parseFloat($('#price'+i).val()),
                        subTotal : parseFloat($('#quantity'+i).val() * $('#price'+i).val())
                    };

                    subTotal = $('#quantity'+i).val() * $('#price'+i).val();

                    totalAmount += parseFloat(subTotal.toFixed(2));

                    // console.log($('#inventoryId'+i).html());
                    code += "<tr class='align-middle small'>" +
                    "<td class='align-middle'>" + $('#genericName'+i).html() + "</td>" +
                    "<td class='align-middle'>" + $('#brandName'+i).html() + "</td>" +
                    // "<td>" + $('#manufacturer'+i).html() + "</td>" +
                    "<td class='align-middle'>" + $('#drugType'+i).html() + "</td>" +
                    "<td class='align-middle'>" + $('#expirationDate'+i).val() + "</td>" +
                    // "<td>" + $('#quantity'+i).val() + "</td>" +
                    "<td class='align-middle'>" + $('#quantity'+i).val()  + " x &#8369; " + Number($('#price'+i).val()).toLocaleString('en') + "</td>" +
                    "<td class='align-middle'>&#8369; " + Number(subTotal.toFixed(2)).toLocaleString('en') + "</td>" +
                    "</tr>";
                    
                    inventoryList[i] = inventory;
                }
                // console.log(totalAmount);
                $('#modalCartTBody').append(code);
                $('#totalAmount').html("&#8369; " + Number(totalAmount.toFixed(2)).toLocaleString('en'));
                // inventoryList["totalAmount"] = parseFloat(totalAmount.toFixed(2));
                console.log(inventoryList);
            });

            $("#btnConfirm").click(function(){
                insertSale(inventoryList);
            });

            $('.addProductToCart').click(function (){
                addProductToCart($(this).data('product-id'));
            });
        });

        function computeSubTotal(loopIteration){
            var subTotal = $('#quantity'+loopIteration).val() * $('#price'+loopIteration).val();
            $('#subTotal'+loopIteration).html('&#8369; ' + Number(subTotal.toFixed(2)).toLocaleString('en'));
        }

        function checkAllFields(){

            if($('#customerName').val() == ''){
                return true;
            }

            for(var i = 1; i <= tableRowCount; i++){
                if($('#expirationDate'+i).val() == ''){
                    return true;
                }else if($('#quantity'+i).val() == ''){
                    return true;
                }else if($('#price'+i).val() == ''){
                    return true;
                }
                console.log(i + '. Expiration Date:' + $('#expirationDate'+i).val() + ' Quantity: ' + $('#quantity'+i).val() + ' Price: ' + $('#price'+i).val());
            }
            return false;
        }

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

                        $("#quantity"+rowIndex).val(msg['inventories']['quantity'] - msg['inventories']['sold']);
                        $("#quantity"+rowIndex).attr({
                            "max" : (msg['inventories']['quantity'] - msg['inventories']['sold']),
                            "min" : 0,
                            "disabled" : false
                        });

                        $("#inventoryId"+rowIndex).html(msg['inventories']['id']);
                    }
                }
            });
        }

        function insertSale(inventoryList){
            $.ajax({
                url: '/insertSale',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    inventoryList: inventoryList,
                    customerName: $('#customerName').val()
                },
                success: function (msg) {
                    // if the response is not null
                    // console.log(msg);
                    alert(msg['message']);
                    window.location.href = "/products";
                }
            });
        }

        function addProductToCart(productId){
            $.ajax({
                url: '/cart',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: productId,
                    userId: {{ Auth::user()->id }}
                },
                success: function (msg) {
                    location.reload();
                }
            });
        }
        
    </script>
@endsection