
import requests
from datetime import date, timedelta


def get_weather(location):
    location = location.strip()

    if len(location) < 2:
        raise ValueError("Enter a valid city or location")

    # Convert city name into coordinates.
    geo = requests.get(
        "https://geocoding-api.open-meteo.com/v1/search",
        params={"name": location, "count": 5},
        timeout=10
    )
    geo.raise_for_status()

    places = geo.json().get("results", [])

    if not places:
        raise ValueError("Location not found")

    # For now, choose the first result.
    # We'll display the resolved place for verification.
    place = places[0]

    # Use a completed historical 30-day period.
    end = date.today() - timedelta(days=6)
    start = end - timedelta(days=29)

    response = requests.get(
        "https://archive-api.open-meteo.com/v1/archive",
        params={
            "latitude": place["latitude"],
            "longitude": place["longitude"],
            "start_date": start.isoformat(),
            "end_date": end.isoformat(),
            "daily": (
                "temperature_2m_mean,"
                "relative_humidity_2m_mean,"
                "precipitation_sum"
            ),
            "timezone": place.get("timezone", "auto")
        },
        timeout=20
    )
    response.raise_for_status()

    daily = response.json()["daily"]

    def mean(values):
        values = [x for x in values if x is not None]
        if not values:
            raise ValueError("Weather data is unavailable")
        return sum(values) / len(values)

    rainfall_values = [
        x for x in daily["precipitation_sum"]
        if x is not None
    ]

    if not rainfall_values:
        raise ValueError("Rainfall data is unavailable")

    return {
        "location": ", ".join(filter(None, [
            place.get("name"),
            place.get("admin1"),
            place.get("country")
        ])),
        "temperature": round(
            mean(daily["temperature_2m_mean"]), 2
        ),
        "humidity": round(
            mean(daily["relative_humidity_2m_mean"]), 2
        ),
        "rainfall": round(sum(rainfall_values), 2),
        "start_date": start.isoformat(),
        "end_date": end.isoformat()
    }