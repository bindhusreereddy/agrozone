
<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
    exit;
}

$body = file_get_contents("php://input");
$payload = json_decode($body, true);

if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid JSON"]);
    exit;
}

$fields = [
    "N", "P", "K", "temperature",
    "humidity", "ph", "rainfall"
];

$clean = [];

foreach ($fields as $field) {
    if (
        !isset($payload[$field]) ||
        !is_numeric($payload[$field])
    ) {
        http_response_code(400);
        echo json_encode([
            "message" => "Missing or invalid field: " . $field
        ]);
        exit;
    }

    $clean[$field] = (float)$payload[$field];
}

$ch = curl_init("http://127.0.0.1:8000/predict");

curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($clean),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15
]);

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

curl_close($ch);

if ($response === false) {
    http_response_code(502);
    echo json_encode([
        "message" => "ML service unavailable: " . $error
    ]);
    exit;
}

http_response_code($status ?: 502);
echo $response;
?>
