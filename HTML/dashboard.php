<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Base share path
$sharePath = '/mnt/share';
$currentPath = $sharePath;

// Check if a directory path is given and validate it
if (isset($_GET['path']) && is_dir($sharePath . '/' . $_GET['path'])) {
    $currentPath = realpath($sharePath . '/' . $_GET['path']);
    // Prevent directory traversal
    if (strpos($currentPath, $sharePath) !== 0) {
        $currentPath = $sharePath;
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Samba Access Page</h1>
        <h2>Files in: <?php echo htmlspecialchars(substr($currentPath, strlen($sharePath))); ?></h2>

        <?php
        // Navigation back link
        if ($currentPath != $sharePath) {
            $parentPath = dirname(substr($currentPath, strlen($sharePath)));
            echo "<a href='?path=" . urlencode($parentPath) . "' class='back-link'>Go Back</a>";
        }

        // List files and directories
        if (is_dir($currentPath) && $handle = opendir($currentPath)) {
            echo "<ul class='file-list'>";
            while (false !== ($entry = readdir($handle))) {
                if ($entry == "." || $entry == "..") {
                    continue;
                }
                $entryPath = $currentPath . '/' . $entry;
                // Check if entry is a directory or a file
                if (is_dir($entryPath)) {
                    echo "<li class='file-item directory-item'><a href='?path=" . urlencode(substr($entryPath, strlen($sharePath))) . "'>$entry</a><button onclick=\"location.href='?path=" . urlencode(substr($entryPath, strlen($sharePath))) . "'\">Enter</button></li>";
                } else {
                    // Provide a view link and download button for files
                    echo "<li class='file-item'><a href='view.php?file=" . urlencode(substr($entryPath, strlen($sharePath))) . "'>$entry</a><button onclick=\"location.href='download.php?file=" . urlencode(substr($entryPath, strlen($sharePath))) . "'\">Download</button></li>";
                }
            }
            echo "</ul>";
            closedir($handle);
        } else {
            echo "<p>Cannot access the directory.</p>";
        }
        ?>
    </div>
</body>
</html>
