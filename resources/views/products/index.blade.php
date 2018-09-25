@extends('layouts.app')

@section('content')
    <div class="col-md-12 responsive">
        <div class="form-group">
            <h1 class="text-center"><span class="fa fa-archive">&nbsp;</span>Products</h1>
            @guest

            @else
                @if($user->role == 'Administrator')
                    <a class="btn btn-primary" href="/products/create"><span class="fa fa-plus"></span>&nbsp;Product</a>
                @endif
            @endguest

            <div class="input-group mb-3 my-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"><span class="fa fa-search"></span></span>
                </div>
                {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Generic Name / Brand Name / Drug Type / Status)'])}}
            </div>

            <div class="table-responsive rounded" id="tableContainer">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="thead-dark table-sm">
                        <tr class="text-center small">
                            <th class="align-middle">Generic Name</th>
                            <th class="align-middle">Brand Name</th>
                            <th class="align-middle">Drug Type</th>
                            <th class="align-middle">Stocks</th>
                            <th class="align-middle">Status</th>
                            @guest
                                <th class="align-middle">Price</th>
                            @endguest

                            @auth
                                <th class="align-middle">Purchase Price</th>
                                <th class="align-middle">Special Price</th>
                                <th class="align-middle">Walk-In Price</th>
                                <th class="align-middle">Promo Price</th>
                                <th class="align-middle">Distributor's Price</th>
                                <th class="align-middle">Cart</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody id="tableProducts" class="table-sm">
                        
                        @foreach ($products->sortBy('genericNames.description') as $product)
                            <tr class="align-middle text-center">
                                <td class="align-middle">{{ $product->genericNames->description }}</td>
                                <td class="align-middle"><a class="" href="/products/{{$product->id}}"><strong>{{ $product->brand_name }}</strong></a></td>
                                <td class="align-middle">{{ $product->drugTypes->description }}</td>
                                <td class="align-middle">{{ $product->inventories->sum('quantity') - $product->inventories->sum('sold') }}</td>

                                @if($product->status == 'In-stock')
                                    <td class="align-middle"><center><span class="badge badge-warning">{{ $product->status }}</span></center></td>
                                @elseif($product->status == 'Selling')
                                    <td class="align-middle"><center><span class="badge badge-success">{{ $product->status }}</span></center></td>
                                @elseif($product->status == 'Out-of-stock')
                                    <td class="align-middle"><center><span class="badge badge-danger">{{ $product->status }}</span></center></td>
                                @endif

                                @guest
                                    <td class="align-middle">&#8369; {{ $product->walk_in_price }}</td>
                                @endguest

                                @auth
                                    <td class="align-middle">&#8369; {{ $product->purchase_price }}</td>
                                    <td class="align-middle">&#8369; {{ $product->special_price }}</td>
                                    <td class="align-middle">&#8369; {{ $product->walk_in_price }}</td>
                                    <td class="align-middle">&#8369; {{ $product->promo_price }}</td>
                                    <td class="align-middle">&#8369; {{ $product->distributor_price }}</td>

                                    @if($product->status == 'Selling' and $cart->contains('product_id', $product->id))
                                        {!!Form::open(['action' => ['CartsController@destroy', $cart->firstWhere('product_id', $product->id)], 'method' => 'POST',])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        <td class="align-middle">
                                            <center>
                                                <button class="btn btn-danger">
                                                    <span class="fa fa-minus-circle"></span>
                                                </button>
                                            </center>
                                        </td>
                                        {!!Form::close()!!}
                                    @elseif($product->status == 'Selling')
                                        <td class="align-middle">
                                            <center>
                                                <button class="btn btn-success modalSellClass" data-toggle="modal" data-target="#modalSell" data-product-id={{ $product->id }}>
                                                    <span class="fa fa-plus-circle"></span>
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
                    {{-- {{ Form::submit('Add to Cart', ['class' => 'btn btn-primary col-md-12'])}} --}}
                    <button type="submit" class="btn btn-primary col-md-12" id="btnAddToCart">Add to Cart&nbsp;<span class="fa fa-cart-plus"></span></button>
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
            
            @auth()
                if({!! $cart->count() !!} != 0){
                    $('#anchorCart').append('<span class="badge badge-pill badge-info">' + {!! $cart->count() !!} + '</span>');
                }
            @endauth

            $('#search').val('');
            $('#search').keyup(function () {
                    var value = $(this).val().toLowerCase();
                    $("#tableProducts tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
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
        });
    </script>
@endsection