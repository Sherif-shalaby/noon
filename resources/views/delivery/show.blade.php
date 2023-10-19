@extends('layouts.app')
@section('title', __('lang.add_customers'))
@push('css')
<style>
/* Set the size of the div element that contains the map */
#map {
    height: 400px; /* The height is 400 pixels */
    width: 100%; /* The width is the width of the web page */
}
</style>
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.view_plan')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('delivery_plan.plansList') }}">@lang('lang.plans')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.view_plan')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('delivery_plan.plansList')}}" class="btn btn-primary">
                        @lang('lang.plans')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start row -->
    <div class="row d-flex justify-content-center">
        {{-- {{ dd($countryName) }}  --}}
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">
                <div class="container-fluid">
                    <div class="row pt-5">
                       

                        {{-- <input type="hidden" class="form-control" name="delivery_id"
                         value="{{$delivery_plan->id}}" > --}}
                        {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                       
                       
                        <div id='customers-checkboxes' class="col-md-6" style="margin-bottom: 20px">
                            @foreach ($delivery_plans as $delivery_plan)
                                <div class="form-check" style="margin-bottom: 10px">
                                    <button class="btn btn-success btn-sm sign-in-btn" @if($delivery_plan->signed_at != null) disabled @endif data-customer-id="{{$delivery_plan->customers_id}}" data-delivery-location-id="{{$delivery_plan->delivery_location_id}}">Sign In</button>

                                    {{-- <input class="form-check-input" type="checkbox" name="customer" value="{{$delivery_plan->customers_id}}"> --}}
                                    <label class="form-check-label">{{$delivery_plan->customers->name}}</label>
                                    <button class="btn btn-primary btn-sm sign-out-btn"@if($delivery_plan->submitted_at != null) disabled @endif data-customer-id="{{$delivery_plan->customers_id}}" data-delivery-location-id="{{$delivery_plan->delivery_location_id}}">Sign Out</button>
                                </div>
                            @endforeach
                        </div>


                    </div>
                    <div id="map"></div>

                    {{-- <div class="row pb-5">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                        </div>
                    </div> --}}
                </div>
                {{-- {!! Form::close() !!} --}}
            </div>
          
        </div>
    </div>
@endsection
@push('js')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKqlJypSBrs_U2e1RfhpyM4CQ87hiVzCM&callback=initMap"></script>

<script>
(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
    ({key: "AIzaSyBKqlJypSBrs_U2e1RfhpyM4CQ87hiVzCM", v: "beta"});
</script>

<script>


   
    var map; // Declare map variable in an outer scope
    var bounds;
    
    // Function to initialize the map and add markers
    function initMap() {
        const initialPosition = { lat: 33.312805, lng: 44.361488 };
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: initialPosition
        });

        // Initialize bounds object
        bounds = new google.maps.LatLngBounds();

        @foreach($delivery_plans as $delivery_plan)
            var deliveryPlanData = {!! json_encode($delivery_plan) !!};

            // Check if customer and address are not null
            @if($delivery_plan->customers && $delivery_plan->customers->address)
                var address = "{{$delivery_plan->customers->address}}";
                console.log("Google Maps URL:", address);
                var matches = address.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
                console.log("Regex Matches:", matches);

                // Check if matches is not null and has correct length
                if (matches && matches.length >= 3) {
                    var lat = parseFloat(matches[1]);
                    var lng = parseFloat(matches[2]);

                    // Create a LatLng object
                    var latLng = new google.maps.LatLng(lat, lng);

                    // Add marker to the map
                    var marker = new google.maps.Marker({
                        position: latLng,
                        map: map,
                        title: "{{$delivery_plan->customers->name}}" // Marker title
                    });
                    console.log(marker);

                    // Extend bounds to include this marker's position
                    bounds.extend(marker.getPosition());
                } else {
                    console.log("Invalid Google Maps URL:", address);
                }
            @else
                console.log("No valid address found for customer: {{$delivery_plan->customers->name}}");
            @endif
        @endforeach

        // Fit the map to the bounds to ensure all markers are visible
        // map.fitBounds(bounds);
    }

    $(document).ready(function() {
        // Handle sign in button click
        $('.sign-in-btn').on('click', function() {
            var customerId = $(this).data('customer-id');
            var deliveryLocationId = $(this).data('delivery-location-id'); // Get the delivery location ID
            $.ajax({
                type: 'POST',
                url: '/delivery_plan/sign-in', // Replace this with your sign-in endpoint
                data: { customer_id: customerId,
                        delivery_location_id: deliveryLocationId, // Include the delivery location ID in the request
                        sign_in : 'sign_in' },
                success: function(response) {
                    // Handle success response if needed
                    console.log('Sign In Successful');
                },
                error: function(error) {
                    // Handle error if needed
                    console.error('Error occurred while signing in');
                }
            });
        });

        // Handle sign out button click
        $('.sign-out-btn').on('click', function() {
            var customerId = $(this).data('customer-id');
            var deliveryLocationId = $(this).data('delivery-location-id'); // Get the delivery location ID
            $.ajax({
                type: 'POST',
                url: '/delivery_plan/sign-out', // Replace this with your sign-out endpoint
                data: { customer_id: customerId,
                    delivery_location_id: deliveryLocationId, 
                        sign_out :'sign_out' },
                success: function(response) {
                    // Handle success response if needed
                    console.log('Sign Out Successful');
                },
                error: function(error) {
                    // Handle error if needed
                    console.error('Error occurred while signing out');
                }
            });
        });
    });


</script>
@endpush
