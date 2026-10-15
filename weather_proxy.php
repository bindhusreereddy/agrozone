
<?php
header("Content-Type: application/json");

$location = trim($_GET["location"] ?? "");

if ($location === "") {
    http_response_code(400);
    echo json_encode(["error" => "Location is required"]);
    exit;
}

$url = "http://127.0.0.1:8000/weather?location="
     . urlencode($location);

$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 25
]);

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
    http_response_code(502);
    echo json_encode([
        "error" => "Unable to connect to weather service"
    ]);
    curl_close($ch);
    exit;
}

curl_close($ch);

http_response_code($status ?: 502);
echo $response;
?>
