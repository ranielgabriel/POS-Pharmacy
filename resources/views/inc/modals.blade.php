<div id="modalSell" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{Form::label('brandName', 'Brand Name', ['id' => 'brandName'])}}
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <small>{{Form::label('genericName', 'Generic Name')}}</small>
                    {{Form::text('genericName', '', ['class' => 'form-control', 'placeholder' => 'Generic Name', 'id' => 'genericName', 'readonly'])}}
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <small>{{Form::label('drugType', 'Drug Type')}}</small>
                        {{-- {{Form::select('drugType', ['L' => 'Large', 'S' => 'Small'], null, ['class' => 'form-control', 'placeholder' => 'Pick a type...'])}} --}}
                        {{Form::text('drugType', '', ['class' => 'form-control', 'placeholder' => 'Drug Type', 'type' => 'text', 'id' => 'drugType', 'readonly'])}}
                            {{-- <input id="drugType" type="text" name="myCountry" placeholder="Country"> --}}
                    </div>
                    <div class="form-group col-md-4">
                        <small>{{Form::label('manufacturer', 'Manufacturer Name')}}</small>
                        {{-- {{Form::select('drugType', ['L' => 'Large', 'S' => 'Small'], null, ['class' => 'form-control', 'placeholder' => 'Pick a type...'])}} --}}
                        {{Form::text('manufacturer', '', ['class' => 'form-control', 'placeholder' => 'Manufacturer', 'type' => 'text', 'id' => 'manufacturerName', 'readonly'])}}
                            {{-- <input id="drugType" type="text" name="myCountry" placeholder="Country"> --}}
                    </div>
                    <div class="form-group col-md-4">
                        <small>{{Form::label('quantity', 'Remaining Stocks')}}</small>
                        {{Form::number('quantity', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Quantity', 'readonly', 'id' => 'quantity', 'readonly'])}}
                    </div>
                </div>

                <center>{{Form::label('prices', 'Prices',['class' => 'pt-4'])}}</center>
                <div class="row">
                    <div class="form-group col-md-4">
                    <small>{{Form::label('marketPrice', 'Market')}}</small>
                    {{Form::number('marketPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Market Price' , 'step' => 1, 'id' => 'marketPrice', 'readonly'])}}
                    </div>
                    <div class="form-group col-md-4">
                    <small>{{Form::label('specialPrice', 'Special')}}</small>
                    {{Form::number('specialPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Special Price' , 'step' => 1, 'id' => 'specialPrice', 'readonly'])}}
                    </div>
                    <div class="form-group col-md-4">
                    <small>{{Form::label('walkInPrice', 'Walk-In')}}</small>
                    {{Form::number('walkInPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Walk-In Price' , 'step' => 1, 'id' => 'walkInPrice', 'readonly'])}}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                    <small>{{Form::label('promoPrice', 'Promo')}}</small>
                    {{Form::number('promoPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Promo Price' , 'step' => 1, 'id' => 'promoPrice', 'readonly'])}}
                    </div>
                    <div class="form-group col-md-6">
                    <small>{{Form::label('distributorPrice', 'Distributor\'s')}}</small>
                    {{Form::number('distributorPrice', '', ['class' => 'form-control', 'min' => 0 ,'placeholder' => 'Distributor\'s Price' , 'step' => 1, 'id' => 'distributorPrice', 'readonly'])}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary col-md-12">Add to cart</button>
            </div>
        </div>
    </div>
</div>