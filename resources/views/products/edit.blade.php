@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <h3>Update Product Information</h3>
        <hr>
        {!! Form::open(['action' => ['ProductsController@update', $product->id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
        <div class="col-md-12">
            <div id="productInformationContainer" class="container">

                <h3>Product Information</h3>
                <div class="col-md-12 row">
                    <div class="form-group  col-md-3">
                        {{Form::label('genericName', 'Generic Name')}}
                        {{Form::text('genericName', $product->genericNames->description, ['class' => 'form-control', 'placeholder' => 'Generic Name', 'id' => 'genericName', 'required'])}}
                    </div>
                    <div class="form-group col-md-3">
                        {{Form::label('brandName', 'Brand Name')}}
                        {{Form::text('brandName', $product->brand_name, ['class' => 'form-control', 'placeholder' => 'Brand Name', 'id' => 'brandName', 'required'])}}
                    </div>
                    <div class="form-group  col-md-2">
                        {{Form::label('manufacturer', 'Manufacturer')}}
                        {{Form::text('manufacturer', $product->manufacturers->name, ['class' => 'form-control', 'placeholder' => 'Manufacturer', 'id' => 'manufacturer', 'required'])}}
                    </div>
                    <div class="form-group col-md-2">
                        {{Form::label('drugType', 'Drug Type')}}
                        {{Form::text('drugType', $product->drugTypes->description, ['class' => 'form-control', 'placeholder' => 'Drug Type', 'type' => 'text', 'id' => 'drugType', 'required'])}}
                    </div>
                </div>
            </div>

            <div id="pricesContainer" class="container">
                <hr>
                <h3>Prices</h3>
                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        {{Form::label('purchasePrice', 'Purchase Price')}}
                        {{Form::number('purchasePrice', $product->purchase_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Purchase Price' , 'step' => 'any', 'id' => 'purchasePrice', 'required'])}}
                    </div>
                    <div class="form-group col-md-2">
                        {{Form::label('specialPrice', 'Special Price')}}
                        {{Form::number('specialPrice', $product->special_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Special Price' , 'step' => 'any', 'id' => 'specialPrice', 'required'])}}
                    </div>
                    <div class="form-group col-md-2">
                        {{Form::label('walkInPrice', 'Walk-In Price')}}
                        {{Form::number('walkInPrice', $product->walk_in_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Walk-In Price' , 'step' => 'any', 'id' => 'walkInPrice', 'required'])}}
                    </div>
                    <div class="form-group col-md-2">
                        {{Form::label('promoPrice', 'Promo Price')}}
                        {{Form::number('promoPrice', $product->promo_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Promo Price' , 'step' => 'any', 'id' => 'promoPrice', 'required'])}}
                    </div>
                    <div class="form-group col-md-2">
                        {{Form::label('distributorPrice', 'Distributor\'s Price')}}
                        {{Form::number('distributorPrice', $product->distributor_price, ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Distributor\'s Price' , 'step' => 'any', 'id' => 'distributorPrice', 'required'])}}
                    </div>
                </div>
            </div>

            <hr>
            <a class="btn btn-danger" href="/products/{{$product->id}}">Cancel</a>
            {{Form::hidden('_method', 'PUT')}}
            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span>&nbsp;Update Product</button>
        </div>
        {!! Form::close() !!}

    </div>
@endsection

@section('formLogic')
    <script>
        var drugTypes = [],
            genericNames = [],
            manufacturers = [];

        $('document').ready(function(){
            console.log('Page is ready.');

            getArrayAutocomplete();
            autocomplete(document.getElementById("drugType"), drugTypes);
            autocomplete(document.getElementById("genericName"), genericNames);
            autocomplete(document.getElementById("manufacturer"), manufacturers);

        });

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
    </script>
@endsection