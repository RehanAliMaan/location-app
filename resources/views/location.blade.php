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

        #coordinates {
            font-weight: bold;
            margin-top: 15px;
            font-size: 16px;
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

    <label>Area:</label>
    <select id="area"></select>

    <div id="coordinates"></div>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let map = L.map('map').setView([20.0, 77.0], 5); // Default view
        let marker;
        let areaMarkers = [];

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

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
            await fetchDropdown('/api/ext/countries', 'country');

            document.getElementById('country').addEventListener('change', async function () {
                const country = encodeURIComponent(this.value);
                if (country) {
                    await fetchDropdown(`/api/ext/countries/${country}/provinces`, 'province');
                }
                document.getElementById('city').innerHTML = `<option value="">--Select--</option>`;
                document.getElementById('area').innerHTML = `<option value="">--Select--</option>`;
                document.getElementById('coordinates').innerHTML = '';
            });

            document.getElementById('province').addEventListener('change', async function () {
                const country = encodeURIComponent(document.getElementById('country').value);
                const province = encodeURIComponent(this.value);
                if (country && province) {
                    await fetchDropdown(`/api/ext/countries/${country}/provinces/${province}/cities`, 'city');
                }
                document.getElementById('area').innerHTML = `<option value="">--Select--</option>`;
                document.getElementById('coordinates').innerHTML = '';
            });

            document.getElementById('city').addEventListener('change', async function () {
                const cityName = this.value;
                if (cityName) {
                    await showOnMap(cityName);
                    await fetchAreas(cityName); // Fetch areas for the city
                }
            });

            document.getElementById('area').addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const lat = selectedOption.getAttribute('data-lat');
                const lon = selectedOption.getAttribute('data-lon');

                if (lat && lon) {
                    map.setView([lat, lon], 13);
                }
            });
        });

        async function showOnMap(cityName) {
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(cityName)}`);
            const data = await res.json();

            if (data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);

                document.getElementById('coordinates').textContent = 
                    `Latitude: ${lat.toFixed(6)}, Longitude: ${lon.toFixed(6)}`;

                map.setView([lat, lon], 10);

                if (marker) {
                    marker.setLatLng([lat, lon]);
                } else {
                    marker = L.marker([lat, lon]).addTo(map);
                }
            } else {
                document.getElementById('coordinates').textContent = "Location not found.";
            }
        }

async function fetchAreas(cityName) {
    areaMarkers.forEach(m => map.removeLayer(m));
    areaMarkers = [];

    const res = await fetch(`/api/ext/cities/${encodeURIComponent(cityName)}/areas`);
    const data = await res.json();

    console.log(data); // Check the response structure

    const select = document.getElementById('area');
    select.innerHTML = `<option value="">--Select Area--</option>`;

    if (Array.isArray(data) && data.length > 0) {
        data.forEach(location => {
            const lat = location.lat;
            const lon = location.lng;
            const name = location.name;

            select.innerHTML += `<option value="${name}" data-lat="${lat}" data-lon="${lon}">${name}</option>`;

            const marker = L.marker([lat, lon]).addTo(map).bindPopup(name);
            areaMarkers.push(marker);
        });
    } else {
        select.innerHTML += `<option disabled>No areas found</option>`;
    }
}





    </script>

    <br>
    <a href="{{ url('/admin') }}" class="admin-link">Admin Panel</a>

</body>
</html>
