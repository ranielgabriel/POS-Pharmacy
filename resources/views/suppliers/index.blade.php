@extends('layouts.app')

@section('content')
    <div class="col-md-12 responsive">
        <div class="form-group">
            <h1 class="text-center"><span class="fa fa-address-card">&nbsp;</span>Suppliers</h1>
                
            @if (Auth::user()->role == 'Administrator')
                <a class="btn btn-primary" href="/suppliers/create"><span class="fa fa-plus"></span>&nbsp;Supplier</a>    
            @endif

            <div class="input-group mb-3 my-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"><span class="fa fa-search"></span></span>
                </div>
                {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Supplier Name / LTO Number / Contact Person / Email)'])}}
            </div>

            <div class="table-responsive rounded" id="tableContainer">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr class="align-middle text-center small">
                            <th>Name</th>
                            <th>Address</th>
                            <th>LTO Number</th>
                            <th>Expiration Date</th>
                            <th>Contact Person</th>
                            <th>Contact Number</th>
                            <th>Email Adress</th>
                        </tr>
                    </thead>
                    <tbody id="tableSupplier" class=" table-sm">
                        @foreach ($suppliers as $supplier)
                            <tr class="modalSupplierClass small" data-supplier-id={{ $supplier->id }} style="cursor: pointer;">
                                <td class="align-middle">{{ $supplier->name }}</td>
                                <td class="align-middle">{{ $supplier->address }}</td>
                                <td class="align-middle">{{ $supplier->lto_number }}</td>
                                <td class="align-middle">{{ $supplier->expiration_date }}</td>
                                <td class="align-middle">{{ $supplier->contact_person }}</td>
                                <td class="align-middle">{{ $supplier->contact_number }}</td>
                                <td class="align-middle">{{ $supplier->email_address }}</td>
                            </tr>
                        @endforeach()
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- {{ $suppliers->links() }} --}}
@endsection

@section('formLogic')
    <script>
    $('document').ready(function ($) {

        console.log('Page is ready');
        $('#tableSearchContainer').hide();
        $('#search').val('');
        $('#search').keyup(function () {

            var value = $(this).val().toLowerCase();
            $("#tableSupplier tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

            // if ($(this).val() != '') {
            //     searchSuppplier($(this).val());
            //     $('.pagination').hide();
            // } else {
            //     $('#tableContainer').show();
            //     $('#tableSearchContainer').hide();
            //     $('.pagination').show();
            // }
        });

        $(".modalSupplierClass").click(function () {
            var supplierId = $(this).data('supplier-id');
            // searchSupplierInfo(supplierId);
            window.location.href = '/suppliers/' + supplierId;
        })

        function searchSuppplier(name) {
            if (name != null) {
                $.ajax({
                    url: '/searchSupplier',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: name
                    },
                    success: function (msg) {
                        $('#tableContainer').hide();
                        $('#tableSearchContainer').show();
                        $('#tableSearchContainer').html('');
                        $('#tableSearchContainer').append(msg.code);

                        console.log(msg);
                    }
                });
            }
        }

        function searchSupplierInfo(supplierId) {
                $.ajax({
                    url: '/searchSupplierInfo',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: supplierId
                    },
                    success: function (msg) {

                        // if the response is not null

                        if (msg['supplier'] != null) {

                            // modalSupplier
                            $('#supplierName').html(msg['supplier']['name']);
                            $('#address').val(msg['supplier']['address']);
                            $('#emailAddress').val(msg['supplier']['email_address']);
                            $('#ltoNumber').val(msg['supplier']['lto_number']);
                            $('#expirationDate').val(msg['supplier']['expiration_date']);
                            $('#contactPerson').val(msg['supplier']['contact_person']);
                            $('#contactNumber').val(msg['supplier']['contact_number']);
                        }
                    }
                });
        }
    });
    </script>
@endsection