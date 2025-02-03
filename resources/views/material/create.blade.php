<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>Δημιουργία Υλικού</title>
    <style>
        #map { height: 400px; }
    </style>
</head>
<body>
    <h1>Καταχώρηση Υλικού</h1>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <form id="materialForm" action="{{ route('material_request.store') }}" method="POST">
        @csrf
        <label for="category">Επιλέξτε Κατηγορία:</label>
        <select id="category" name="category" required>
            <option value="">Επιλέξτε...</option>
            <option value="Υλικό 1">Υλικό 1</option>
            <option value="Υλικό 2">Υλικό 2</option>
            <option value="Υλικό 3">Υλικό 3</option>
        </select>

        <label for="address">Διεύθυνση:</label>
        <input type="text" id="address" name="address" placeholder="Εισάγετε διεύθυνση" required>

        <button type="submit">Αποθήκευση</button>
    </form>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([37.9838, 23.7275], 13); // Αρχική θέση (Αθήνα)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        document.getElementById('materialForm').onsubmit = function(event) {
            event.preventDefault(); // Αποτροπή επαναφόρτωσης σελίδας
            var address = document.getElementById('address').value;
            var category = document.getElementById('category').value;

            // Χρήση Geocoding API για την ανεύρεση των συντεταγμένων
            var geocodingUrl = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);
            fetch(geocodingUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        var lat = data[0].lat;
                        var lon = data[0].lon;

                        // Κεντράρισμα στον χάρτη
                        map.setView([lat, lon], 13);
                        L.marker([lat, lon]).addTo(map).bindPopup('Διεύθυνση: ' + address + '<br>Κατηγορία: ' + category).openPopup();

                        // Μπορείς να αποθηκεύσεις τις συντεταγμένες στο hidden πεδίο πριν στείλεις τη φόρμα
                        var hiddenLatInput = document.createElement('input');
                        hiddenLatInput.type = 'hidden';
                        hiddenLatInput.name = 'lat';
                        hiddenLatInput.value = lat;
                        document.getElementById('materialForm').appendChild(hiddenLatInput);

                        var hiddenLonInput = document.createElement('input');
                        hiddenLonInput.type = 'hidden';
                        hiddenLonInput.name = 'lon';
                        hiddenLonInput.value = lon;
                        document.getElementById('materialForm').appendChild(hiddenLonInput);

                        // Τώρα υποβάλλεις τη φόρμα
                        document.getElementById('materialForm').submit();
                    } else {
                        alert('Διεύθυνση δεν βρέθηκε.');
                    }
                })
                .catch(error => console.error('Error:', error));
        };
    </script>
</body>
</html>
