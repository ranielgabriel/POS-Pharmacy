@extends('layouts.app')

@section('content')
<div class="col-md-12 responsive">
    <div class="form-group">
    <h1 class="">Products</h1>
    <a class="btn btn-primary" href="/products/create">Add Product</a>

    <div class="form-group col-md-12 py-2">
        {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Brand Name / Generic Name)'])}}
    </div>
    <div class="responsive" id="tableSearchContainer"></div>
    <div class="responsive" id="tableContainer">
        <table class="table table-striped table-bordered table-hover" id="tableProducts">
            <th><label>Generic Name</label></th>
            <th><label>Brand Name</label></th>
            <th><label>Drug Type</label></th>
            <th><label>Quantity</label></th>
            <th><label>Status</label></th>
            <th><label>Purchase Price</label></th>
            <th><label>Special Price</label></th>
            <th><label>Walk-In Price</label></th>
            <th><label>Promo Price</label></th>
            <th><label>Distributor's Price</label></th>

            @foreach ($products->sortBy('genericNames.description') as $product)
                <tr class="">
                    <td>{{ $product->genericNames->description }}</td>
                    <td><a href="/products/{{ $product->id }}" class="">{{ $product->brand_name }}</a></td>
                    <td>{{ $product->drugTypes->description }}</td>
                    <td>
                        {{ $product->inventories->sum('quantity') - $product->inventories->sum('sold') }}
                    </td>
                    <td>{{ $product->status }}</td>
                    <td>&#8369 {{ $product->purchase_price }}</td>
                    <td>&#8369 {{ $product->special_price }}</td>
                    <td>&#8369 {{ $product->walk_in_price }}</td>
                    <td>&#8369 {{ $product->promo_price }}</td>
                    <td>&#8369 {{ $product->distributor_price }}</td>
                    <td>
                        <center>
                            <button class="btn btn-success modalSellClass" data-toggle="modal" data-target="#modalSell" data-product-id={{ $product->id }}>
                                <span class="fa fa-cart-arrow-down"></span>
                            </button>
                        </center>
                    </td>
                </tr>
            @endforeach()
        </table>
    </div>
{{ $products->links() }}
@endsection()

@section('formLogic')
<script>
    $('document').ready(function () {
        console.log('Page is ready');
        $('#tableSearchContainer').hide();

        $('#search').val('');
        $('#search').keyup(function () {
            if ($(this).val() != '') {
                searchProducts($(this).val());
                $('.pagination').hide();
            } else {
                $('#tableContainer').show();
                $('#tableSearchContainer').hide();
                $('.pagination').show();
            }
        });

        $(".modalSellClass").click(function () {
            var productId = $(this).data('product-id');
            searchProductInfo(productId);
        })
        // Function for getting the product information
        function searchProductInfo(productId) {
            $.ajax({
                url: '/searchProductInfo',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: productId
                },
                success: function (msg) {

                    // if the response is not null
                    if (msg['product'] != null) {

                        var quantity = 0;

                        for (var i = 0; i < msg['inventories'].length; i++) {

                            var remainingQuantity = msg['inventories'][i]['quantity'] - msg['inventories'][i]['sold'];

                            if (remainingQuantity > 0) {
                                quantity += remainingQuantity;
                            }
                        }
                        $('#brandName').html(msg['product']['brand_name']);
                        $('#genericName').val(msg['genericNames']['description']);
                        $('#drugType').val(msg['drugTypes']['description']);
                        $('#manufacturerName').val(msg['manufacturers']['name']);
                        $('#quantity').val(quantity);
                        $('#purchasePrice').val(msg['product']['purchase_price']);
                        $('#specialPrice').val(msg['product']['special_price']);
                        $('#walkInPrice').val(msg['product']['walk_in_price']);
                        $('#promoPrice').val(msg['product']['promo_price']);
                        $('#distributorPrice').val(msg['product']['distributor_price']);
                        console.log(msg);
                    }
                }
            });
        }

        function searchProducts(productToSearch) {
            if (productToSearch != null) {
                $.ajax({
                    url: '/searchProducts',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: productToSearch
                    },
                    success: function (msg) {
                        $('#tableContainer').hide();
                        $('#tableSearchContainer').show();
                        $('#tableSearchContainer').html('');
                        $('#tableSearchContainer').append(msg.code);

                        // console.log(msg);
                    }
                });
            }
        }
    });
</script>
@endsection