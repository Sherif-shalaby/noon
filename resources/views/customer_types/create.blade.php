<!-- ================== Modal 1 : createCustomerTypesModal ================== -->
<div class="modal fade" id="createCustomerTypesModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('lang.add_customer_type')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'customertypes.store', 'method' => 'post', 'files' => true,'id' =>'customer-type-form' ]) !!}
            <div class="modal-body">
                <div class="form-group ">
                    <label for="name">@lang('lang.name')</label>
                    <div class="select_body d-flex justify-content-between align-items-center" >
                        <input type="text" required
                               class="form-control"
                               placeholder="@lang('lang.name')"
                               name="name"
                               value="{{ old('name') }}" >
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button  class="btn btn-primary btn-sm ml-2" type="button"
                            data-toggle="collapse" data-target="#translation_table_customertype"
                            aria-expanded="false" aria-controls="collapseExample">
                            <i class="fas fa-globe"></i>
                        </button>
                    </div>

                    @include('layouts.translation_inputs', [
                        'attribute' => 'name',
                        'translations' => [],
                        'type' => 'customertype',
                    ])
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button  type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- ================== Modal 2 : createRegionModal ================== -->
<div class="modal fade" id="createRegionModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('lang.add_region')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'customers.storeRegion', 'method' => 'post', 'files' => true,'id' =>'customer-region-form' ]) !!}
            <div class="modal-body">
                <div class="form-group ">
                    {{-- store "state_id" in "hidden inputField" to send it to "storeRegion() method" in CustomerController --}}
                    <input type="hidden" name="state_id" id="stateId" />
                    <label for="name">@lang('lang.name')</label>
                    <div class="select_body d-flex justify-content-between align-items-center" >
                        <input type="text" required
                            class="form-control"
                            placeholder="@lang('lang.name')"
                            name="name"
                            id="cityNameId"
                            value="{{ old('name') }}" >
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button  type="submit" class="btn btn-primary" id="addNewRegion">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- ================== Modal 3 : createQuarterModal ================== -->
<div class="modal fade" id="createQuarterModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('lang.add_quarter')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'customers.storeQuarter', 'method' => 'post', 'files' => true,'id' =>'customer-quarter-form' ]) !!}
            <div class="modal-body">
                <div class="form-group ">
                    {{-- store "city_id" in "hidden inputField" to send it to "storeQuarter() method" in CustomerController --}}
                    <input type="hidden" name="city_id" id="cityId" />
                    <label for="name">@lang('lang.name')</label>
                    <div class="select_body d-flex justify-content-between align-items-center" >
                        <input type="text" required
                            class="form-control"
                            placeholder="@lang('lang.name')"
                            name="name"
                            value="{{ old('name') }}" >
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button  type="submit" class="btn btn-primary" id="addNewQuarter">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CustomerTypeRequest','#customer-type-form'); !!}

<script>
    // $(document).ready(function(){
    //     // $("#addNewRegion").on('click',function(e){
    //     //     e.preventDefault();
    //     //     console.log("0000000000000000000000000000");
    //     //     if( $("#cityNameId").val() )
    //     //     {
    //     //         $.ajax({
    //     //             method:"POST",
    //     //             url:"{{ route('customers.storeRegion') }}",
    //     //             data:{
    //     //                 'name'      : $("#cityNameId").val(),
    //     //                 'state_id'  : $("#stateId").val(),
    //     //                 _token :'{{ csrf_token() }}'
    //     //             },
    //     //             success:function(results)
    //     //             {
    //     //                 console.log(results);
    //     //                 $('#city-dd').html('');
    //     //                 $('#city-dd'+'option').each(function(){
    //     //                     $(this).remove();
    //     //                 });
    //     //                 $.each(results, function(index,value){
    //     //                     $('#city-dd').append('<option value="'+value.id+'">'+value.name+'</option>');
    //     //                 });
    //     //                 // $('#city-dd').addClass('selectpicker').selectpicker("render");
    //     //                 $("#createRegionModal").style("display","none");

    //     //             }
    //     //         });
    //     //     }
    //     // });


    //     // $(document).on("submit", "#customer-region-form", function (e) {
    //     //     console.log("++++++++++++++++++++++ Cities +++++++++++++++++++++");
    //     //     e.preventDefault();
    //     //         var data = $(this).serialize();
    //     //         $.ajax({
    //     //             method: "post",
    //     //             url: $(this).attr("action"),
    //     //             dataType: "json",
    //     //             data: data,
    //     //             success: function (result) {
    //     //                 console.log("First Ajax Request : ",result);
    //     //                 if (result.success) {
    //     //                     Swal.fire("Success", result.msg, "success");
    //     //                     $("#createRegionModal").modal("hide");
    //     //                     var city_id = result.id;
    //     //                     console.log("Outer Second Ajax Request : ",result);
    //     //                     $.ajax({
    //     //                             method: "get",
    //     //                             url: "/customers/get-dropdown-city",
    //     //                             // data: {},
    //     //                             contactType: "html",
    //     //                             success: function (data_html) {
    //     //                                 console.log("Inner Second Ajax Request : ",data_html);
    //     //                                 $("#city-dd").empty().append(data_html[0]);
    //     //                                 $("#city-dd").val(data_html[1]).change();;
    //     //                             },
    //     //                             error: function (e)
    //     //                             {
    //     //                                 console.log("Error", e);
    //     //                             }
    //     //                         });
    //     //                 } else {
    //     //                     Swal.fire("Error", result.msg, "error");
    //     //                 }
    //     //             },
    //     //         });
    //     // });
    // });
</script>
