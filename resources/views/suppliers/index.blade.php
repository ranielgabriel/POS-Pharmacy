@extends('layouts.app')

@section('content')
<div class="col-md-12 responsive">

    <div class="form-group">
    <h1 class="">Suppliers</h1>
    <a class="btn btn-primary" href="/suppliers/create">Add Supplier</a>

    <div class="form-group col-md-12 py-2">
        {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Supplier Name / Contact Person)'])}}
    </div>

    <div class="responsive" id="tableSearchContainer"></div>
    <div class="responsive" id="tableContainer">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><center><small>Name</small></center></th>
                    <th><center><small>Address</small></center></th>
                    <th><center><small>LTO Number</small></center></th>
                    <th><center><small>Expiration Date</small></center></th>
                    <th><center><small>Contact Person</small></center></th>
                    <th><center><small>Contact Number</small></center></th>
                    <th><center><small>Email Adress</small></center></th>
                </tr>
            </thead>
            <tbody id="tableSupplier">
                @foreach ($suppliers as $supplier)
                    <tr class="modalSupplierClass" data-target="#modalSupplier" data-toggle="modal" data-supplier-id={{ $supplier->id }}>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>{{ $supplier->lto_number }}</td>
                        <td>{{ $supplier->expiration_date }}</td>
                        <td>{{ $supplier->contact_person }}</td>
                        <td>{{ $supplier->contact_number }}</td>
                        <td>{{ $supplier->email_address }}</td>
                    </tr>
                @endforeach()
            </tbody>
        </table>
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
        searchSupplierInfo(supplierId);
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