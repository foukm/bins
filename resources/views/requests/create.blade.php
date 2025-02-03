@extends('main')
@section('content')

<div class="d-flex col-12">
    <div class="d-flex flex-column col-4">
        <h1>Προσθήκη Αιτήματος</h1>
        <form id="locationForm" method="POST" action="{{ route('requests.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Εντολέας:</label>
                <input type="text" id="name" name="name" value="Nikos Papadakis" readonly required>
            </div>
            <div class="form-group">
                <label for="phone">Τηλέφωνο:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="info">Πληροφορίες:</label>
                <textarea id="info" name="info" ></textarea>
            </div>
            <div class="form-group">
                <label for="address">Διεύθυνση:</label>
                <input type="text" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="category">Κατηγορία:</label>
                <select id="category" name="category">
                    <option value="Αλουμίνιο">Αλουμίνιο</option>
                    <option value="Ξύλο">Ξύλο</option>
                    <option value="Γυαλί">Γυαλί</option>
                </select>
            </div>

            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <button type="button" class="btn btn-success btn-search">Αναζήτηση οδού</button>
            <button type="submit" class="btn btn-primary btn-submit" disabled>Καταχώρηση</button>
        </form>
    </div>
    <div id="map"></div>
</div>
@endsection

@push('js')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        var map = L.map('map').setView([37.9838, 23.7275], 6); // Αρχικό κέντρο (Αθήνα)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);


        // Listen for click event on the map
        var currentMarker = null;  // Variable to store the current marker

        async function reverseGeocodeLanLot(lat, lon) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&addressdetails=1&accept-language=el`;

            const response = await fetch(url);
            const data = await response.json();

            if (data && data.address) {
                // Extract relevant address components
                const houseNumber = data.address.house_number || '';
                const streetName = data.address.road || 'N/A';
                const city =  data.address.town || data.address.city || '';
                const address = `${houseNumber} ${streetName}, ${city}`;
                $('.btn-submit').removeAttr('disabled');

                return address;
            }
            return 'Δεν βρέθηκε η διεύθυνση';
        }

        // Listen for click event on the map
        map.on('click', async function(e) {
            var lat = e.latlng.lat;
            var lon = e.latlng.lng;

            // If a marker already exists, move it to the new location
            if (currentMarker) {
                currentMarker.setLatLng([lat, lon]);  // Move the marker
            } else {
                // Otherwise, create a new marker at the clicked location
                currentMarker = L.marker([lat, lon]).addTo(map);
            }

            // Get the address by reverse geocoding the clicked location
            const address = await reverseGeocodeLanLot(lat, lon);

            // Bind popup with the address
            currentMarker.bindPopup("Address: " + address).openPopup();

            // Update the hidden form fields with the new coordinates
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lon;
            document.getElementById("address").value = address; // Optionally fill in the address input
        });

        const iconDefault = L.icon({
            iconUrl: '{{asset('images/bin.png')}}', // Replace with the path to your custom icon image
            iconSize: [32, 32],                      // Adjust icon size if needed
            iconAnchor: [16, 32],                    // Adjust anchor point based on icon size
            popupAnchor: [0, -32]                    // Position popup above the icon
        });
        const iconWood = L.icon({
            iconUrl: '{{asset('images/bin-brown.png')}}', // Replace with the path to your custom icon image
            iconSize: [32, 32],                      // Adjust icon size if needed
            iconAnchor: [16, 32],                    // Adjust anchor point based on icon size
            popupAnchor: [0, -32]                    // Position popup above the icon
        });

        const iconGlass = L.icon({
            iconUrl: '{{asset('images/bin-green.png')}}', // Replace with the path to your custom icon image
            iconSize: [32, 32],                      // Adjust icon size if needed
            iconAnchor: [16, 32],                    // Adjust anchor point based on icon size
            popupAnchor: [0, -32]                    // Position popup above the icon
        });
        const iconAluminium = L.icon({
            iconUrl: '{{asset('images/bin-grey.png')}}', // Replace with the path to your custom icon image
            iconSize: [32, 32],                      // Adjust icon size if needed
            iconAnchor: [16, 32],                    // Adjust anchor point based on icon size
            popupAnchor: [0, -32]                    // Position popup above the icon
        });

        var marker;

        // Γεωκωδικοποίηση για διεύθυνση
        async function geocodeAddress() {
            const address = document.getElementById("address").value;
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${address}&accept-language=el`);
            const data = await response.json();
            if (data.length > 0) {
                const { lat, lon } = data[0];

                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lon;

                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lon]).addTo(map);
                map.setView([lat, lon], 13);

                // Call reverse geocoding to get the exact address
                await reverseGeocode(lat, lon);
            }
        }

        // Reverse geocoding function to get the address from coordinates
        async function reverseGeocode(lat, lon) {
            const addressInput = document.getElementById("address").value; // Get the manually entered address (contains house number)
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&addressdetails=1&extratags=1&namedetails=1`);
            const data = await response.json();

            if (data && data.address) {
                // Get the house number from the manual input if it's available
                const houseNumber = addressInput.split(' ')[0];  // Assuming the house number is the first word in the address input

                let address = addressInput;  // Start with the manually entered address

                // Check if the house number exists in the reverse geocode response
                if (data.address) {
                    address = [
                        data.address.house_number,  // Use house number from reverse geocoding if available
                        data.address.road || '',    // Street name, if available
                        data.address.city || data.address.town || data.address.village || '', // City, town, or village
                        data.address.postcode || '',// Postal code
                    ].filter(Boolean).join(', ');
                    document.getElementById("address").value = address;

                    $('.btn-submit').removeAttr('disabled');
                    // If the house number returned by Nominatim doesn't match the input, prepend the manual house number
                }

                // Update the address field with the detailed address (still preserving user input)
            }
        }

        $('.btn-search').on('click', function (e){
            geocodeAddress();
        })
        //document.getElementById("address").addEventListener("blur", geocodeAddress);
    </script>
@endpush
