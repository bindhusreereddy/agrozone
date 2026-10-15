
from pathlib import Path

import requests
import joblib
import pandas as pd
from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, Field
from typing import Literal
from fastapi import HTTPException
from weather_service import get_weather

app = FastAPI(title="Agro-Zone Crop Recommendation API")

BASE_DIR = Path(__file__).resolve().parent
MODEL_PATH = BASE_DIR / "models" / "crop_model.joblib"

FEATURES = [
    "N", "P", "K",
    "temperature", "humidity",
    "ph", "rainfall"
]

model = joblib.load(MODEL_PATH)


class CropFeatures(BaseModel):
    N: float = Field(ge=0)
    P: float = Field(ge=0)
    K: float = Field(ge=0)
    temperature: float
    humidity: float = Field(ge=0, le=100)
    ph: float = Field(ge=0, le=14)
    rainfall: float = Field(ge=0)


class SoilMeasurements(BaseModel):
    N: float | None = Field(default=None, ge=0)
    P: float | None = Field(default=None, ge=0)
    K: float | None = Field(default=None, ge=0)
    ph: float | None = Field(default=None, ge=0, le=14)


class FarmRequest(BaseModel):
    location: Literal["Gainesville, Florida"]
    season: Literal["spring", "summer", "fall", "winter"]
    soil_type: Literal["unknown", "sandy", "loamy", "clay"]
    water_availability: Literal["rainfed", "limited", "reliable"]
    farm_area: float = Field(gt=0)
    soil_measurements: SoilMeasurements


@app.get("/health")
def health():
    return {"status": "ok", "model_loaded": True}


@app.post("/predict")
def predict(features: CropFeatures):
    values = features.model_dump()

    # Preserve the feature names and training order.
    X = pd.DataFrame([values], columns=FEATURES)

    probabilities = model.predict_proba(X)[0]

    ranked_indices = probabilities.argsort()[::-1][:3]

    recommendations = [
        {
            "crop": str(model.classes_[i]),
            "model_score": round(float(probabilities[i]), 4)
        }
        for i in ranked_indices
    ]

    return {
        "status": "success",
        "crop": recommendations[0]["crop"],
        "recommendations": recommendations,
        "message": "Model prediction completed.",
        "disclaimer": (
            "Educational dataset prediction only. "
            "Model scores are not validated field suitability "
            "probabilities."
        )
    }



@app.get("/weather")
def weather(location: str):
    try:
        return get_weather(location)
    except ValueError as exc:
        raise HTTPException(
            status_code=400,
            detail=str(exc)
        )
    except requests.RequestException:
        raise HTTPException(
            status_code=503,
            detail="Weather service is temporarily unavailable"
        )


@app.post("/recommend")
def recommend(farm: FarmRequest):
    soil = farm.soil_measurements.model_dump()

    missing = [
        name for name, value in soil.items()
        if value is None
    ]

    if missing:
        return {
            "status": "needs_soil_test",
            "message": (
                "Please provide measured soil nutrient "
                "values and pH to continue."
            ),
            "missing_features": missing
        }

    return {
        "status": "needs_weather",
        "message": (
            "Soil measurements received. "
            "Weather features must be supplied using "
            "a compatible measurement period before prediction."
        ),
        "missing_features": [
            "temperature", "humidity", "rainfall"
        ]
    }
