<?php
$type = $_GET['type'];
$file = "../data/" . $type . ".json";
if(file_exists($file)) {
    echo file_get_contents($file);
} else {
    echo json_encode([]);
}
?>