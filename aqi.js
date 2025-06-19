document.addEventListener("DOMContentLoaded", async function() {
    const API_TOKEN = "3b5c11fcde68395aa1a298ef1bd8a602d8fdcec2";
    const VIZAG_STATION_ID = "@9067";
    const VIZAG_API_URL = `https://api.waqi.info/feed/${VIZAG_STATION_ID}/?token=${API_TOKEN}`;

    const CITIES = [
        { name: "Delhi", lat: 28.61, lon: 77.23 },
        { name: "Mumbai", lat: 19.08, lon: 72.88 },
        { name: "Kolkata", lat: 22.57, lon: 88.36 },
        { name: "Chennai", lat: 13.08, lon: 80.27 },
        { name: "Bangalore", lat: 12.97, lon: 77.59 },
        { name: "Hyderabad", lat: 17.38, lon: 78.48 },
        { name: "Ahmedabad", lat: 23.02, lon: 72.57 },
        { name: "Pune", lat: 18.52, lon: 73.85 }
    ];
    
        // Fetch AQI for Visakhapatnam using station ID
        async function fetchVizagAQI() {
            try {
                const response = await fetch(VIZAG_API_URL);
                const data = await response.json();
                if (data.status === "ok") {
                    const aqi = data.data.aqi;
                    const components = data.data.iaqi;
    
                    document.getElementById("vizag-aqi").innerText = `AQI: ${aqi}`;
                    document.getElementById("vizag-aqi").style.color = getColor(aqi);
                    document.getElementById("pm25").innerText = components.pm25?.v ?? "--";
                    document.getElementById("pm10").innerText = components.pm10?.v ?? "--";
                    document.getElementById("o3").innerText = components.o3?.v ?? "--";
                    document.getElementById("no2").innerText = components.no2?.v ?? "--";
                    document.getElementById("so2").innerText = components.so2?.v ?? "--";
                    document.getElementById("co").innerText = components.co?.v ?? "--";
                    document.getElementById("update-time").innerText = data.data.time.s;
                } else {
                    document.getElementById("vizag-aqi").innerText = "Data Not Available";
                }
            } catch (error) {
                console.error("Error fetching Visakhapatnam AQI:", error);
            }
        }
    
        

    // Fetch AQI for major cities in India and update the map
    async function fetchIndiaAQI() {
        const map = L.map("map").setView([20.59, 78.96], 5);
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);

        for (const city of CITIES) {
            try {
                const response = await fetch(`https://api.waqi.info/feed/${city.name}/?token=${API_TOKEN}`);
                const data = await response.json();
                if (data.status === "ok") {
                    const aqi = data.data.aqi;
                    L.circleMarker([city.lat, city.lon], {
                        radius: 10,
                        fillColor: getColor(aqi),
                        color: getColor(aqi),
                        fillOpacity: 0.8
                    })
                    .bindPopup(`<b>${city.name}</b><br>AQI: ${aqi}`)
                    .addTo(map);
                }
            } catch (error) {
                console.error(`Error fetching AQI for ${city.name}:`, error);
            }
        }
    }

    // Function to determine AQI color
    function getColor(aqi) {
        if (aqi <= 50) return "#009966";       // Good
        if (aqi <= 100) return "#FFDE33";      // Moderate
        if (aqi <= 150) return "#FF9933";      // Unhealthy for Sensitive Groups
        if (aqi <= 200) return "#CC0033";      // Unhealthy
        if (aqi <= 300) return "#660099";      // Very Unhealthy
        return "#7E0023";                      // Hazardous
    }

    fetchVizagAQI();
    fetchIndiaAQI();
});
