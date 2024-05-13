<div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
    {{--    {{dd($customer_types)}} --}}
    {{-- +++++++++++++ customer_type_id +++++++++++++ --}}
    <div class=" col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
        style="position: relative;z-index: 4;">
        {!! Form::label('customer_type_id', __('lang.customer_type') . '*', [
            'class' => 'mb-0',
        ]) !!}
        <div class="input-wrapper width-full">
            {!! Form::select('customer_type_id', $customer_types, null, [
                'class' => 'form-select',
                'required',
                'placeholder' => __('lang.please_select'),
                'wire:model' => 'add_customer.customer_type_id',
            ]) !!}
        </div>
        @error('customer_type_id')
            <label class="text-danger error-msg">{{ $message }}</label>
        @enderror
    </div>
    {{-- +++++++++++++ name +++++++++++++ --}}
    <div
        class=" col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        {!! Form::label('name', __('lang.name'), [
            'class' => 'mb-0',
        ]) !!}
        <div class="input-wrapper width-full">
            {!! Form::text('name', null, [
                'class' => 'form-control  m-0 initial-balance-input width-full required',
                'wire:model' => 'add_customer.name',
            ]) !!}
        </div>
        @error('name')
            <label class="text-danger error-msg">{{ $message }}</label>
        @enderror
    </div>

    {{-- +++++++++++++++++++++++ min_amount_in_dollar +++++++++++++++++++++++ --}}
    <div
        class="dollar-cell col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        <label class="mb-0" for="min_amount_in_dollar">@lang('lang.min_amount_in_dollar')</label>
        <div class="input-wrapper width-full">
            <input type="number" class="form-control  m-0 initial-balance-input width-full" name="min_amount_in_dollar"
                id="min_amount_in_dollar" />
        </div>
    </div>
    {{-- +++++++++++++++++++++++ max_amount_in_dollar +++++++++++++++++++++++ --}}
    <div
        class="dollar-cell col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        <label class="mb-0" for="max_amount_in_dollar">@lang('lang.max_amount_in_dollar')</label>
        <div class="input-wrapper width-full">
            <input type="number" class="form-control  m-0 initial-balance-input width-full "
                name="max_amount_in_dollar" id="max_amount_in_dollar" />
        </div>
    </div>
    {{-- +++++++++++++++++++++++ min_amount_in_dinar +++++++++++++++++++++++ --}}
    <div
        class=" col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        <label class="mb-0" for="min_amount_in_dinar">@lang('lang.min_amount_in_dinar')</label>
        <div class="input-wrapper width-full">
            <input type="number" class="form-control  m-0 initial-balance-input width-full " name="min_amount_in_dinar"
                id="min_amount_in_dinar" />
        </div>
    </div>
    {{-- +++++++++++++++++++++++ max_amount_in_dinar +++++++++++++++++++++++ --}}
    <div
        class=" col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        <label class="mb-0" for="max_amount_in_dinar">@lang('lang.max_amount_in_dinar')</label>
        <div class="input-wrapper width-full">
            <input type="number" class="form-control  m-0 initial-balance-input width-full " name="max_amount_in_dinar"
                id="max_amount_in_dinar" />
        </div>
    </div>
    {{-- +++++++++++++++++++++++ balance_in_dollar +++++++++++++++++++++++ --}}
    <div
        class="dollar-cell col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        <label class="mb-0" for="balance_in_dollar">@lang('lang.balance_in_dollar')</label>
        <div class="input-wrapper width-full">
            <input type="text" class="form-control  m-0 initial-balance-input width-full " name="balance_in_dollar"
                id="balance_in_dollar" />
        </div>
    </div>
    {{-- +++++++++++++++++++++++ balance_in_dinar +++++++++++++++++++++++ --}}
    <div
        class=" col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        <label class="mb-0" for="balance_in_dinar">@lang('lang.balance_in_dinar')</label>
        <div class="input-wrapper width-full">
            <input type="text" class="form-control  m-0 initial-balance-input width-full " name="balance_in_dinar"
                id="balance_in_dinar" />
        </div>
    </div>
    {{-- ++++++++++++++++ countries selectbox : الدولة : (countries table) +++++++++++++++++ --}}
    <div class=" col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
        style="position: relative;z-index: 4;">
        <label class="mb-0" for="country-dd">@lang('lang.country')</label>
        <div class="input-wrapper width-full">
            <select id="country-dd" name="country" class="form-control" disabled>
                <option value="{{ $countryId }}">
                    {{ $countryName }}
                </option>
            </select>
        </div>
    </div>
    {{-- ++++++++++++++++ state selectbox : المحافظة : (states table) +++++++++++++++++ --}}
    <div class=" col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif "
        style="position: relative;z-index: 4;">

        <label class="mb-0" for="state-dd">@lang('lang.state')</label>
        <div class="input-wrapper width-full">
            <select id="state-dd" name="state_id" class="form-select select2">
                @php
                    $states = \App\Models\State::where('country_id', $countryId)->get(['id', 'name']);
                @endphp
                @foreach ($states as $state)
                    <option value="{{ $state->id }}">
                        {{ $state->name }}
                    </option>
                @endforeach

            </select>
        </div>
    </div>

    {{-- ++++++++++++++++ regions selectbox : المناطق : (cities table) +++++++++++++++++ --}}
    <div class=" col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
        style="position: relative;z-index: 4;">
        <label class="mb-0" for="city-dd">@lang('lang.regions')</label>
        <div class="input-wrapper width-full">

            <select id="city-dd" name="city_id" class="form-select select2"></select>
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" id="cities_id" data-target="#createRegionModal">
                        <i class="fas fa-plus"></i>
                    </button> --}}
            {{--  --}}
        </div>
    </div>
    {{-- ++++++++++++++++ quarter selectbox : الاحياء +++++++++++++++++ --}}
    <div class=" col-6 col-md-3 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
        style="position: relative;z-index: 4;">
        <label class="mb-0" for="quarters_id">@lang('lang.quarters')</label>
        <div class="input-wrapper width-full">
            <select id="quarter-dd" class="form-select select2" name="quarter_id"></select>
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" id="add_quarters_btn_id" data-target="#createQuarterModal">
                        <i class="fas fa-plus"></i>
                    </button> --}}
        </div>
    </div>
    {{-- +++++++++++++ phone +++++++++++++ --}}
    <div
        class="col-md-6 mb-2 px-5 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft">
        <div class="m-0 " style="width: 100%">
            <table class="bordered m-0" style="width: 100%">
                <thead class="phone_thead">
                    <tr>
                        <th style="background: transparent !important;color: black !important;padding: 0!important"
                            class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                            <label class="mb-0">
                                @lang('lang.phone')
                            </label>
                        </th>
                    </tr>
                </thead>
                <tbody class="phone_tbody">
                    <tr>
                        <td class="col-md-12 p-0 mb-2">
                            <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                                style="width: 100%">
                                {!! Form::text('phone[]', null, [
                                    'class' => 'form-control required initial-balance-input m-0 width-full',
                                    'style' => 'flex-grow: 1',
                                ]) !!}
                                @error('phone')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror

                                {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                <a href="javascript:void(0)"
                                    class="add-button d-flex justify-content-center mb-0 align-items-center text-decoration-none  addRow"
                                    style="margin-bottom: 10px;" type="button" id="submit-btn">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                    </tr>


                </tbody>
            </table>
        </div>
    </div>
    {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
    <div
        class=" col-md-6 px-5 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft">

        <table class="bordered m-0" style="width: 100%">
            <thead class="email_thead">
                <tr>
                    <th style="background: transparent !important;color: black !important;padding: 0!important;"
                        class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                        <label class="mb-0">
                            <span class="text-danger">*</span>@lang('lang.email')
                        </label>
                    </th>
                </tr>
            </thead>
            <tbody class="email_tbody">
                <tr>
                    <td class="col-md-12 p-0 mb-2">
                        <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                            style="width: 100%">
                            <input type="text" class="form-control  initial-balance-input m-0" width="100%;"
                                style="flex-grow: 1" placeholder="@lang('lang.email')" name="email[]" value=""
                                required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                            <a href="javascript:void(0)"
                                class="add-button d-flex justify-content-center align-items-center mb-0 text-decoration-none  addRow_email"
                                type="button">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>

                </tr>
            </tbody>
        </table>
    </div>
    {{-- +++++++++++++ address +++++++++++++ --}}
    <div
        class=" col-md-12 flex-column col-md-3 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        {!! Form::label('address', __('lang.address'), [
            'class' => 'mb-0',
        ]) !!}
        <div class="width-full" style="height: 100px;border-radius: 9px">
            {!! Form::textarea('address', null, [
                'class' => 'form-control ',
                'style' => ' width: 100%;height:100%;background-color:#dedede',
                'rows' => '4',
                'wire:model' => 'add_customer.address',
            ]) !!}
        </div>
        @error('address')
            <label class="text-danger error-msg">{{ $message }}</label>
        @enderror
    </div>
    {{--    <input type="hidden" name="quick_add" value="{{ $quick_add }}"> --}}
