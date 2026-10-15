
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Agro-Zone | Smart Crop Advisor</title>

<style>
* { box-sizing: border-box; }

body {
    font-family: Arial, sans-serif;
    background: #eef5ee;
    margin: 0;
    padding: 30px 15px;
    color: #24352a;
}

.container {
    max-width: 850px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 5px 20px #00000012;
}

h1 { color: #247a42; margin-bottom: 5px; }
h2 { color: #286a3e; margin-top: 28px; }

.subtitle { color: #66756a; }

.grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 7px;
}

input, select {
    width: 100%;
    padding: 11px;
    border: 1px solid #c8d3c8;
    border-radius: 7px;
    font-size: 15px;
}

.field { margin-bottom: 15px; }

.note {
    background: #f0f7ed;
    padding: 14px;
    border-radius: 8px;
    color: #435c46;
    margin: 15px 0;
    line-height: 1.5;
}


/* Small buttons for secondary actions */
.secondary-btn {
    width: auto;
    padding: 10px 18px;
    font-size: 14px;
    margin-top: 10px;
    background: #e7f2e9;
    color: #246b3b;
    border: 1px solid #a9cbb1;
}

.secondary-btn:hover {
    background: #8ad299;
}

/* Main prediction button */
.primary-btn {
    width: 100%;
    padding: 16px;
    font-size: 17px;
    background: #267a43;
}


.primary-btn:hover { background: #1d6134; }
button:disabled { opacity: 0.6; cursor: wait; }

.result {
    background: #eaf6eb;
    padding: 20px;
    border-radius: 10px;
    margin-top: 25px;
}

.crop {
    background: white;
    padding: 14px;
    margin: 10px 0;
    border-left: 4px solid #267a43;
    border-radius: 6px;
}

small { color: #66756a; line-height: 1.5; }

@media (max-width: 600px) {
    .grid { grid-template-columns: 1fr; }
    .container { padding: 20px; }
}
</style>
</head>

<body>
<div class="container">

<h1>🌱 Agro-Zone Smart Crop Advisor</h1>
<p class="subtitle">
    Explore crop recommendations using soil and
    environmental measurements.
</p>

<form id="cropForm">

<h2>1. Farm Information</h2>

<div class="field">
    <label>Farm Location</label>
    <input name="location"
       value="Gainesville, Florida"
       required>
</div>

<button type="button"
        id="fetchWeatherButton"
        class="secondary-btn">
    Fetch Weather
</button>

<p id="weatherStatus" aria-live="polite"></p>

<div class="grid">
    <div class="field">
        <label>Planting Season</label>
        <select name="season">
            <option value="spring">Spring</option>
            <option value="summer">Summer</option>
            <option value="fall">Fall</option>
            <option value="winter">Winter</option>
        </select>
    </div>

    <div class="field">
        <label>Farm Area (acres)</label>
        <input name="farm_area" type="number"
               value="2" min="0.01" step="0.01"
               required>
    </div>

    <div class="field">
        <label>Soil Type</label>
        <select name="soil_type">
            <option value="unknown">I don't know</option>
            <option value="sandy">Sandy</option>
            <option value="loamy">Loamy</option>
            <option value="clay">Clay</option>
        </select>
    </div>

    <div class="field">
        <label>Water Availability</label>
        <select name="water_availability">
            <option value="rainfed">Rainfed only</option>
            <option value="limited" selected>
                Limited irrigation
            </option>
            <option value="reliable">
                Reliable irrigation
            </option>
        </select>
    </div>
</div>


<h2>2. Soil Measurements</h2>
<p class="subtitle">
    Enter values from a soil test report.
    N/P/K units must match the training dataset.
</p>

<div class="grid">
    <div class="field">
        <label>Nitrogen (N)</label>
        <input type="number" name="N"
               min="0" step="any" required>
    </div>

    <div class="field">
        <label>Phosphorus (P)</label>
        <input type="number" name="P"
               min="0" step="any" required>
    </div>

    <div class="field">
        <label>Potassium (K)</label>
        <input type="number" name="K"
               min="0" step="any" required>
    </div>

    <div class="field">
        <label>Soil pH</label>
        <input type="number" name="ph"
               min="0" max="14"
               step="any" required>
    </div>
</div>

<h2>3. Environmental Measurements</h2>


<div class="grid">
    <div class="field">
        <label>Temperature (°C)</label>
        <input type="number" name="temperature"
               step="any" required>
    </div>

    <div class="field">
        <label>Relative Humidity (%)</label>
        <input type="number" name="humidity"
               min="0" max="100"
               step="any" required>
    </div>

    <div class="field">
        <label>Rainfall (mm)</label>
        <input type="number" name="rainfall"
               min="0" step="any" required>
    </div>
</div>

<button type="button"
        id="sampleButton"
        class="secondary-btn">
    Load Sample Soil Values (N, P, K)
</button>

<small>
    Sample values are for testing only and
    are not measurements from the selected farm.
</small>

<button type="submit"
        id="predictButton"
        class="primary-btn">
    Get Crop Recommendations
</button>

</form>

<div id="result" class="result"
     style="display:none" aria-live="polite">
</div>

</div>

<script>
const form = document.getElementById("cropForm");
const result = document.getElementById("result");
const predictButton = document.getElementById("predictButton");


const weatherButton =
    document.getElementById("fetchWeatherButton");

const weatherStatus =
    document.getElementById("weatherStatus");

weatherButton.addEventListener("click", async () => {
    const location = form.elements["location"].value.trim();

    if (!location) {
        weatherStatus.textContent = "Please enter a location.";
        return;
    }

    weatherButton.disabled = true;
    weatherStatus.textContent = "Fetching weather data...";

    try {
        const response = await fetch(
            "weather_proxy.php?location=" +
            encodeURIComponent(location)
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.detail || data.error || "Weather request failed"
            );
        }

        form.elements["temperature"].value = data.temperature;
        form.elements["humidity"].value = data.humidity;
        form.elements["rainfall"].value = data.rainfall;

        weatherStatus.textContent =
            "Weather loaded for " + data.location +
            " (" + data.start_date + " to " +
            data.end_date + ").";

    } catch (error) {
        weatherStatus.textContent =
            "Could not fetch weather: " + error.message;
    } finally {
        weatherButton.disabled = false;
    }
});


const fields = [
    "N", "P", "K", "temperature",
    "humidity", "ph", "rainfall"
];


document.getElementById("sampleButton")
.addEventListener("click", () => {
    const sample = {
        N: 90,
        P: 42,
        K: 43
    };

    for (const [key, value] of Object.entries(sample)) {
        form.elements[key].value = value;
    }
});

form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const payload = {};

    for (const field of fields) {
        const value = form.elements[field].value;
        if (value.trim() === "") {
            result.style.display = "block";
            result.textContent = "Missing field: " + field;
            return;
        }
        payload[field] = Number(value);
    }

    result.style.display = "block";
    result.textContent = "Analyzing measurements...";
    predictButton.disabled = true;

    try {
        const response = await fetch(
            "ml_predict_proxy.php",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.message || "Prediction failed"
            );
        }

        result.replaceChildren();

        const heading = document.createElement("h2");
        heading.textContent = "Recommended Crops";
        result.appendChild(heading);

        for (const [index, item]
             of data.recommendations.entries()) {

            const card = document.createElement("div");
            card.className = "crop";

            const title = document.createElement("strong");
            title.textContent =
                `${index + 1}. ${item.crop.toUpperCase()}`;

            const score = document.createElement("p");
            score.textContent =
                "Model score: " +
                (item.model_score * 100).toFixed(2) + "%";

            card.append(title, score);
            result.appendChild(card);
        }

        const note = document.createElement("small");
        note.textContent = data.disclaimer || "";
        result.appendChild(note);

    } catch (error) {
        result.textContent = "Error: " + error.message;
    } finally {
        predictButton.disabled = false;
    }
});
</script>
</body>
</html>
