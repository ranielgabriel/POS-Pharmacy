@extends('layouts.app')
@section('content')
    <div class="col-md-12 responsive">
        <div class="col-md-12">
            <div class="form-group">
                <a class="btn btn-info" href="/inventories"><span class="fa fa-arrow-left"></span>&nbsp;Back</a>
                
                <hr>
                <h3 class="text-center">Batch Information</h3>
                <div class="table-responsive rounded my-2" id="tableContainer">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark table-sm">
                            <tr class="">
                                @if (Auth::user()->role == 'Administrator')
                                    <th colspan="10" class="align-middle"><small>Batch Number: </small>{{ $batch->id }}</th>
                                @else
                                    <th colspan="8" class="align-middle"><small>Batch Number: </small>{{ $batch->id }}</th>
                                @endif
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
                                @if (Auth::user()->role == 'Administrator')
                                    <th colspan="2">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="table-sm">
                            @foreach ($batch->inventories->sortBy('product.genericNames.description') as $inventory)
                                <tr class="align-middle text-center small">
                                    <td class="align-middle">{{ $inventory->product->genericNames->description }}</td>
                                    <td class="align-middle">{{ $inventory->product->brand_name }}</td>
                                    <td class="align-middle"><a class="modalSupplierClass" href="#" role="button" data-toggle="modal" data-target="#modalSupplier" data-supplier-id="{{ $inventory->supplier->id}}">{{ $inventory->supplier->name }}</a></td>
                                    <td class="align-middle">{{ $inventory->quantity }}</td>
                                    <td class="align-middle">{{ $inventory->sold }}</td>
                                    <td class="align-middle">{{ $inventory->quantity - $inventory->sold }}</td>
                                    <td class="align-middle">{{ Carbon\Carbon::parse($inventory->delivery_date)->toFormattedDateString() }}</td>
                                    <td class="align-middle">{{ Carbon\Carbon::parse($inventory->expiration_date)->toFormattedDateString() }}</td>
                                    @if (Auth::user()->role == 'Administrator')
                                        <td><a class="btn btn-info mx-1" href="/inventories/{{ $inventory->id }}/edit"><span class="fa fa-edit"></span>&nbsp;Update</a></td>
                                        <td>
                                            {!!Form::open(['action' => ['InventoriesController@destroy', $inventory->id], 'method' => 'POST',])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::button('<span class="fa fa-trash"></span>&nbsp;Delete', ['type' => 'submit', 'class' => 'btn btn-danger'])}}
                                            {!!Form::close()!!}
                                        </td>
                                    @endif
                                        
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div id="modalSupplier" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{Form::label('supplierName', 'Supplier Name', ['id' => 'supplierName'])}}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group">
                            <small>{{Form::label('address', 'Address')}}</small>
                            {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address', 'disabled' => true, 'id' => 'address'])}}
                        </div>
                        <div class="form-group">
                            <small>{{Form::label('ltoNumber', 'LTO Number')}}</small>
                            {{Form::number('ltoNumber', '' , ['class' => 'form-control', 'placeholder' => 'LTO Number', 'disabled' => true, 'id' => 'ltoNumber'])}}
                        </div>
                        <div class="form-group">
                            <small>{{Form::label('expirationDate', 'Expiration Date')}}</small>
                            {{Form::text('expirationDate', '' , ['class' => 'form-control', 'placeholder' => 'Expiration Date', 'disabled' => true, 'id' => 'expirationDate'])}}
                        </div>
                        <div class="form-group">
                            <small>{{Form::label('contactPerson', 'Contact Person')}}</small>
                            {{Form::text('contactPerson', '', ['class' => 'form-control', 'placeholder' => 'Contact Person', 'disabled' => true, 'id' => 'contactPerson'])}}
                        </div>
                        <div class="form-group">
                            <small>{{Form::label('contactNumber', 'Contact Number')}}</small>
                            {{Form::text('contactNumber', '' , ['class' => 'form-control', 'placeholder' => 'Contact Number', 'disabled' => true, 'id' => 'contactNumber'])}}
                        </div>
                        <div class="form-group">
                            <small>{{Form::label('emailAddress', 'Email Address')}}</small>
                            {{Form::text('emailAddress', '' , ['class' => 'form-control', 'placeholder' => 'Email Address', 'disabled' => true, 'id' => 'emailAddress'])}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="modalSupplierFooter">
                    
                </div>
            </div>
        </div>
    </div>
    
@endsection