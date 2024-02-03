@extends('layouts.app')
@section('title', __('lang.add_plan'))

@push('css')
    <style>
        /* Set the size of the div element that contains the map */
        #map {
            height: 400px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.add_plan')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('delivery_plan.plansList') }}">/ @lang('lang.plans')</a>
    </li>
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.edit_plan')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a href="{{ route('delivery_plan.plansList') }}" class="btn btn-primary">
            @lang('lang.plans')
        </a>
    </div>
@endsection

@section('content')
    <!-- Start row -->
    <div class="row d-flex justify-content-center">
        {{-- {{ dd($countryName) }}  --}}
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card mb-0 p-2">
                {!! Form::open([
                    'route' => ['delivery.update', $plan->id],
                    'method' => 'put',
                    'enctype' => 'multipart/form-data',
                    'id' => 'customer-form',
                ]) !!}
                <div class="container-fluid">
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="animation-delay: 1.15s">
                            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-1 mb-0 "
                                style='font-size: 12px;font-weight: 500;' for="date">@lang('lang.date')</label>
                            <div class="input-wrapper">
                                <input type="date" class="form-control initial-balance-input width-full" name="date"
                                    id="date" placeholder="@lang('lang.date')" value="{{ $plan->date }}">
                            </div>
                        </div>


                        {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                        <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="animation-delay: 1.15s">
                            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-1 mb-0 "
                                style='font-size: 12px;font-weight: 500;' for="country-dd">@lang('lang.country')</label>
                            <div class="input-wrapper">
                                <select id="country-dd" name="country" class="form-control" disabled>
                                    <option value="{{ $countryIdCurrent ? $countryIdCurrent->id : $countryId }}">
                                        {{ $countryIdCurrent ? $countryIdCurrent->name : $countryName }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- ++++++++++++++++ state selectbox +++++++++++++++++ --}}
                        <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="animation-delay: 1.15s">

                            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-1 mb-0 "
                                style='font-size: 12px;font-weight: 500;' for="state-dd">@lang('lang.state')</label>
                            <div class="input-wrapper">
                                <select id="state-dd" name="state_id" class="form-control">
                                    @php
                                        $states = \App\Models\State::where('country_id', $countryId)->get(['id', 'name']);
                                    @endphp
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ $state->id == $stateId->id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- ++++++++++++++++ city selectbox +++++++++++++++++ --}}
                        <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="animation-delay: 1.15s">

                            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mb-0 "
                                style='font-size: 12px;font-weight: 500;' for="city-dd">@lang('lang.city')</label>
                            <div class="input-wrapper">
                                <select id="city-dd" name="city_id" class="form-control"
                                    data-selected-city="{{ $cityId->id }}"></select>
                            </div>
                        </div>


                        <div id='customers-checkboxes'
                            class="col-md-6 d-flex @if (app()->isLocale('ar')) justify-content-evenly flex-row-reverse @else flex-row  justify-content-evenly @endif"
                            style="margin-bottom: 20px">

                        </div>


                    </div>
                    <div id="map"></div>

                    <div class="row pb-5">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection
@push('js')
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKqlJypSBrs_U2e1RfhpyM4CQ87hiVzCM&callback=initMap"></script>

    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                d[l](f, ...n))
        })
        ({
            key: "AIzaSyBKqlJypSBrs_U2e1RfhpyM4CQ87hiVzCM",
            v: "beta"
        });
    </script>

    <script>
        function fetchCustomersByCity(cityId) {
            $.ajax({
                url: "/api/fetch-customers-by-city",
                type: 'POST',
                dataType: 'json',
                data: {
                    city_id: cityId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // console.log(response.customers);
                    // Add customers as checkboxes
                    $.each(response.customers, function(index, customer) {
                        var checkbox = '<div class="form-check">';
                        checkbox +=
                            '<input class="form-check-input" type="checkbox" name="customers[]" value="' +
                            customer.id + '"';

                        // Check the checkbox if the customer ID is in the plan's customers list
                        if ($.inArray(customer.id, {!! json_encode($customerIds) !!}) !== -1) {
                            checkbox += ' checked'; // Add the 'checked' attribute
                        }

                        checkbox += '>';
                        checkbox += '<label class="form-check-label">' + customer.name + '</label>';
                        checkbox += '</div>';
                        $('#customers-checkboxes').append(checkbox);
                    });

                    // Add markers for customer locations
                    response.customers.forEach(function(customer) {
                        var marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(customer.latitude),
                                lng: parseFloat(customer.longitude)
                            },
                            map: map,
                            title: customer.name // Display customer name as marker title
                        });
                        console.log(marker);
                        // Extend bounds with marker position
                        bounds.extend(marker.getPosition());
                    });
                }
            });
        }
        $(document).ready(function() {
            $('#state-dd').trigger('change');
            // Trigger change event to fetch customers for the initially selected city
            $('#city-dd').trigger('change');
            // Trigger fetchCustomersByCity function when the page loads with an existing city ID
            var existingCityId = $('#city-dd').data('selected-city');
            console.log(existingCityId);
            if (existingCityId) {
                fetchCustomersByCity(existingCityId);
            }
            $('#city-dd').change(function(event) {
                var cityId = this.value;
                if (cityId) {
                    fetchCustomersByCity(cityId);
                    $('#customers-checkboxes').html(''); // Clear existing checkboxes
                }

            });


        });
        // ================ state selectbox ================
        $('#state-dd').change(function(event) {
            var idState = this.value;
            var selectedCityId = $('#city-dd').data(
                'selected-city'); // Get the selected city ID from data attribute
            $('#city-dd').html('');
            $.ajax({
                url: "/api/fetch-cities",
                type: 'POST',
                dataType: 'json',
                data: {
                    state_id: idState,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#city-dd').html('<option value="">Select City</option>');
                    $.each(response.cities, function(index, val) {
                        var isSelected = (selectedCityId == val.id) ? 'selected' : '';
                        $('#city-dd').append('<option value="' + val.id + '" ' + isSelected +
                            '>' + val.name + '</option>');
                    });
                }
            });
        });

        var map; // Declare map variable in an outer scope
        var bounds;
        // Function to initialize the map and add markers
        function initMap() {
            const position = {
                lat: 33.312805,
                lng: 44.361488
            };
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: position
            });
            // Initialize bounds object
            bounds = new google.maps.LatLngBounds();

        }
    </script>
@endpush
