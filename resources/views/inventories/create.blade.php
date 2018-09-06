@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <h1>Add an Inventory</h1>
    <hr>
    {!! Form::open(['action' => 'InventoriesController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    <div class="col-md-12">
        <h3>Inventory Information</h3>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
            {{Form::label('batchNumber', 'Batch Number')}}
            {{Form::number('batchNumber', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Batch Number', 'id' => 'batchNumber'])}}
            </div>
            <div class="form-group  col-md-3">
            {{Form::label('supplierName', 'Name of Supplier')}}
            {{Form::text('supplierName', '', ['class' => 'form-control', 'placeholder' => 'Name of Supplier', 'id' => 'supplierName'])}}
            </div>
            <div class="form-group col-md-3">
            {{Form::label('deliveryDate', 'Delivery Date')}}
            {{Form::date('deliveryDate', date('Y-m-d'), ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Delivery Date' , 'id' => 'deliveryDate'])}}
            </div>
        </div>

        <div id="supplierInformation">
            <hr>
            <h3>Supplier Information</h3>
            <div class="col-md-12">
                <div class="row col-md-12">
                    <div class="form-group col-md-4">
                        {{Form::label('supplierName', 'Supplier Name')}}
                        {{Form::text('supplierName', '', ['class' => 'form-control', 'placeholder' => 'Supplier Name', 'disabled' => true])}}
                    </div>
                    <div class="form-group  col-md-8">
                        {{Form::label('address', 'Address')}}
                        {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address', 'disabled' => true])}}
                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="form-group  col-md-6">
                        {{Form::label('ltoNumber', 'LTO Number')}}
                        {{Form::number('ltoNumber', '' , ['class' => 'form-control', 'placeholder' => 'LTO Number', 'disabled' => true])}}
                    </div>
                    <div class="form-group col-md-6">
                        {{Form::label('expirationDate', 'Expiration Date')}}
                        {{Form::text('expirationDate', '', ['class' => 'form-control', 'placeholder' => 'Expiration Date', 'disabled' => true])}}
                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="form-group col-md-4">
                        {{Form::label('contactPerson', 'Contact Person')}}
                        {{Form::text('contactPerson', '', ['class' => 'form-control', 'placeholder' => 'Contact Person', 'disabled' => true])}}
                    </div>
                    <div class="form-group col-md-4">
                        {{Form::label('contactNumber', 'Contact Number')}}
                        {{Form::text('contactNumber', '', ['class' => 'form-control', 'placeholder' => 'Contact Number', 'disabled' => true])}}
                    </div>
                    <div class="form-group col-md-4">
                        {{Form::label('emailAddress', 'Email Address')}}
                        {{Form::text('emailAddress', '', ['class' => 'form-control', 'placeholder' => 'Email Address', 'disabled' => true])}}
                    </div>
                </div>
            </div>
        </div>

        <div id="productInformation">
            <hr>
            <h3>Product Information</h3>
            <div class="col-md-12 row">
                <div class="form-group col-md-3">
                {{Form::label('brandName', 'Brand Name')}}
                {{Form::text('brandName', '', ['class' => 'form-control', 'placeholder' => 'Brand Name'])}}
                </div>
                <div class="form-group  col-md-3">
                {{Form::label('genericName', 'Generic Name')}}
                {{Form::text('genericName', '', ['class' => 'form-control', 'placeholder' => 'Generic Name',  'id' => 'genericNames'])}}
                </div>
                <div class="form-group  col-md-3">
                {{Form::label('manufacturer', 'Manufacturer')}}
                {{Form::text('manufacturer', '', ['class' => 'form-control', 'placeholder' => 'Manufacturer',  'id' => 'manufacturers'])}}
                </div>
                <div class="form-group col-md-3">
                {{Form::label('drugType', 'Drug Type')}}
                {{Form::text('drugType', '', ['class' => 'form-control', 'placeholder' => 'Drug Type', 'id' => 'drugType', 'type' => 'text', ])}}
                </div>
                <div class="form-group col-md-3">
                {{Form::label('expirationDate', 'Expiration Date')}}
                {{Form::date('expirationDate', '', ['class' => 'form-control', 'placeholder' => 'Expiration Date' ])}}
                </div>
                <div class="form-group col-md-3">
                {{Form::label('quantity', 'Quantity')}}
                {{Form::number('quantity', '', ['class' => 'form-control', 'min' => 0, 'placeholder' => 'Quantity'  ])}}
                </div>
            </div>
        </div>

        <hr>

        <a class="btn btn-danger" href="/inventories">Cancel</a>
        {{ Form::submit('Add Inventory', ['class' => 'btn btn-primary'])}}
    </div>
    {!! Form::close() !!}

</div>
@endsection

@section('formLogic')
<script>
    $('document').ready(function () {
        var drugTypes = [],
            genericNames = [],
            manufacturers = [],
            suppliers = [];

        $('#supplierInformation').hide();
        $('#productInformation').hide();

        $('#batchNumber').keyup(function(){
            hideShowProductInformation();
        });
        $('#deliveryDate').change(function(){
            hideShowProductInformation();
        });
        $('#supplierName').keyup(function(){
            hideShowSupplierInformation();
        });

        getArrayAutocomplete();
        autocomplete(document.getElementById("drugType"), drugTypes);
        autocomplete(document.getElementById("genericNames"), genericNames);
        autocomplete(document.getElementById("manufacturers"), manufacturers);
        autocomplete(document.getElementById("supplierName"), suppliers);

        function getArrayAutocomplete() {

            $.ajax({
                url: '/getDrugTypes',
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (msg) {
                    for (var i = 0; i < msg.length; i++) {
                        var obj = msg[i];
                        for (var key in obj) {
                            // console.log(obj[key]);
                            drugTypes.push(obj[key]);
                        }
                    }
                }
            });

            $.ajax({
                url: '/getGenericNames',
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (msg) {
                    for (var i = 0; i < msg.length; i++) {
                        var obj = msg[i];
                        for (var key in obj) {
                            // console.log(obj[key]);
                            genericNames.push(obj[key]);
                        }
                    }
                }
            });

            $.ajax({
                url: '/getManufacturers',
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (msg) {
                    for (var i = 0; i < msg.length; i++) {
                        var obj = msg[i];
                        for (var key in obj) {
                            // console.log(obj[key]);
                            manufacturers.push(obj[key]);
                        }
                    }
                }
            });

            $.ajax({
                url: '/getSuppliers',
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (msg) {
                    for (var i = 0; i < msg.length; i++) {
                        var obj = msg[i];
                        for (var key in obj) {
                            // console.log(obj[key]);
                            suppliers.push(obj[key]);
                        }
                    }
                }
            });
        }

        function hideShowProductInformation(){
            if($('#batchNumber').val() != "" && $('#deliveryDate').val() != ""){
                $('#productInformation').fadeIn();
            }else{
                $('#productInformation').fadeOut();
            }
        }

        function hideShowSupplierInformation(){
            if($('#supplierName').val() != ""){
                $('#supplierInformation').fadeIn();
            }else{
                $('#supplierInformation').fadeOut();
            }
        }

        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function (e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function (e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function (e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }
    });
</script>
@endsection