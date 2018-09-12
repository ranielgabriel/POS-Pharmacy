@extends('layouts.app')

@section('content')
    <div class="col-md-12 responsive">

        <div class="form-group">
        <h1 class="">Inventories</h1>
        <a class="btn btn-primary" href="/inventories/create"><span class="fa fa-plus"></span>&nbsp;Inventory</a>

        {{-- <div class="form-group col-md-12 py-2">
            {{Form::label('search', 'Search')}}
            {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Brand Name / Generic Name)'])}}
        </div> --}}

        {{-- <div class="responsive" id="tableSearchContainer"></div> --}}
        @foreach ($batches as $batch)
        <div class="table-responsive rounded my-2" id="tableContainer">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark table-sm">
                    <tr class="">
                        <th colspan="8" class="align-middle"><small>Batch Number: </small>{{ $batch->id }}</th>
                        {{-- <th colspan="1"><small>Date of Delivery: </small>{{ $batch->delivery_date }}</th> --}}
                        </tr>
                </thead>
                <thead class="thead-dark table-sm">
                    <tr class="text-center small">

                        <th>Generic Name</th>
                        <th>Brand Name</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                        <th>Sold</th>
                        <th>Remaining Stocks</th>
                        <th>Delivery Date</th>
                        <th>Expiration Date</th>
                    </tr>
                </thead>
                <tbody class="table-sm">
                    @foreach ($batch->inventories->sortBy('product.genericNames.description') as $inventory)
                        <tr class="align-middle text-center small">
                            <td class="align-middle">{{ $inventory->product->genericNames->description }}</td>
                            <td class="align-middle">{{ $inventory->product->brand_name }}</td>
                            <td class="align-middle"><a href="/suppliers/{{$inventory->supplier->id}}">{{ $inventory->supplier->name }}</a></td>
                            <td class="align-middle">{{ $inventory->quantity }}</td>
                            <td class="align-middle">{{ $inventory->sold }}</td>
                            <td class="align-middle">{{ $inventory->quantity - $inventory->sold }}</td>
                            <td class="align-middle">{{ $inventory->delivery_date }}</td>
                            <td class="align-middle">{{ $inventory->expiration_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    {{ $batches->links() }}
@endsection()