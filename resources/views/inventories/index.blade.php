@extends('layouts.app')

@section('content')
<div class="col-md-12 responsive">

    <div class="form-group">
    <h1 class="">Inventories</h1>
    <a class="btn btn-primary" href="/inventories/create">Add Inventory</a>

    {{-- <div class="form-group col-md-12 py-2">
        {{Form::label('search', 'Search')}}
        {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Brand Name / Generic Name)'])}}
    </div> --}}

    {{-- <div class="responsive" id="tableSearchContainer"></div> --}}
    @foreach ($batches as $batch)
    <div class="responsive py-2" id="tableContainer">
        <table class="table table-striped table-bordered">
            <tr>
                <th colspan="6"><small>Batch Number: </small>{{ $batch->id }}</th>
                <th colspan="1"><small>Date of Purchase: </small>{{ $batch->purchase_date }}</th>
            </tr>
            <th>Brand Name</th>
            <th>Generic Name</th>
            <th>Supplier</th>
            <th>Quantity</th>
            <th>Sold</th>
            <th>Remaining Stocks</th>
            <th>Expiration Date</th>
            @foreach ($batch->inventories as $inventory)
                <tr>
                    <td><small>{{ $inventory->product->brand_name }}</small></td>
                    <td><small>{{ $inventory->product->genericNames->description }}</small></td>
                    <td><small>{{ $inventory->supplier->name }}</small></td>
                    <td><small>{{ $inventory->quantity }}</small></td>
                    <td><small>{{ $inventory->sold }}</small></td>
                    <td><small>{{ $inventory->quantity - $inventory->sold }}</small></td>
                    <td><small>{{ $inventory->expiration_date }}</small></td>
                </tr>
            @endforeach
        </table>
    </div>
    @endforeach
{{ $batches->links() }}
@endsection()