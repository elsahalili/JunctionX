<?php
require_once __DIR__ . '/app.php';
session_start();
$userEmail = $_SESSION['user']['email'] ?? null;
if (!$userEmail) {
    echo "Not logged in.";
    exit();
}
$userFile = app_current_user_file();
if (!$userFile) {
    echo "User profile not found.";
    exit();
}

function loadUserData($file) {
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

function saveUserData($file, $data) {
    app_write_json($file, $data);
}

$action = $_POST['action'] ?? '';

if ($action === 'save_cv') {
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
        $cvContent = file_get_contents($_FILES['cv']['tmp_name']);
        $userData = loadUserData($userFile);
        $userData['cv'] = base64_encode($cvContent);
        saveUserData($userFile, $userData);
        header("Location: quizPage.php?step=quiz");
    } else {
        echo "Failed to upload CV.";
    }
    exit();
}

if ($action === 'save_quiz') {
    $userData = loadUserData($userFile);
    $userData['quiz'] = [
        "science" => $_POST['science'] ?? 'no',
        "social" => $_POST['social'] ?? 'no',
        "tech" => $_POST['tech'] ?? 'no',
    ];
    saveUserData($userFile, $userData);
    header("Location: quizPage.php?step=results");
    exit();
}
?>
