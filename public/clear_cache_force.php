<?php

echo "<h1>Force Clearing Laravel Bootstrap Cache</h1>";
echo "<pre>";

// Define the path to the bootstrap/cache directory
$cacheDir = __DIR__ . '/../bootstrap/cache';

if (!is_dir($cacheDir)) {
    echo "Cache directory not found at: $cacheDir\n";
    exit;
}

// Files to look for and delete
$filesToDelete = [
    'services.php',
    'packages.php',
    'config.php',
    'routes-v7.php',
    'events.php'
];

foreach ($filesToDelete as $fileName) {
    $filePath = $cacheDir . '/' . $fileName;
    
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "✅ Deleted: $fileName\n";
        } else {
            echo "❌ Failed to delete: $fileName (Permission denied?)\n";
        }
    } else {
        echo "ℹ️  File not found (already clear): $fileName\n";
    }
}

echo "\nDone. Please try reloading your website now.";
echo "</pre>";
