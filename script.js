document.addEventListener("DOMContentLoaded", function () {
    fetch("https://api.openaq.org/v1/latest?city=YourCity")
        .then(response => response.json())
        .then(data => {
            document.getElementById("aqiValue").innerHTML = `AQI: ${data.results[0].measurements[0].value}`;
        })
        .catch(() => {
            document.getElementById("aqiValue").innerHTML = "AQI Data Unavailable";
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // Simulated User Data
    let ecoPoints = 350;
    let leaderboard = [
        { name: "Alice", points: 1200 },
        { name: "Bob", points: 980 },
        { name: "Charlie", points: 850 },
    ];

    // Display Eco Points
    document.getElementById("ecoPoints").textContent = ecoPoints + " Points";

    // Display Leaderboard
    let leaderboardList = document.getElementById("leaderboard");
    leaderboardList.innerHTML = "";
    leaderboard.forEach(user => {
        let li = document.createElement("li");
        li.textContent = `${user.name}: ${user.points} Points`;
        leaderboardList.appendChild(li);
    });
});
