@extends('layouts.app')

@section('content')
<div class="col-md-12 responsive">
    <div class="form-group">
        <h1 class="">Products</h1>

        @guest

        @else
            @if($user->role == 'Administrator')
                <a class="btn btn-primary" href="/products/create">Add Product</a>
            @endif
        @endguest

        <div class="form-group col-md-12 py-2">
            {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Generic Name / Brand Name / Drug Type / Status)'])}}
        </div>
        <div class="responsive" id="tableSearchContainer"></div>
        <div class="table-responsive" id="tableContainer">
            <table class="table table-striped  table-hover nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th><p class="small text-center">Generic Name</p></th>
                        <th><p class="small text-center">Brand Name</p></th>
                        <th><p class="small text-center">Drug Type</p></th>
                        <th><p class="small text-center">Stocks</p></th>
                        <th><p class="small text-center">Status</p></th>
                        @guest
                            <th><p class="small text-center">Price</p></th>
                        @endguest

                        @auth
                            <th><p class="small text-center">Purchase Price</p></th>
                            <th><p class="small text-center">Special Price</p></th>
                            <th><p class="small text-center">Walk-In Price</p></th>
                            <th><p class="small text-center">Promo Price</p></th>
                            <th><p class="small text-center">Distributor's Price</></th>
                            <th><p class="small text-center">Action</></th>
                        @endauth
                    </tr>
                </thead>
                <tbody id="tableProducts" class="table-sm">
                    @foreach ($products->sortBy('genericNames.description') as $product)
                        <tr class="">
                            <td>{{ $product->genericNames->description }}</td>
                            <td><a class="" href="/products/{{$product->id}}"><strong><p class="text-center">{{ $product->brand_name }}</p></strong></a></td>
                            <td><p class="text-center">{{ $product->drugTypes->description }}</p></td>
                            <td><p class="text-center">{{ $product->inventories->sum('quantity') - $product->inventories->sum('sold') }}</p></td>

                            @if($product->status == 'In-stock')
                                <td><p class="text-warning text-center">{{ $product->status }}</p></td>
                            @elseif($product->status == 'Selling')
                                <td><p class="text-success text-center">{{ $product->status }}</p></td>
                            @elseif($product->status == 'Out-of-stock')
                                <td><p class="text-danger text-center">{{ $product->status }}</p></td>
                            @endif

                            @guest
                                <td><p class="text-center">&#8369 {{ $product->walk_in_price }}</p></td>
                            @endguest

                            @auth
                                <td><p class="text-center">&#8369 {{ $product->purchase_price }}</p></td>
                                <td><p class="text-center">&#8369 {{ $product->special_price }}</p></td>
                                <td><p class="text-center">&#8369 {{ $product->walk_in_price }}</p></td>
                                <td><p class="text-center">&#8369 {{ $product->promo_price }}</p></td>
                                <td><p class="text-center">&#8369 {{ $product->distributor_price }}</p></td>

                                @if($product->status == 'Selling' and $cart->contains('product_id', $product->id))
                                    {!!Form::open(['action' => ['CartsController@destroy', $cart->firstWhere('product_id', $product->id)], 'method' => 'POST',])!!}
                                    {{Form::hidden('_method', 'DELETE')}}
                                    <td>
                                        <center>
                                            <button class="btn btn-danger">
                                                <span class="fa fa-minus-circle"></span>
                                            </button>
                                        </center>
                                    </td>
                                    {!!Form::close()!!}
                                @elseif($product->status == 'Selling')
                                    <td>
                                        <center>
                                            <button class="btn btn-success modalSellClass" data-toggle="modal" data-target="#modalSell" data-product-id={{ $product->id }}>
                                                <span class="fa fa-cart-arrow-down"></span>
                                            </button>
                                        </center>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @endauth
                        </tr>
                    @endforeach()
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalSell" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! Form::open(['action' => 'CartsController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{Form::text('productId', '', ['class' => 'form-control', 'placeholder' => 'Product Id', 'id' => 'productId', 'readonly', 'hidden'])}}
                    {{Form::label('brandName', 'Brand Name', ['id' => 'brandName'])}}
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <small>{{Form::label('genericName', 'Generic Name')}}</small>
                    {{Form::text('genericName', '', ['class' => 'form-control', 'placeholder' => 'Generic Name', 'id' => 'genericName', 'readonly'])}}
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <small>{{Form::label('drugType', 'Drug Type')}}</small>
                        {{Form::text('drugType', '', ['class' => 'form-control', 'placeholder' => 'Drug Type',  'id' => 'drugType', 'readonly'])}}
                    </div>
                    <div class="form-group col-md-4">
                        <small>{{Form::label('manufacturer', 'Manufacturer Name')}}</small>
                        {{Form::text('manufacturer', '', ['class' => 'form-control', 'placeholder' => 'Manufacturer', 'id' => 'manufacturerName', 'readonly'])}}
                    </div>
                    <div class="form-group col-md-4">
                        <small>{{Form::label('quantity', 'Remaining Stocks')}}</small>
                        {{Form::number('quantity', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Quantity', 'id' => 'quantity', 'readonly'])}}
                    </div>
                </div>

                <center>{{Form::label('prices', 'Prices',['class' => 'pt-4'])}}</center>
                <div class="row">
                    <div class="form-group col-md-4">
                    <small>{{Form::label('marketPrice', 'Market')}}</small>
                    {{Form::number('purchasePrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Purchase Price' , 'step' => 'any', 'id' => 'purchasePrice', 'readonly'])}}
                    </div>
                    <div class="form-group col-md-4">
                    <small>{{Form::label('specialPrice', 'Special')}}</small>
                    {{Form::number('specialPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Special Price' , 'step' => 'any', 'id' => 'specialPrice', 'readonly'])}}
                    </div>
                    <div class="form-group col-md-4">
                    <small>{{Form::label('walkInPrice', 'Walk-In')}}</small>
                    {{Form::number('walkInPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Walk-In Price' , 'step' => 'any', 'id' => 'walkInPrice', 'readonly'])}}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                    <small>{{Form::label('promoPrice', 'Promo')}}</small>
                    {{Form::number('promoPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Promo Price' , 'step' => 'any', 'id' => 'promoPrice', 'readonly'])}}
                    </div>
                    <div class="form-group col-md-6">
                    <small>{{Form::label('distributorPrice', 'Distributor\'s')}}</small>
                    {{Form::number('distributorPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Distributor\'s Price' , 'step' => 'any', 'id' => 'distributorPrice', 'readonly'])}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{ Form::submit('Add to Cart', ['class' => 'btn btn-primary col-md-12'])}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
{{-- {{ $products->links() }} --}}
@endsection()

@section('formLogic')
<script>
    $('document').ready(function () {
        console.log('Page is ready');
        $('#tableSearchContainer').hide();

        $('#search').val('');
        $('#search').keyup(function () {
                var value = $(this).val().toLowerCase();
                $("#tableProducts tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            // if ($(this).val() != '') {
            //     searchProducts($(this).val());
            //     $('.pagination').hide();
            // } else {
            //     $('#tableContainer').show();
            //     $('#tableSearchContainer').hide();
            //     $('.pagination').show();
            // }
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

                        // modalSell
                        $('#brandName').html(msg['product']['brand_name']);
                        $('#productId').val(msg['product']['id']);
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