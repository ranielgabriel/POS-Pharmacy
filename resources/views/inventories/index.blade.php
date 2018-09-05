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
                <th colspan="8"><small>Batch Number: </small>{{ $batch->id }}</th>
                {{-- <th colspan="1"><small>Date of Delivery: </small>{{ $batch->delivery_date }}</th> --}}
            </tr>
            <th><center>Brand Name</center></th>
            <th><center>Generic Name</center></th>
            <th><center>Supplier</center></th>
            <th><center>Quantity</center></th>
            <th><center>Sold</center></th>
            <th><center>Remaining Stocks</center></th>
            <th><center>Delivery Date</center></th>
            <th><center>Expiration Date</center></th>
            @foreach ($batch->inventories as $inventory)
                <tr>
                    <td><center><small>{{ $inventory->product->brand_name }}</small></center></td>
                    <td><center><small>{{ $inventory->product->genericNames->description }}</small></center></td>
                    <td><center><small>{{ $inventory->supplier->name }}</small></center></td>
                    <td><center><small>{{ $inventory->quantity }}</small></center></td>
                    <td><center><small>{{ $inventory->sold }}</small></center></td>
                    <td><center><small>{{ $inventory->quantity - $inventory->sold }}</small></center></td>
                    <td><center><small>{{ $inventory->delivery_date }}</small></center></td>
                    <td><center><small>{{ $inventory->expiration_date }}</small></center></td>
                </tr>
            @endforeach
        </table>
    </div>
    @endforeach
{{ $batches->links() }}
@endsection()