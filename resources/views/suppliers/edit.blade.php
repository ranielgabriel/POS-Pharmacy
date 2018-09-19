@extends('layouts.app')
@section('content')
    <div class="container container-fluid">
        <h3 class="text-center">Update Supplier Information</h3>
        <hr>
        {!! Form::open(['action' => ['SuppliersController@update', $supplier->id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
        <div class="col-md-12">
            <h3 class="text-center">Supplier Information</h3>
                <div class="col-md-12">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {{Form::label('supplierName', 'Supplier Name')}}
                            {{Form::text('supplierName', $supplier->name, ['class' => 'form-control', 'placeholder' => 'Supplier Name', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('address', 'Address')}}
                            {{Form::text('address', $supplier->address, ['class' => 'form-control', 'placeholder' => 'Address', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('ltoNumber', 'LTO Number')}}
                            {{Form::number('ltoNumber', $supplier->lto_number , ['class' => 'form-control', 'placeholder' => 'LTO Number', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('expirationDate', 'Expiration Date')}}
                            {{Form::date('expirationDate', $supplier->expiration_date , ['class' => 'form-control', 'placeholder' => 'Expiration Date', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('contactPerson', 'Contact Person')}}
                            {{Form::text('contactPerson', $supplier->contact_person , ['class' => 'form-control', 'placeholder' => 'Contact Person', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('contactNumber', 'Contact Number')}}
                            {{Form::text('contactNumber', $supplier->contact_number , ['class' => 'form-control', 'placeholder' => 'Contact Number', 'required'])}}
                        </div>
                        <div class="form-group col-md-12">
                            {{Form::label('emailAddress', 'Email Address')}}
                            {{Form::text('emailAddress', $supplier->email_address , ['class' => 'form-control', 'placeholder' => 'Email Address', 'required'])}}
                        </div>
                    </div>
                </div>
            <hr>
            <a class="btn btn-danger" href="/suppliers/{{$supplier->id}}"><span class="fa fa-times"></span>&nbsp;Cancel</a>
            {{Form::hidden('_method', 'PUT')}}
            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span>&nbsp;Save Changes</button>
        </div>
        {!! Form::close() !!}

    </div>
@endsection