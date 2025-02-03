<!-- resources/views/requests/showRequests.blade.php -->
@extends('main')
@section('content')
<form method="GET" action="{{ route('requests.byDriver') }}">
    <label for="route">Επιλογή Διαδρομής:</label>
    <select name="route_id" id="route" onchange="this.form.submit()">
        <option value="">--Επιλέξτε Διαδρομής--</option>
        @foreach ($routes as $route)
            <option value="{{ $route->id }}" {{ $selectedRouteId == $route->id ? 'selected' : '' }}>
                {{ $route->name }}
            </option>
        @endforeach
    </select>
</form>
@if($requests->isNotEmpty())
<div class="d-flex flex-column h-100">
    <div>
        <table class = "table table-border data-table">
            <thead>
                <h3 class="box">Διαδρομή</h3>
                <tr>
                    <th>ID</th>
                    <th>Εντολέας</th>
                    <th>Tηλέφωνο</th>
                    <th>Διεύθυνση</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($requests as $request)
                <tr>
                    <td>{{$request->id}}</td>
                    <td>{{$request->name}}</td>
                    <td>{{$request->phone}}</td>
                    <td>{{$request->address}}</td>
                    <td>
                        <a
                        href="{{route ('request.delete', $request)}}"
                        class = "btn btn-danger"
                        ><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div id="map" style="height: 350px"></div>
</div>
@elseif($selectedRouteId)
    <p>Δεν υπάρχουν αιτήματα για την επιλεγμένη διαδρομή.</p>
@endif
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

 
        const iconDefault = L.icon({
            iconUrl: '{{asset('images/pin.png')}}', // Replace with the path to your custom icon image
            iconSize: [40, 32],                      // Adjust icon size if needed
            iconAnchor: [16, 32],                    // Adjust anchor point based on icon size
            popupAnchor: [0, -32]                    // Position popup above the icon
        });
    
        // Δεδομένα markers
        var markers = @json($requests); // Παράδειγμα Laravel μεταβλητής με δεδομένα
        markers.forEach(function(marker) {
            
                L.marker([marker.lat, marker.lon], { icon: iconDefault }) // Add custom icon here
                    .addTo(map)
                    .bindPopup('ID:'+marker.id + ' ' +marker.name+' : '+marker.category);
            
        });


    </script>
@endpush



