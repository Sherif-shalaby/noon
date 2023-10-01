<!DOCTYPE html>
<html>
<head>
    <title>Google Map Example</title>
    <style>
        /* Set a height for the map container */
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
<!-- Map container -->
<div id="map"></div>

<!-- Include the Google Maps API with your API key -->
<script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>

<!-- Your JavaScript code for the map goes here -->
<script>
    // Initialize the map
    function initMap() {
        // Create a map object centered at a specific location
        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 40.7128, lng: -74.0060 }, // New York City coordinates
            zoom: 12 // Adjust the zoom level
        });

        // Create a marker and set its position
        var marker = new google.maps.Marker({
            position: { lat: 40.7128, lng: -74.0060 },
            map: map,
            title: 'Marker Title' // Optional: Add a title to the marker
        });
    }
</script>
</body>
</html>
