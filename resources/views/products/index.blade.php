@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-group">
    <h1 class="">Products</h1>
    <a class="btn btn-primary" href="/products/create">Add Product</a>
    </div>
    <div class="form-group col-md-12">
        {{Form::label('search', 'Search')}}
        {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Brand Name / Generic Name)'])}}
    </div>
    <div class="responsive" id="tableSearchContainer"></div>
    <div class="responsive" id="tableContainer">
        <table class="table table-striped table-bordered table-hover" id="tableProducts">
            <th><label>Brand Name</label></th>
            <th><label>Generic Name</label></th>
            <th><label>Drug Type</label></th>
            <th><label>Quantity</label></th>
            <th><label>Market Price</label></th>
            <th><label>Special Price</label></th>
            <th><label>Walk-In Price</label></th>
            <th><label>Promo Price</label></th>
            <th><label>Distributor's Price</label></th>
            <th><label>Action</label></th>
            @foreach ($products as $product)
                <tr>
                    <td><a href="/products/{{ $product->id }}" class="">{{ $product->brand_name }}</a></td>
                    <td>{{ $product->genericNames->description }}</td>
                    <td>{{ $product->drugTypes->description }}</td>
                    <td>

                        @php $quantity = array() @endphp
                        @foreach($product->inventories as $inventory)
                            <?php array_push($quantity, $inventory->quantity) ?>
                        @endforeach()
                        @php echo array_sum($quantity) @endphp

                    </td>
                    <td>{{ $product->market_price }}</td>
                    <td>{{ $product->special_price }}</td>
                    <td>{{ $product->walk_in_price }}</td>
                    <td>{{ $product->promo_price }}</td>
                    <td>{{ $product->distributor_price }}</td>
                    <td><button class="btn btn-success" data-toggle="modal" data-target="#modalSell"><span class="badge">Sell</span></button></td>
                </tr>
            @endforeach()
        </table>
    </div>
{{ $products->links() }}
@endsection()

@section('formLogic')
<script>
    $('document').ready(function(){
        console.log('Page is ready');
        $('#tableSearchContainer').hide();
        $('#search').keyup(function(){
            if($(this).val() != ''){
                searchProducts($(this).val());
            }else{
                $('#tableContainer').show();
                $('#tableSearchContainer').hide();
            }
        });
    });

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
</script>
@endsection