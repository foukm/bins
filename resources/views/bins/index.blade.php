@extends('main')
@section('content')
<div class="container col-12 d-flex h-100">

    <div class="col-6">
        <table class = "table table-border data-table">
            <thead>
            <h3 class="box">Κάδοι</h3>
            <tr>
                <th>ID</th>
                <th>Διεύθυνση</th>
                <th>Κατηγορία</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach ($bins as $bin)
                <tr>
                    <td>{{$bin->id}}</td>
                    <td>{{$bin->name}}</td>
                    <td>{{$bin->category}}</td>

                    <td>
                        <a
                            href="{{route ('bin.delete', $bin)}}"
                            class = "btn btn-danger"
                        ><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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

        // Δεδομένα markers
        var markers = @json($bins); // Παράδειγμα Laravel μεταβλητής με δεδομένα
        markers.forEach(function(marker) {
            if(marker.category === 'Αλουμίνιο'){
                L.marker([marker.lan, marker.lot], { icon: iconAluminium }) // Add custom icon here
                    .addTo(map)
                    .bindPopup(marker.name+' : '+marker.category);
            }else if (marker.category === 'Ξύλο'){
                L.marker([marker.lan, marker.lot], { icon: iconWood }) // Add custom icon here
                    .addTo(map)
                    .bindPopup(marker.name+' : '+marker.category);
            }else if (marker.category === 'Γυαλί'){
                L.marker([marker.lan, marker.lot], { icon: iconGlass }) // Add custom icon here
                    .addTo(map)
                    .bindPopup(marker.name+' : '+marker.category);
            }else{
                L.marker([marker.lan, marker.lot], { icon: iconDefault }) // Add custom icon here
                    .addTo(map)
                    .bindPopup(marker.name+' : '+marker.category);
            }
        });

        // Reverse geocoding function to get the address from coordinates

    </script
@endpush
