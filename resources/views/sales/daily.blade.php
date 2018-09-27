@extends('layouts.app')

@section('content')
    <div class="col-md-12 responsive">
        <div class="form-group">
        <h1 class="text-center">&#8369; Daily Sales</h1>
        @include('inc.salesnav')
        <div class="form-inline col-md-12 my-2">
            {{Form::label('dailySalesDate', 'Date', ['class' => 'col-md-1'])}}
            {{Form::date('dailySalesDate', '', ['class' => 'form-control col-md-11', 'placeholder' => 'Date', 'required', 'id' => 'dailySalesDate'])}}
        </div>
        <div class="table-responsive rounded my-2" id="tableContainer">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark table-sm">
                    <tr class="text-center small">
                        @if ($sales->first() != null)
                            <th colspan="8" class="align-middle small">Sales for {{ Carbon\Carbon::parse($sales->first()->sale_date)->toFormattedDateString() }}</th>    
                        @else
                            <th colspan="8" class="align-middle small">No sales</th>    
                        @endif
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
                <tbody class="table-sm" id="myTable">
                    @php
                        $totalAmount = 0;
                        setlocale(LC_MONETARY,"en");
                    @endphp
                    @foreach ($sales as $sale)
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
        </div>
        {{-- {{ $sales->links() }} --}}
    </div>
@endsection

@section('formLogic')
    <script>
        $(document).ready(function (){
            console.log('Page is ready.');

            var splitPathname = window.location.pathname.split('/');
            $('#dailySalesDate').val(splitPathname[3]);

            $('#dailySalesDate').change(function (){
                window.location.replace('/sales/daily/' + $(this).val());
            });

            sortTable(0);
        });

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc";
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 0; i < (rows.length - 1); i++) {
                    // Start by saying there should be no switching:
                    shouldSwitch = false;
                    /* Get the two elements you want to compare,
                    one from current row and one from the next: */
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /* Check if the two rows should switch place,
                    based on the direction, asc or desc: */
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /* If a switch has been marked, make the switch
                    and mark that a switch has been done: */
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    // Each time a switch is done, increase this count by 1:
                    switchcount++;
                } else {
                    /* If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again. */
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
@endsection