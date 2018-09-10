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
            <thead>
                <tr>
                    <tr>
                        <th colspan="8"><small>Batch Number: </small>{{ $batch->id }}</th>
                        {{-- <th colspan="1"><small>Date of Delivery: </small>{{ $batch->delivery_date }}</th> --}}
                    </tr>
                    <th><center><small>Brand Name</small></center></th>
                    <th><center><small>Generic Name</small></center></th>
                    <th><center><small>Supplier</small></center></th>
                    <th><center><small>Quantity</small></center></th>
                    <th><center><small>Sold</small></center></th>
                    <th><center><small>Remaining Stocks</small></center></th>
                    <th><center><small>Delivery Date</small></center></th>
                    <th><center><small>Expiration Date</small></center></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($batch->inventories as $inventory)
                    <tr>
                        <td><center>{{ $inventory->product->brand_name }}</center></td>
                        <td><center>{{ $inventory->product->genericNames->description }}</center></td>
                        <td><center>{{ $inventory->supplier->name }}</center></td>
                        <td><center>{{ $inventory->quantity }}</center></td>
                        <td><center>{{ $inventory->sold }}</center></td>
                        <td><center>{{ $inventory->quantity - $inventory->sold }}</center></td>
                        <td><center>{{ $inventory->delivery_date }}</center></td>
                        <td><center>{{ $inventory->expiration_date }}</center></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
{{ $batches->links() }}
@endsection()