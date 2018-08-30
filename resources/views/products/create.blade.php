@extends('layouts.app')
@section('content')

<div class="container container-fluid relative">
    <h1>Add a Product</h1>
    <hr>
    {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    <div class="col-md-12">
        <h3>Product Information</h3>
        <div class="col-md-12 row">
            <div class="form-group col-md-3">
            {{Form::label('brandName', 'Brand Name')}}
            {{Form::text('brandName', '', ['class' => 'form-control', 'placeholder' => 'Brand Name'])}}
            </div>
            <div class="form-group  col-md-3">
            {{Form::label('genericName', 'Generic Name')}}
            {{Form::text('genericName', '', ['class' => 'form-control', 'placeholder' => 'Generic Name'])}}
            </div>
            <div class="form-group  col-md-3">
            {{Form::label('manufacturer', 'Manufacturer')}}
            {{Form::text('manufacturer', '', ['class' => 'form-control', 'placeholder' => 'Manufacturer'])}}
            </div>
            <div class="form-group col-md-3">
                <div class="autocomplete">
            {{Form::label('drugType', 'Drug Type')}}
            {{-- {{Form::select('drugType', ['L' => 'Large', 'S' => 'Small'], null, ['class' => 'form-control', 'placeholder' => 'Pick a type...'])}} --}}
            {{Form::text('drugType', '', ['class' => 'form-control', 'placeholder' => 'Drug Type', 'id' => 'drugType', 'type' => 'text'])}}
                {{-- <input id="drugType" type="text" name="myCountry" placeholder="Country"> --}}
                </div>
            </div>
        </div>

        <hr>
        <h3>Inventory Information</h3>
        <div class="col-md-12 row">
            <div class="form-group  col-md-5">
            {{Form::label('nameOfSupplier', 'Name of Supplier')}}
            {{Form::text('nameOfSupplier', '', ['class' => 'form-control', 'placeholder' => 'Name of Supplier'])}}
            </div>
            <div class="form-group col-md-3">
            {{Form::label('expirationDate', 'Expiration Date')}}
            {{Form::date('expirationDate', '', ['class' => 'form-control', 'placeholder' => 'Expiration Date'])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('quantity', 'Quantity')}}
            {{Form::number('quantity', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Quantity'])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('batchNumber', 'Batch Number')}}
            {{Form::number('batchNumber', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Batch Number' , 'step' => 1])}}
            </div>
        </div>

        <hr>
        <h3>Prices</h3>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
            {{Form::label('marketPrice', 'Market Price')}}
            {{Form::number('marketPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Market Price' , 'step' => 1])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('specialPrice', 'Special Price')}}
            {{Form::number('specialPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Special Price' , 'step' => 1])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('walkInPrice', 'Walk-In Price')}}
            {{Form::number('walkInPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Walk-In Price' , 'step' => 1])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('promoPrice', 'Promo Price')}}
            {{Form::number('promoPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Promo Price' , 'step' => 1])}}
            </div>
            <div class="form-group col-md-2">
            {{Form::label('distributorPrice', 'Distributor\'s Price')}}
            {{Form::number('distributorPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Distributor\'s Price' , 'step' => 1])}}
            </div>
        </div>

        <hr>
        <a class="btn btn-danger" href="/products">Cancel</a>
        {{ Form::submit('Add Product', ['class' => 'btn btn-primary'])}}
    </div>
    {!! Form::close() !!}

</div>

@endsection

@section('formLogic')
<script>
    $('document').ready(function(){
        var drugTypes = ["Capsule", "Tablet", "Solvent"];
        autocomplete(document.getElementById("drugType"), drugTypes);
    });
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