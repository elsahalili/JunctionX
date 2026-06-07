<?php
require_once __DIR__ . '/../../app.php';
session_start();

if (!isset($_SESSION['admin'])) {
    http_response_code(403);
    die('Unauthorized.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Invalid request method.');
}

if (($_POST['type'] ?? '') !== 'universities') {
    http_response_code(400);
    die('Invalid type value.');
}

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$location = trim($_POST['location'] ?? '');
$website = trim($_POST['website'] ?? '');
$image = trim($_POST['image'] ?? '');
$chatBot = trim($_POST['chatBot'] ?? '');

if ($name === '' || $description === '' || $location === '' || !filter_var($website, FILTER_VALIDATE_URL)) {
    http_response_code(422);
    die('Missing required fields or invalid website URL.');
}

$dataFile = app_path('universities.json');
$data = app_read_json($dataFile, []);
if (!is_array($data)) {
    $data = [];
}

$data[$name] = [
    'slug' => strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', '-', $name), '-')),
    'description' => $description,
    'location' => $location,
    'website' => $website,
    'image' => $image,
    'chatBot' => $chatBot,
];

app_write_json($dataFile, $data);
app_redirect('../admin/manage_universities.php');
