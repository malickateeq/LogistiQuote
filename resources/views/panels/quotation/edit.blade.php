@extends('panels.layouts.master')
@section('content')


<div class="row">
    <div class="col-xl-8 col-md-8 mb-4 offset-md-2">
        <div class="card card shadow">
            <h5 class="card-header">Quotation</h5>
            <div class="card-body">

                <form action="{{ route('quotation.update', $quotation->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <h5> <b> Origin </b> </h5>
                            <input type="text" class="form-control @error('origin') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $quotation->origin }}"
                                name="origin" required>
                            @error('origin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5> <b> Destination </b> </h5>
                            <input type="text" class="form-control @error('destination') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $quotation->destination }}"
                                name="destination" required>
                            @error('destination')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationServer01">Ready to load date</label>
                            <?php $date = Carbon\Carbon::parse($quotation->ready_to_load_date); ?>
                            <input type="text" class="form-control" name="ready_to_load_date" value="{{ $date->format('d-m-Y') }}" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="incoterms">Incoterms</label>
                            <select class="custom-select mr-sm-2" id="incoterms" name="incoterms">
                                <option>Choose..</option>
                                <option value="EXW" <?php echo ($quotation->incoterms == 'EXW') ? 'selected="selected"' : ''; ?> >EXW (Ex Works Place)</option>
                                <option value="FOB" <?php echo ($quotation->incoterms == 'FOB') ? 'selected="selected"' : ''; ?> >FOB (Free On Board Port)</option>
                                <option value="CIP/CIF" <?php echo ($quotation->incoterms == 'CIP/CIF') ? 'selected="selected"' : ''; ?> >CIF/CIP (Cost Insurance & Freight / Carriage & Insurance Paid)</option>
                                <option value="DAP" <?php echo ($quotation->incoterms == 'DAP') ? 'selected="selected"' : ''; ?> >DAP (Delivered At Place)</option>
                            </select>
                        </div>
                    </div>

                    <div id="exw">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationServer01">Pick Up Address</label>
                                <input type="text" class="form-control" name="pickup_address" value="{{ $quotation->pickup_address }}" />

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationServer01">Final destination address</label>
                                <input type="text" class="form-control" name="final_destination_address" value="{{ $quotation->pickup_address }}" value=""/>

                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">

                            <label for="exampleFormControlTextarea1">Description of goods</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                name="description_of_goods">{{ $quotation->description_of_goods }}</textarea>
                            @error('description_of_goods')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="transportation_type">Transportation Type</label>
                            <select class="custom-select mr-sm-2" id="transportation_type"
                                name="transportation_type">
                                <option selected="">Choose...</option>
                                <option value="ocean" <?php echo ($quotation->transportation_type == 'ocean') ? 'selected="selected"' : ''; ?> >Ocean Freight</option>
                                <option value="air" <?php echo ($quotation->transportation_type == 'air') ? 'selected="selected"' : ''; ?>>Air Freight</option>
                            </select>
                        </div>
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Type of Shipment</label>
                            <select class="custom-select mr-sm-2" id="type_of_shipment" name="type">
                                <option selected="">Choose...</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mt-4"> <b> Description of Goods </b> </h5>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <input type="number" class="form-control @error('value_of_goods') is-invalid @enderror"
                                value="{{ $quotation->value_of_goods }}" placeholder="Value of Goods (USD)" name="value_of_goods"
                                required>
                            @error('value_of_goods')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row" id="for_flc">
                            <div class="col-md-5 mb-3">
                                <input type="text" class="form-control @error('no_of_containers') is-invalid @enderror"
                                value="{{ $quotation->no_of_containers }}" placeholder="No of containers" name="no_of_containers">
                                @error('no_of_containers')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-5 mb-3">
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="container_size">
                                    <option>Container size</option>
                                    <option value="20f-dc <?php echo ($quotation->container_size == '20f-dc') ? 'selected="selected"' : ''; ?> ">20' Dry Cargo</option>
                                    <option value="40f-dc <?php echo ($quotation->container_size == '40f-dc') ? 'selected="selected"' : ''; ?> ">40' Dry Cargo</option>
                                    <option value="40f-hdc <?php echo ($quotation->container_size == '40f-hdc') ? 'selected="selected"' : ''; ?> ">40' add-high Dry Cargo</option>
                                    <option value="45f-hdc <?php echo ($quotation->container_size == '45f-hdc') ? 'selected="selected"' : ''; ?> ">45' add-high Dry Cargo</option>
                                    <option value="20f-ot <?php echo ($quotation->container_size == '20f-ot') ? 'selected="selected"' : ''; ?> ">20' Open Top</option>
                                    <option value="40f-ot <?php echo ($quotation->container_size == '40f-ot') ? 'selected="selected"' : ''; ?> ">40' Open Top</option>
                                    <option value="20f-col <?php echo ($quotation->container_size == '20f-col') ? 'selected="selected"' : ''; ?> ">20' Collapsible</option>
                                    <option value="40f-col <?php echo ($quotation->container_size == '40f-col') ? 'selected="selected"' : ''; ?> ">40' Collapsible</option>
                                    <option value="20f-os <?php echo ($quotation->container_size == '20f-os') ? 'selected="selected"' : ''; ?> ">20' Open Side</option>
                                    <option value="20f-dv <?php echo ($quotation->container_size == '20f-dv') ? 'selected="selected"' : ''; ?> ">20' D.V for Side Floor</option>
                                    <option value="20f-ven <?php echo ($quotation->container_size == '20f-ven') ? 'selected="selected"' : ''; ?> ">20' Ventilated</option>
                                    <option value="20f-gar <?php echo ($quotation->container_size == '20f-gar') ? 'selected="selected"' : ''; ?> ">40' Garmentainer</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <div class="col-auto my-1">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing"
                                        name="isStockable" value="Yes" <?php if($quotation->isStockable == 'Yes') echo 'checked="checked"'; ?>>
                                    <label class="custom-control-label" for="customControlAutosizing">Is
                                        Stockable</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="col-auto my-1">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing2"
                                        name="isDGR" value="Yes" <?php if($quotation->isDGR == 'Yes') echo 'checked="checked"'; ?>>
                                    <label class="custom-control-label" for="customControlAutosizing2">Is DGR</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mt-4"> <b> Shipment Calculations </b> </h5>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div id="if_not_air">
                                <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="calculate_by" value="shipment"
                                    class="custom-control-input" <?php if($quotation->calculate_by == 'shipment') echo 'checked="checked"'; ?>>
                                <label class="custom-control-label" for="customRadioInline1">Calculate by total
                                    shipment</label>
                                </div>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="calculate_by" value="units"
                                    class="custom-control-input" <?php if($quotation->calculate_by == 'units') echo 'checked="checked"'; ?>>
                                <label class="custom-control-label" for="customRadioInline2">Calculate by units</label>
                            </div>
                        </div>
                    </div>

                    <div id="shipment">
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                value="{{ $quotation->quantity }}" placeholder="Quantity" name="quantity" required>
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="number" class="form-control @error('total_weight') is-invalid @enderror"
                                value="{{ $quotation->total_weight }}" placeholder="Gross Weight" name="total_weight" required>
                                @error('total_weight')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="dynamic_fields">
                    @foreach($quotation->pallets as $pallet)
                    <div class="form-row dynamic-field" style="margin: 20px 0px 10px 0px;" id="units-{{ $loop->iteration }}">
                        <label for="" style="font-weight: bold;">Pallet#{{ $loop->iteration }}</label>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <!-- <label for="">Dimensions</label> -->
                                <input type="number" class="form-control @error('l') is-invalid @enderror"
                                    id="validationServer04" placeholder="length" name="l[]" value="{{ $pallet['length'] }}" required>
                                @error('l')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="number" class="form-control @error('w') is-invalid @enderror"
                                    id="validationServer03" placeholder="width" name="w[]" value="{{ $pallet['width'] }}" required>
                                @error('w')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="number" class="form-control @error('h') is-invalid @enderror"
                                    id="validationServer03" placeholder="height" name="h[]" value="{{ $pallet['height'] }}" required>
                                @error('h')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3 ml-3">
                                <input type="number" class="form-control @error('total_weight_units') is-invalid @enderror"  value="{{ $pallet['volumetric_weight'] }}"
                                    id="validationServer03" placeholder="Weight" name="total_weight_units[]" disabled>
                                @error('total_weight_units')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    @endforeach
                    </div>


                    <div class="form-row" id="dynamic_buttons">
                        <button type="button" class="btn btn-primary btn-sm" id="add-button"
                            style="padding: 0px 15px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                            <!-- <span>Add New</span> -->
                            <i class="fal fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" id="remove-button"
                            style="padding: 0px 15px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                            <!-- <span>Add New</span> -->
                            <i class="fal fa-minus"></i>
                        </button>
                    </div>

                    <hr>
                    <h5 class="mt-4"> <b> Other Info </b> </h5>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            
                            <label for="exampleFormControlTextarea1">Remarks</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="remarks">{{ $quotation->remarks }}</textarea>
                            @error('value_of_goods')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="col-auto my-1">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing3"
                                        name="isClearanceReq" value="Yes" <?php if($quotation->isClearanceReq == 'Yes') echo 'checked="checked"'; ?>>
                                    <label class="custom-control-label" for="customControlAutosizing3">Required Customs
                                        Clearance?</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Update Quotation</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_scripts')
<script>
    $(document).ready(function() 
    {
        
        // Dynamic changes
        $(document).on('keyup', "input[name^='l'], input[name^='w'], input[name^='h']", function() 
        {
            $el = $(this);
            $unit_num = $el.parent().parent().parent();
            console.log($unit_num);
            if($unit_num.find("input[name^='l']").val() && $unit_num.find("input[name^='w']").val()
            && $unit_num.find("input[name^='h']").val())
            {   
                var l = $unit_num.find("input[name^='l']").val();
                var w = $unit_num.find("input[name^='w']").val();
                var h = $unit_num.find("input[name^='h']").val();
                var total_weight = (l * w * h) / 6000;
                $unit_num.find("input[name^='total_weight_units']").val(total_weight.toFixed(2));
            }
        });
        
        $('.dynamic-field').hide();
        $('#dynamic_buttons').hide();
        $(".require").prop('required', false);
        $('#shipment').hide();
        $('#exw').hide();
        $('#units').hide();
        $('#for_flc').hide();

        var trans_type = {!! json_encode($quotation->transportation_type) !!};
        var calculated_by = {!! json_encode($quotation->calculate_by) !!};
        var type = {!! json_encode($quotation->type) !!};
        var incoterms = {!! json_encode($quotation->incoterms) !!};
        if(incoterms == 'EXW')
        {
            $('#exw').show();
        }
        if(calculated_by == 'units')
        {
            $('#dynamic_buttons').show();
            $('.dynamic-field').show();
            $(".require").prop('required', true);

            $('#shipment').hide();
            $("input[name=quantity]").prop('required', false);
            $("input[name=total_weight]").prop('required', false);
        }
        else
        {
            $('.dynamic-field').hide();
            $('#dynamic_buttons').hide();
            $('#shipment').show();

            $(".require").prop('required', false);
        }
        if(type == 'fcl')
        {
            $('#for_flc').show();
        }
        if(trans_type == 'ocean')
        {
            $('#type_of_shipment').empty();
            $("#type_of_shipment").append(new Option("LCL", "lcl"));
            $("#type_of_shipment").append(new Option("FCL", "fcl"));
            if(type == 'fcl')
            {}
            else
            {}
        }
        else
        {
            $('#type_of_shipment').empty();
            $("#type_of_shipment").append(new Option("AIR", "air"));
        }

        $("#transportation_type").change(function()
        {
            if($(this).find(':selected').val() == 'ocean')
            {
                $('#if_not_air').show();
                $('#type_of_shipment').empty();
                $("#type_of_shipment").append(new Option("LCL", "lcl"));
                $("#type_of_shipment").append(new Option("FCL", "fcl"));
            }
            else if($(this).find(':selected').val() == 'air')
            {
                $('#if_not_air').hide();
                $('#for_flc').hide();
                $('#type_of_shipment').empty();
                $("#type_of_shipment").append(new Option("AIR", "air"));
            }
        });

        // On calculation radio button clicks
        $('input:radio').change(function () 
        {
            var el = $(this).val();
            if (el == 'units') {
                $('#dynamic_buttons').show();
                $('.dynamic-field').show();
                $(".require").prop('required', true);

                $('#shipment').hide();
                $("input[name=quantity]").prop('required', false);
                $("input[name=total_weight]").prop('required', false);
            } else {
                $('.dynamic-field').hide();
                $('#dynamic_buttons').hide();
                $('#shipment').show();

                $(".require").prop('required', false);
            }
        });
        
        // Live results on calculations
        $("input[name=quantity_units], input[name=total_weight_units], input[name=l], input[name=w], input[name=h]" ).keyup(function() 
        { 
            console.log('123');
            var quantity = $('input[name=quantity_units]').val() ? parseFloat( $('input[name=quantity_units]').val() ) : 1;
            var l = $('input[name=l]').val() ? parseFloat( $('input[name=l]').val() ) : 1;
            var w = $('input[name=w]').val() ? parseFloat( $('input[name=w]').val() ) : 1;
            var h = $('input[name=h]').val() ? parseFloat( $('input[name=h]').val() ) : 1;
            
            var total_weight = (l*w*h)/6000 * quantity;
            $('input[name=total_weight_units]').val(total_weight);
            // $("#kg").text(total_weight);
            // $("#pcs").text(quantity);
        });

        // FCL options
        $("#type_of_shipment").change(function () {
            if ($(this).find(':selected').val() == 'fcl') {
                $('#for_flc').show();
            } else {
                $('#for_flc').hide();
            }
        });

        // On Incoterms button clicks
        $('#incoterms').change(function () {
            var el = $(this).val();
            console.log(el);
            if (el == 'EXW') {
                $('#exw').show();
                $("input[name=pickup_address]").prop('required', true);
                $("input[name=final_destination_address]").prop('required',
                    true);
            } else {
                $('#exw').hide();
                $("input[name=pickup_address]").prop('required', false);
                $("input[name=final_destination_address]").prop('required',
                    false);
            }
        });

    });

    $(function () {
        $('input[name="ready_to_load_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: parseInt(moment().format('YYYY'), 10),
            autoApply: true,
            maxYear: 2050,
            locale: {
                format: 'D-M-YYYY'
            }
        });
    });

