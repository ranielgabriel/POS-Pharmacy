@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Products</h1>

    <a class="btn btn-primary" href="/products/create">Add Product</a>

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

    @foreach ($products as $product)
        <tr>
            <td>{{ $product->brand_name }}</td>
            <td>{{ $product->genericNames->description }}</td>
            <td>{{ $product->drugTypes->description }}</td>
            <td>

                @foreach($product->inventories as $inventory)
                    {{ $inventory->quantity }}
                @endforeach()

            </td>
            <td>{{ $product->market_price }}</td>
            <td>{{ $product->special_price }}</td>
            <td>{{ $product->walk_in_price }}</td>
            <td>{{ $product->promo_price }}</td>
            <td>{{ $product->distributor_price }}</td>
        </tr>
    @endforeach()

</table>
</div>
{{ $products->links() }}
@endsection()