<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in as admin
if (!isset($_SESSION["admin"])) {
    header("Location: unauthorized.php");  // Redirect to unauthorized page if not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") { // Only process POST requests
    if ($_POST["type"] === "universities") {  // Check if 'type' is 'universities'
        $dataFile = __DIR__ . "/../../universities.json";  // Path to JSON file

        // Create the file if it doesn't exist
        if (!file_exists($dataFile)) {
            file_put_contents($dataFile, json_encode([]));  // Initialize with empty array if file is missing
        }

        // Validate the required fields
        $description = trim($_POST["description"] ?? "");
        $location = trim($_POST["location"] ?? "");
        $website = trim($_POST["website"] ?? "");
        $image = trim($_POST["image"] ?? "");
        $chatBot = trim($_POST["chatBot"] ?? "");

        // If required fields are missing, show an error
        if (!$description || !$location || !$website) {
            die("❌ Missing required fields!");
        }

        // Read the existing data from JSON
        $data = json_decode(file_get_contents($dataFile), true);
        if (!is_array($data)) {
            $data = [];  // Initialize an empty array if data is not in the right format
        }

        // Add the new university entry
        $newEntry = [
            "description" => $description,
            "location" => $location,
            "website" => $website,
            "image" => $image,
            "chatBot" => $chatBot
        ];

        $data[] = $newEntry;  // Append to the data

        // Save the updated data back to the JSON file
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Redirect to manage universities page
        header("Location: ../admin/manage_universities.php");
        exit();
    } else {
        die("❌ Invalid type value.");
    }
} else {
    die("❌ Invalid request method.");
}
