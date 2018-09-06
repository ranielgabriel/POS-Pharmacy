@extends('layouts.app')

@section('content')
<div class="col-md-12 responsive">

    <div class="form-group">
    <h1 class="">Suppliers</h1>
    <a class="btn btn-primary" href="/products/create">Add Supplier</a>

    <div class="form-group col-md-12 py-2">
        {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Supplier Name, Contact Person)'])}}
    </div>

    <div class="responsive" id="tableSearchContainer"></div>
    <div class="responsive" id="tableContainer">
        <table class="table table-striped table-bordered table-hover" id="tableProducts">
            <th><center><label>Name</label></center></th>
            <th><center><label>Address</label></center></th>
            <th><center><label>LTO Number</label></center></th>
            <th><center><label>Expiration Date</label></center></th>
            <th><center><label>Contact Person</label></center></th>
            <th><center><label>Contact Number</label></center></th>
            <th><center><label>Email Address</label></center></th>
            @foreach ($suppliers as $supplier)

        <tr class="clickable-row" data-href="/suppliers/{{$supplier->id}}">
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>{{ $supplier->lto_number }}</td>
                    <td>{{ $supplier->expiration_date }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->contact_number }}</td>
                    <td>{{ $supplier->email_address }}</td>
                </tr>
            @endforeach()
        </table>
    </div>
{{ $suppliers->links() }}
@endsection

@section('formLogic')
<script>
$(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
</script>
@endsection