</div>
@push('js')
    <script src="{{ asset('js/product/customer.js') }}"></script>
    {{-- +++++++++++++++++++++++++++++++ Add New Row in phone ++++++++++++++++++++++++ --}}
    <script>
        $(document).ready(function() {
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
                    data: {
                        state_id: idState,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#city-dd').html('<option value="">Select State</option>');
                        $.each(response.cities, function(index, val) {
                            $('#city-dd').append('<option value="' + val.id + '">' + val
                                .name + '</option>')
                        });
                    }
                })
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
                    data: {
                        city_id: idCity,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log("Quarter = " + response.quarters);
                        $('#quarter-dd').html('<option value="">Select Quarter</option>');
                        $.each(response.quarters, function(index, val) {
                            $('#quarter-dd').append('<option value="' + val.id + '">' +
                                val.name + '</option>')
                        });
                    }
                })
            });
            // +++++++++++++++++++++++++++++++ Add New Row in email ++++++++++++++++++++++++
            $('.email_tbody').on('click', '.addRow_email', function() {
                console.log('new Email inputField was added');
                var tr = `<tr>
                            <td class="col-md-12 p-0">
                                  <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                            style="width: 100%">
                                <input  type="text"  class=" initial-balance-input m-0"
                            width="100%"  style="flex-grow: 1" placeholder="@lang('lang.email')" name="email[]"
                                        value="" required >
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                <a href="javascript:void(0)" class="add-button d-flex justify-content-center align-items-center text-decoration-none  deleteRow_email">-</a>

</div>
                        </td>
                    </tr>`;
                $('.email_tbody').append(tr);
            });
            $('.email_tbody').on('click', '.deleteRow_email', function() {
                $(this).parent().parent().remove();
            });
            // +++++++++++++++++++++++++++++++ Add New Row in phone ++++++++++++++++++++++++
            $('.phone_tbody').on('click', '.addRow', function() {
                console.log('new phone inputField was added');
                var tr = `<tr>
                            <td class="col-md-12 p-0 mb-2">
                                 <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                            style="width: 100%">
                                <input type="text" name="phone[]"  class=" initial-balance-input m-0"  width="100%;" style="flex-grow: 1" placeholder="Enter phone number" />

                                <a href="javascript:void(0)" class="add-button d-flex justify-content-center align-items-center text-decoration-none deleteRow">-</a>
                            </div>
                        </td>
                    </tr>`;
                $('.phone_tbody').append(tr);
            });
            $('.phone_tbody').on('click', '.deleteRow', function() {
                $(this).parent().parent().remove();
            });
        });
    </script>
@endpush
