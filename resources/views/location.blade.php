<!DOCTYPE html>
<html>
<head>
    <title>Select Location</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>
<body>
    <h1>Select Location</h1>

    <label>Country:</label>
    <select id="country"></select>

    <label>Province:</label>
    <select id="province"></select>

    <label>City:</label>
    <select id="city"></select>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let map = L.map('map').setView([20.0, 77.0], 5); // Default view

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker;

        // General-purpose dropdown fetcher
        async function fetchDropdown(url, elementId, valueKey = 'name', idKey = 'name') {
            const res = await fetch(url);
            const data = await res.json();
            const select = document.getElementById(elementId);
            select.innerHTML = `<option value="">--Select--</option>`;
            data.forEach(item => {
                select.innerHTML += `<option value="${item[idKey]}">${item[valueKey]}</option>`;
            });
        }

        document.addEventListener('DOMContentLoaded', async () => {
            // Load countries (use country name as value)
            await fetchDropdown('/api/ext/countries', 'country', 'name', 'name');

            document.getElementById('country').addEventListener('change', async function () {
                const country = encodeURIComponent(this.value);
                if (country) {
                    await fetchDropdown(`/api/ext/countries/${encodeURIComponent(country)}/provinces`, 'province');
                }
                document.getElementById('city').innerHTML = `<option value="">--Select--</option>`;
            });

            document.getElementById('province').addEventListener('change', async function () {
                const country = encodeURIComponent(document.getElementById('country').value);
                const province = encodeURIComponent(this.value);
                if (country && province) {
                    await fetchDropdown(`/api/ext/countries/${encodeURIComponent(country)}/provinces/${encodeURIComponent(province)}/cities`, 'city');
                }
            });

            document.getElementById('city').addEventListener('change', function () {
                const cityName = this.value;
                showOnMap(cityName);
            });
        });

        function showOnMap(cityName) {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(cityName)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = data[0].lat;
                        const lon = data[0].lon;
                        map.setView([lat, lon], 10);

                        if (marker) {
                            marker.setLatLng([lat, lon]);
                        } else {
                            marker = L.marker([lat, lon]).addTo(map);
                        }
                    } else {
                        alert("Location not found");
                    }
                });
        }
    </script>
    <br>
    <a href="{{ url('/admin') }}" class="admin-link">Admin Panel</a>

</body>
</html>
