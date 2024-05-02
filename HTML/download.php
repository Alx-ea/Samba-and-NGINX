<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$sharePath = '/mnt/share';
$filename = $sharePath . '/' . $_GET['file'];

// Validate that the path is a file and not traversing directories
if (is_file($filename) && file_exists($filename) && strpos(realpath($filename), $sharePath) === 0) {
    // Set headers to force download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
    exit;
} else {
    echo "Invalid file.";
}
?>
