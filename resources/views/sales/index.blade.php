@extends('layouts.app')

@section('content')
    <div class="col-md-12 responsive">

        <div class="form-group">
        <h1 class="text-center">&#8369; Sales</h1>
        @include('inc.salesnav')
        @foreach ($sales as $sale)
            <div class="table-responsive rounded my-2" id="tableContainer">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark table-sm">
                        <tr class="align-middle">
                            <th colspan="8" class="align-middle small">Sale number: {{ $sale->id }}<b class="float-right align-middle small">Date: {{ Carbon\Carbon::parse($sale->sale_date)->format('l jS \\of F Y h:i:s A') }}</b></th>
                        </tr>
                        <tr>
                            <th class="align-middle small" colspan="8">Sold to: {{ $sale->customer->name }}</th>
                        </tr>
                    </thead>
                    <thead class="thead-dark table-sm">
                        <tr class="text-center small">
                            <th>Generic Name</th>
                            <th>Brand Name</th>
                            <th>Drug Type</th>
                            <th>Supplier</th>
                            <th>Expiration Date</th>
                            <th>Quantity Sold</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="table-sm" class="myTable" id="myTable">
                        @php
                            $totalAmount = 0;
                            setlocale(LC_MONETARY,"en");
                        @endphp
                        @foreach($sale->productSale as $productSale)
                            <tr class="align-middle text-center small">
                                <td class="align-middle">{{ $productSale->product->genericNames->description }}</td>
                                <td class="align-middle">{{ $productSale->product->brand_name }}</td>
                                <td class="align-middle">{{ $productSale->product->drugTypes->description }}</td>
                                <td class="align-middle"><a class="modalSupplierClass" href="#" role="button" data-toggle="modal" data-target="#modalSupplier" data-supplier-id="{{ $productSale->inventory->supplier->id}}">{{ $productSale->inventory->supplier->name }}</a></td>
                                <td class="align-middle">{{ Carbon\Carbon::parse($productSale->inventory->expiration_date)->toFormattedDateString() }}</td>
                                <td class="align-middle">{{ $productSale->quantity }}</td>
                                <td class="align-middle">&#8369; {{ number_format($productSale->price, 2, '.', ',') }}</td>
                                <td class="align-middle">&#8369; {{ number_format($productSale->quantity * $productSale->price, 2, '.', ',') }}</td>
                                <?php
                                    $totalAmount += $productSale->quantity * $productSale->price;
                                ?>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="thead-dark small table-sm">
                        <tr>
                            <th class="align-middle" colspan="7">Total Amount</th>
                            <th class="align-middle text-center" colspan="1">&#8369; <?php echo number_format($totalAmount, 2, '.', ',');?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endforeach
        </div>
        {{ $sales->links()}}
    </div>
@endsection