</script>

<!-- Add dynamic input fields -->
<script>
    $(document).ready(function () {
        var buttonAdd = $("#add-button");
        var buttonRemove = $("#remove-button");
        var className = ".dynamic-field";
        var count = 0;
        var field = "";
        var maxFields = 50;

        function totalFields() {
            return $(className).length;
        }

        function addNewField() {
            count = totalFields() + 1;
            field = $("#units-1").clone();
            field.attr("id", "units-" + count);
            field.children("label").text("Pallet# " + count);
            field.find("input").val("");
            $(className + ":last").after($(field));
        }

        function removeLastField() {
            if (totalFields() > 1) {
                $(className + ":last").remove();
            }
        }

        function enableButtonRemove() {
            if (totalFields() === 2) {
                buttonRemove.removeAttr("disabled");
                buttonRemove.addClass("shadow-sm");
            }
        }

        function disableButtonRemove() {
            if (totalFields() === 1) {
                buttonRemove.attr("disabled", "disabled");
                buttonRemove.removeClass("shadow-sm");
            }
        }

        function disableButtonAdd() {
            if (totalFields() === maxFields) {
                buttonAdd.attr("disabled", "disabled");
                buttonAdd.removeClass("shadow-sm");
            }
        }

        function enableButtonAdd() {
            if (totalFields() === (maxFields - 1)) {
                buttonAdd.removeAttr("disabled");
                buttonAdd.addClass("shadow-sm");
            }
        }

        buttonAdd.click(function () {
            addNewField();
            enableButtonRemove();
            disableButtonAdd();
        });

        buttonRemove.click(function () {
            removeLastField();
            disableButtonRemove();
            enableButtonAdd();
        });
    });

</script>
@endsection