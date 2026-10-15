
from pathlib import Path
import json
import joblib
import pandas as pd

from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import (
    accuracy_score,
    classification_report,
    confusion_matrix
)

BASE_DIR = Path(__file__).resolve().parent
DATA_PATH = BASE_DIR / "data" / "Crop_recommendation.csv"
MODEL_DIR = BASE_DIR / "models"
MODEL_DIR.mkdir(exist_ok=True)

FEATURES = [
    "N", "P", "K",
    "temperature", "humidity",
    "ph", "rainfall"
]

# 1. Load dataset
df = pd.read_csv(DATA_PATH)

print("Dataset shape:", df.shape)
print("Columns:", df.columns.tolist())
print("Missing values:")
print(df.isnull().sum())

# 2. Validate and clean data
required = FEATURES + ["label"]
missing_columns = set(required) - set(df.columns)

if missing_columns:
    raise ValueError(
        f"Missing dataset columns: {missing_columns}"
    )

df = df.dropna(subset=required).copy()

X = df[FEATURES]
y = df["label"]

print("Number of crop classes:", y.nunique())

# 3. Stratified train-test split
X_train, X_test, y_train, y_test = train_test_split(
    X, y,
    test_size=0.2,
    random_state=42,
    stratify=y
)

# 4. Train Random Forest
model = RandomForestClassifier(
    n_estimators=200,
    random_state=42,
    min_samples_leaf=2,
    n_jobs=-1
)

model.fit(X_train, y_train)

# 5. Evaluate
predictions = model.predict(X_test)

accuracy = accuracy_score(y_test, predictions)

print("\nModel Accuracy:", round(accuracy * 100, 2), "%")
print("\nClassification Report:")
print(classification_report(y_test, predictions))

print("\nFeature Importance:")
for feature, importance in sorted(
    zip(FEATURES, model.feature_importances_),
    key=lambda x: x[1],
    reverse=True
):
    print(f"{feature}: {importance:.4f}")

# 6. Save model
model_path = MODEL_DIR / "crop_model.joblib"
joblib.dump(model, model_path)

# 7. Save evaluation metrics
metrics = {
    "accuracy": float(accuracy),
    "training_samples": len(X_train),
    "test_samples": len(X_test),
    "features": FEATURES,
    "crop_classes": sorted(y.unique().tolist()),
    "confusion_matrix": confusion_matrix(
        y_test, predictions,
        labels=model.classes_
    ).tolist()
}

with open(MODEL_DIR / "metrics.json", "w") as f:
    json.dump(metrics, f, indent=2)

print("\nModel saved to:", model_path)
print("Metrics saved successfully!")
