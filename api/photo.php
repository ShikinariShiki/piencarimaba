<?php
// Simple photo proxy to help with CORS issues
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$nim = $_GET['nim'] ?? '';

if (empty($nim)) {
    http_response_code(400);
    echo "NIM parameter required";
    exit;
}

// Generate photo URL
$yearShort = substr($nim, 0, 2);
$year = '20' . $yearShort;
$photoUrl = "https://siakad.ub.ac.id/dirfoto/foto/foto_$year/$nim.jpg";

// Try to fetch the photo
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $photoUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$imageData = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

if ($httpCode == 200 && $imageData && strpos($contentType, 'image') !== false) {
    // Set appropriate headers for image
    header("Content-Type: $contentType");
    header("Content-Length: " . strlen($imageData));
    header("Cache-Control: public, max-age=3600"); // Cache for 1 hour
    echo $imageData;
} else {
    // Return a placeholder image or error
    http_response_code(404);
    header("Content-Type: text/plain");
    echo "Photo not found: $photoUrl (HTTP $httpCode)";
}
?>
