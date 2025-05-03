<?php
$type = $_POST['type'];
$data = $_POST['data'];
$file = "../data/" . $type . ".json";
file_put_contents($file, $data);
echo json_encode(["status" => "success"]);
?>