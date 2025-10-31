<?php
// === Allowed website origins ===
$allowed_origins = [
    "https://jonartdev.github.io",
    "https://pages-6zfpxkf5du.tcloudbaseapp.com",
    "https://pvbstock.pages.dev",
    "https://plants-vs-brainbot-stock-notifier-qnukbpxw6u.edgeone.app/",
    "https://plants-vs-brainbot-stock-notifier-379z5rmtjh.edgeone.app/" // ✅ new working domain
];


// === Check the Origin header ===
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (!$origin) {
    // Allow local testing or direct access
    $origin = $allowed_origins[0];
}

if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    http_response_code(403);
    echo json_encode([
        "error" => "Forbidden: You're not able to access this site",
        "received_origin" => $origin
    ]);
    exit();
}

// === CORS headers ===
header("Access-Control-Allow-Origin: *"); // or specify your domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle preflight OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// === Supabase API request ===
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://vextbzatpprnksyutbcp.supabase.co/rest/v1/game_stock?select=*&game=eq.plantsvsbrainrots&type=eq.gear&active=eq.true&order=created_at.desc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => [
        "apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZleHRiemF0cHBybmtzeXV0YmNwIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTM4NjYzMTIsImV4cCI6MjA2OTQ0MjMxMn0.apcPdBL5o-t5jK68d9_r9C7m-8H81NQbTXK0EW0o800",
        "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZleHRiemF0cHBybmtzeXV0YmNwIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTM4NjYzMTIsImV4cCI6MjA2OTQ0MjMxMn0.apcPdBL5o-t5jK68d9_r9C7m-8H81NQbTXK0EW0o800"
    ]
]);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo json_encode(["error" => curl_error($curl)]);
} else {
    echo $response;
}

curl_close($curl);
?>