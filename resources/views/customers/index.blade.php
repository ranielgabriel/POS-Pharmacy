@extends('layouts.app')
@section('content')
    <div class="col-md-12 responsive">
        <div class="form-group">
            <h1 class="text-center"><span class="fa fa-users">&nbsp;</span>Customers</h1>

            @if(Auth::user()->role == 'Administrator')
                <a class="btn btn-primary" href="/customers/create"><span class="fa fa-plus"></span>&nbsp;Customer</a>
            @endif

            <div class="input-group mb-3 my-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"><span class="fa fa-search"></span></span>
                </div>
                {{Form::text('search', '', ['id' => 'search', 'class' => 'form-control', 'placeholder' => 'Search... (Customer Name / Address / Contact No.)'])}}
            </div>

            <div class="table-responsive rounded" id="tableContainer">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="thead-dark table-sm">
                        <tr class="text-center small">
                            <th class="align-middle">Customer Name</th>
                            <th class="align-middle">Contact No.</th>
                            <th class="align-middle">Address</th>
                        </tr>
                    </thead>
                    <tbody id="tableCustomers" class="table-sm" style="cursor: pointer;">
                        @foreach ($customers as $customer)
                            <tr class="align-middle text-center modalCustomerClass" data-customer-id="{{ $customer->id }}">
                                <td class="align-middle">{{ $customer->name }}</td>
                                <td class="align-middle">{{ $customer->contact_number }}</td>
                                <td class="align-middle">{{ $customer->address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('formLogic')
    <script>
        $('document').ready(function(){
            $('#search').val('');
            $('#search').keyup(function () {
                    var value = $(this).val().toLowerCase();
                    $("#tableCustomers tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('.modalCustomerClass').click(function(){
                var customerId = $(this).data('customer-id');
                window.location.href = ('/customers/' + customerId);
            });

        });
    </script>
@endsection