<?php
$type = $_POST['type'];
$append = isset($_POST['append']) && $_POST['append'] === "true";
$file = "../data/" . $type . ".json";

if ($append && isset($_POST['value'])) {
    $data = json_decode(file_get_contents($file), true);
    $data[] = $_POST['value'];
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    echo json_encode(["status" => "success"]);
} else if (isset($_POST['data'])) {
    file_put_contents($file, $_POST['data']);
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>