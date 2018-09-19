@extends('layouts.app')
@section('content')
    <div class="container container-fluid">
        <div class="col-md-12">

            <a class="btn btn-info" href="/inventories"><span class="fa fa-arrow-left"></span>&nbsp;Back</a>
            <div class="row float-right">
                <a class="btn btn-info mx-1" href="/suppliers/edit/{{ $supplier->id }}"><span class="fa fa-edit"></span>&nbsp;Update</a>
                <a class="btn btn-danger mx-1" href="/suppliers"><span class="fa fa-trash"></span>&nbsp;Delete</a>
            </div>
            <hr>
            
            <h3>Supplier Information</h3>
                <div class="col-md-12">
                    <div class="form-group col-md-12">
                        <div class="form-group  col-md-12">
                        {{Form::label('supplierName', 'Supplier Name')}}
                        {{Form::text('supplierName', $supplier->name, ['class' => 'form-control', 'placeholder' => 'Supplier Name', 'disabled' => true])}}
                        </div>
                        <div class="form-group  col-md-12">
                        {{Form::label('address', 'Address')}}
                        {{Form::text('address', $supplier->address, ['class' => 'form-control', 'placeholder' => 'Address', 'disabled' => true])}}
                        </div>
                        <div class="form-group  col-md-12">
                        {{Form::label('ltoNumber', 'LTO Number')}}
                        {{Form::number('ltoNumber', $supplier->lto_number , ['class' => 'form-control', 'placeholder' => 'LTO Number', 'disabled' => true])}}
                        </div>
                        <div class="form-group col-md-12">
                        {{Form::label('expirationDate', 'Expiration Date')}}
                        {{-- {{Form::select('drugType', ['L' => 'Large', 'S' => 'Small'], null, ['class' => 'form-control', 'placeholder' => 'Pick a type...'])}} --}}
                        {{Form::text('expirationDate', $supplier->expiration_date , ['class' => 'form-control', 'placeholder' => 'Expiration Date', 'disabled' => true])}}
                        </div>
                        <div class="form-group col-md-12">
                        {{Form::label('contactPerson', 'Contact Person')}}
                        {{-- {{Form::select('drugType', ['L' => 'Large', 'S' => 'Small'], null, ['class' => 'form-control', 'placeholder' => 'Pick a type...'])}} --}}
                        {{Form::text('contactPerson', $supplier->contact_person , ['class' => 'form-control', 'placeholder' => 'Contact Person', 'disabled' => true])}}
                        </div>
                        <div class="form-group col-md-12">
                        {{Form::label('contactNumber', 'Contact Number')}}
                        {{-- {{Form::select('drugType', ['L' => 'Large', 'S' => 'Small'], null, ['class' => 'form-control', 'placeholder' => 'Pick a type...'])}} --}}
                        {{Form::text('contactNumber', $supplier->contact_number , ['class' => 'form-control', 'placeholder' => 'Contact Number', 'disabled' => true])}}
                        </div>
                        <div class="form-group col-md-12">
                        {{Form::label('emailAddress', 'Email Address')}}
                        {{-- {{Form::select('drugType', ['L' => 'Large', 'S' => 'Small'], null, ['class' => 'form-control', 'placeholder' => 'Pick a type...'])}} --}}
                        {{Form::text('emailAddress', $supplier->email_address , ['class' => 'form-control', 'placeholder' => 'Email Address', 'disabled' => true])}}
                        </div>
                    </div>
                </div>
        </div>

    </div>
@endsection
