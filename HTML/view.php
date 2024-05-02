<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$sharePath = '/mnt/share';
$filePath = realpath($sharePath . '/' . $_GET['file']);

// Ensure the file is within the share path to prevent directory traversal
if (strpos($filePath, $sharePath) === 0 && is_file($filePath)) {
    echo "<h1>Viewing File: " . htmlspecialchars(basename($filePath)) . "</h1>";
    echo "<pre>" . htmlspecialchars(file_get_contents($filePath)) . "</pre>";
} else {
    echo "Invalid file path or file does not exist.";
}
?>
