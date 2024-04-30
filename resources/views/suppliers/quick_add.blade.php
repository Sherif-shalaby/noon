
<div class="modal fade add-supplier"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => route('suppliers.store'), 'method' => 'post','id' => isset($quick_add)&&$quick_add? 'quick_add_supplier_form' : 'add_supplier' ]) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add_supplier')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    {{-- {{ dd($countryId);  }} --}}
                    {{-- ++++++++++++++++++++++ name ++++++++++++++++++++++++ --}}
                    <div class="col-md-4 ">
                        <div class="form-group ">
                            <label for="name">@lang('lang.name')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
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
                    {{-- ++++++++++++++++++++++ company_name ++++++++++++++++++++++++ --}}
                    <div class="col-md-4 ">
                        <div class="form-group ">
                            <label for="name">@lang('lang.company_name')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
                                       class="form-control"
                                       placeholder="@lang('lang.company_name')"
                                       name="company_name"
                                       value="{{ old('company_name') }}" >
                                @error('company_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++++++++++ email ++++++++++++++++++++++++ --}}
                    {{-- <div class="col-md-6 ">
                        <div class="form-group ">
                            <label for="email">@lang('lang.email')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
                                       class="form-control"
                                       placeholder="@lang('lang.email')"
                                       name="email[]"
                                       value="{{ old('email') }}" >
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    {{-- +++++++++++++++++++++++++++++++ exchange_rate ++++++++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label for="exchange_rate">@lang('lang.exchange_rate')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="number"
                                       class="form-control"
                                       placeholder="@lang('lang.exchange_rate')"
                                       name="exchange_rate"
                                       style="border-color:#aaa"
                                       value="{{ old('exchange_rate') }}" >
                                @error('exchange_rate')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- +++++++++++++++++ start_date +++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label for="start_date">@lang('lang.start_date')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="date"
                                       class="form-control"
                                       placeholder="@lang('lang.start_date')"
                                       name="start_date"
                                       style="border-color:#aaa"
                                       value="{{ date('Y-m-d') }}" >
                                @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- +++++++++++++++++ end_date +++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label for="end_date">@lang('lang.end_date')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="date"
                                       class="form-control"
                                       placeholder="@lang('lang.end_date')"
                                       name="end_date"
                                       style="border-color:#aaa"
                                       value="{{ old('end_date') }}" >
                                @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- +++++++++++++++++++++++++++++++ postal_code ++++++++++++++++++++++++ --}}
                    <div class="col-md-4 ">
                        <div class="form-group ">
                            <label for="postal_code">@lang('lang.postal_code')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
                                       class="form-control"
                                       placeholder="@lang('lang.postal_code')"
                                       name="postal_code"
                                       value="{{ old('postal_code') }}" >
                                @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++++++++++ address ++++++++++++++++++++++++ --}}
                    {{-- <div class="col-md-4 ">
                        <div class="form-group ">
                            <label for="address">@lang('lang.address')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <textarea class="form-control" placeholder="@lang('lang.address')" name="address"value="{{ old('address') }}" ></textarea>
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    {{-- +++++++++++++++++++++++++++++++ city ++++++++++++++++++++++++ --}}
                    {{-- <div class="col-md-4">
                        <div class="form-group ">
                            <label for="city">@lang('lang.city')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
                                       class="form-control"
                                       placeholder="@lang('lang.city')"
                                       name="city"
                                       value="{{ old('city') }}" >
                                @error('city')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    {{-- ========================== country ==================== --}}
                    {{-- <div class="col-md-4">
                        <div class="form-group ">
                            <label for="country">@lang('lang.country')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
                                       class="form-control"
                                       placeholder="@lang('lang.country')"
                                       name="country"
                                       value="{{ old('country') }}" >
                                @error('country')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    {{-- +++++++++++++++++++++++ owner_debt_in_dinar +++++++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <label for="owner_debt_in_dinar">@lang('lang.owner_debt_in_dinar')</label>
                        <input type="number" class="form-control" style="border-color:#aaa" name="owner_debt_in_dinar" id="owner_debt_in_dinar" />
                    </div>
                    {{-- +++++++++++++++++++++++ owner_debt_in_dollar +++++++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <label for="owner_debt_in_dollar">@lang('lang.owner_debt_in_dollar')</label>
                        <input type="number" class="form-control" style="border-color:#aaa" name="owner_debt_in_dollar" id="owner_debt_in_dollar" />
                    </div>
{{--                    --}}{{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
{{--                    <div class="col-md-4">--}}
{{--                        <label for="country-dd">@lang('lang.country')</label>--}}
{{--                        <select id="country-dd" name="country" class="form-control" disabled>--}}
{{--                            <option value="{{ $countryId }}">--}}
{{--                                {{ $countryName }}--}}
{{--                            </option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    --}}{{-- ++++++++++++++++ state selectbox +++++++++++++++++ --}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="state-dd">@lang('lang.state')</label>--}}
{{--                            <select id="state-dd" name="state_id" class="form-control">--}}
{{--                                @php--}}
{{--                                    $states = \App\Models\State::where('country_id', $countryId)->get(['id','name']);--}}
{{--                                @endphp--}}
{{--                                @foreach ( $states as $state)--}}
{{--                                    <option value="{{ $state->id }}">--}}
{{--                                        {{ $state->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    --}}{{-- ++++++++++++++++ city selectbox +++++++++++++++++ --}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="city-dd">@lang('lang.city')</label>--}}
{{--                            <select id="city-dd" name="city_id" class="form-control"></select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group ">
                            <table class="bordered">
                                <thead class="email_thead">
                                <tr>
                                    <th class="text-left" style="font-weight: normal;">
                                        <label class="mb-2">
                                            <span class="text-danger">*</span>@lang('lang.email')
                                        </label>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="email_tbody">
                                <tr>
                                    <td class="col-md-12 p-0">
                                        <div class="select_body d-flex justify-content-between align-items-center" >
                                            <input type="text"
                                                   class="form-control"
                                                   placeholder="@lang('lang.email')"
                                                   name="email[]"
                                                   value="{{ old('email') }}" required >
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td  class="col-md-6">
                                        {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                        <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow_email" type="button">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++++++++++ mobile_number array ++++++++++++++++++++++++ --}}
                    <div class="col-md-4"  style="width: 100%;">
                        <table class="bordered">
                            <thead class="phone_thead">
                            <tr>
                                <th class="text-left" style="font-weight: normal;">
                                    <label class="mb-2">
                                        <span class="text-danger">*</span>@lang('lang.phone_number')
                                    </label>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="phone_tbody">
                            <tr>
                                <td class="col-md-12 p-0">
                                    <div class="select_body d-flex justify-content-between align-items-center" >
                                        <input type="text"
                                               class="form-control"
                                               placeholder="@lang('lang.phone_number')"
                                               name="mobile_number[]"
                                               value="{{ old('mobile_number') }}" required >
                                        @error('mobile_number')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </td>
                                <td  class="col-md-6">
                                    {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                    <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow" type="button">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- ++++++++++++ images ++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('lang.image')</label>
                            <input class="form-control img" name="image"  type="file" accept="image/*" >
                            {{-- <div class="dropzone" id="my-dropzone">
                                <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                            </div> --}}
                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                         {{-- ++++++++++++++++ countries selectbox : الدولة : (countries table) +++++++++++++++++ --}}
                         <div class="col-md-4 mb-3">
                            <label for="country-dd">@lang('lang.country')</label>
                            <select id="country-dd" name="country" class="form-control" disabled>
                                <option value="{{ $countryId }}">
                                    {{ $countryName }}
                                </option>
                            </select>
                        </div>
                        {{-- ++++++++++++++++ state selectbox : المحافظة : (states table) +++++++++++++++++ --}}
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="state-dd">@lang('lang.state')</label>
                                <select id="state-dd" name="state_id" class="form-control select2">
                                    @php
                                        $states = \App\Models\State::where('country_id', $countryId)->get(['id','name']);
                                    @endphp
                                    <option value=""> @lang('lang.please_select')</option>
                                    @foreach ( $states as $state)
                                        <option value="{{ $state->id }}">
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- ++++++++++++++++ regions selectbox : المناطق : (cities table) +++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city-dd">@lang('lang.regions')</label>
                                <div class="d-flex justify-content-center">
                                    <select id="city-dd" name="city_id" class="form-control select2"></select>
                                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" id="cities_id" data-target="#createRegionModal">
                                        <i class="fas fa-plus"></i>
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                        {{-- ++++++++++++++++ quarter selectbox : الاحياء +++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="quarters_id">@lang('lang.quarters')</label>
                                <div class="d-flex justify-content-center">
                                    <select id="quarter-dd" class="form-control select2" name="quarter_id"></select>
                                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" id="add_quarters_btn_id" data-target="#createQuarterModal">
                                        <i class="fas fa-plus"></i>
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button  id="create-supplier-btn" class="btn btn-primary">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
             {{-- ++++++++++++ Quick_Add "city","quarter" Modal ++++++++++++ --}}
             @include('suppliers.partials.quick_add')
        </div>
    </div>
</div>
@push('js')
<script>
       // ++++++++++++++++++++++ Countries , State , Cities Selectbox ++++++++++++++++
    // ================ state selectbox ================
    $('#state-dd').change(function(event) {
        // Capture the selected state value
        var idState = this.value;
        $('#city-dd').html('');
        $.ajax({
            url: "/api/customers/fetch-cities",
            type: 'POST',
            dataType: 'json',
            data: {state_id: idState,_token:"{{ csrf_token() }}"},
            success:function(response)
            {
                $('#city-dd').html('<option value="">Select State</option>');
                $.each(response.cities,function(index, val)
                {
                    $('#city-dd').append('<option value="'+val.id+'">'+val.name+'</option>')
                });
            }
        })
    });
    // ================ city selectbox ================
    // ++++++++++++ store "state_id" in hidden inputField in "cities modal" ++++++++++
    $("#cities_id").on('click', function(){
        var state_id = $("#state-dd").val();
        $("#stateId").val(state_id);
        console.log("+++++++++++++++++++++++++++ "+state_id+" +++++++++++++++++++++++++++");
    });
    // ================ quarter selectbox ================
    $('#city-dd').change(function(event) {
        // Capture the selected city value
        var idCity = this.value;
        $('#quarter-dd').html('');
        $.ajax({
            url: "/api/customers/fetch-quarters",
            type: 'POST',
            dataType: 'json',
            data: {city_id: idCity,_token:"{{ csrf_token() }}"},
            success:function(response)
            {
                console.log("Quarter = "+response.quarters);
                $('#quarter-dd').html('<option value="">Select Quarter</option>');
                $.each(response.quarters,function(index, val)
                {
                    $('#quarter-dd').append('<option value="'+val.id+'">'+val.name+'</option>')
                });
            }
        })
    });
    // ++++++++++++ store "cities_id" in hidden inputField in "quarter modal" ++++++++++
    $("#add_quarters_btn_id").on('click', function(){
        var city_id = $("#city-dd").val();
        $("#cityId").val(city_id);
        console.log("+++++++++++++++++++++++++++ "+city_id+" +++++++++++++++++++++++++++");
    });
</script>
@endpush
