<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Προσθήκη Τοποθεσίας</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        /* Βασικές ρυθμίσεις */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        h1 {
            color: #4a90e2;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Φόρμα */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], select {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }

        button {
            background-color: #4a90e2;
            color: #fff;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357abd;
        }

        /* Χάρτης */
        #map {
            height: 400px;
            width: 100%;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px; /* Απόσταση από τη φόρμα */
        }

        /* Ευθυγράμμιση στη φόρμα */
        .form-group {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <h1>Προσθήκη Τοποθεσίας</h1>
    
    <form id="locationForm" method="POST" action="{{ route('locations.store') }}">
        @csrf
        <div class="form-group">
            <label for="address">Διεύθυνση:</label>
            <input type="text" id="address" name="address" required>
        </div>
        
        <div class="form-group">
            <label for="category">Κατηγορία:</label>
            <select id="category" name="category" required>
                <option value="αλουμινιο">Αλουμίνιο</option>
                <option value="ξυλο">Ξύλο</option>
                <option value="γυαλι">Γυαλί</option>
            </select>
        </div>

        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">
        
        <button type="submit">Καταχώρηση</button>
    </form>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([38.246242, 21.7350847], 13); // Αρχικές συντεταγμένες
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker;

        // Γεωκωδικοποίηση για διεύθυνση
        async function geocodeAddress() {
            const address = document.getElementById("address").value;
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${address}`);
            const data = await response.json();
            if (data.length > 0) {
                const { lat, lon } = data[0];
                
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lon;

                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lon]).addTo(map);
                map.setView([lat, lon], 13);
            }
        }

        document.getElementById("address").addEventListener("blur", geocodeAddress);
    </script>
</body>
</html>
