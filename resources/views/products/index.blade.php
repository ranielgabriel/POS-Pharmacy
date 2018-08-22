@extends('layouts.app')
@section('content')
<div class="container container-fluid">
    <div class="form-group">
    <h1 class="">Products</h1>
    <a class="btn btn-primary" href="/products/create">Add Product</a>
    </div>
    <div class="form-group col-md-12">
        {{Form::label('search', 'Search')}}
        {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Brand Name, Generic Name, Manufacturer)'])}}
    </div>
    <table class="table table-striped table-bordered table-hover">
        <th>Brand Name</th>
        <th>Generic Name</th>
        <th>Drug Type</th>
        <th>Quantity</th>
        <th>Market Price</th>
        <th>Special Price</th>
        <th>Walk-In Price</th>
        <th>Promo Price</th>
        <th>Distributor's Price</th>
        <th>Action</th>

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
            <td><a class="btn btn-success" href="#">Sell</a></td>
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

        // $('#tableProducts').append();

        $('#search').keyup(function(){
            console.log($(this).val());
            $.ajax({
                url: '/searchProducts',
                type: 'POST',
                data:{_token: "{{ csrf_token() }}", name: $(this).val() 
                },
                success: function(msg){
                    console.log(msg);
                },
                error: function(){

                }
            })
        });
    });
</script>
@endsection()