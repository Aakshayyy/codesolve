<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');

echo "CodeSolve Vercel Diagnostics\n";
echo "============================\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Current Directory: " . __DIR__ . "\n";

$paths = [
    '../public' => 'public directory',
    '../public/index.php' => 'public/index.php file',
    '../bootstrap' => 'bootstrap directory',
    '../bootstrap/app.php' => 'bootstrap/app.php file',
    '../vendor' => 'vendor directory',
    '../vendor/autoload.php' => 'Composer autoload',
    '../app' => 'app directory',
    '../config' => 'config directory',
    '../storage' => 'storage directory',
];

echo "\nChecking File & Directory Presence:\n";
foreach ($paths as $relPath => $desc) {
    $absPath = realpath(__DIR__ . '/' . $relPath);
    if ($absPath) {
        echo " - [OK] $desc ($relPath) resolves to: $absPath\n";
    } else {
        echo " - [FAIL] $desc ($relPath) DOES NOT EXIST\n";
    }
}

echo "\nChecking Write Permissions on /tmp:\n";
$tempFile = '/tmp/test_write_' . time() . '.txt';
if (@file_put_contents($tempFile, 'test')) {
    echo " - [OK] Successfully wrote to $tempFile\n";
    @unlink($tempFile);
} else {
    echo " - [FAIL] Failed to write to $tempFile\n";
}

echo "\nEnvironment Variables Check:\n";
echo " - APP_KEY is set: " . (getenv('APP_KEY') ? 'YES' : 'NO') . "\n";
echo " - APP_DEBUG is set: " . (getenv('APP_DEBUG') ? 'YES (' . getenv('APP_DEBUG') . ')' : 'NO') . "\n";
echo " - CACHE_STORE is set: " . (getenv('CACHE_STORE') ? 'YES (' . getenv('CACHE_STORE') . ')' : 'NO') . "\n";

try {
    echo "\nAttempting to require composer autoload:\n";
    $autoloadPath = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoloadPath)) {
        require $autoloadPath;
        echo " - [OK] Autoload required successfully.\n";
    } else {
        echo " - [FAIL] Autoload file not found at $autoloadPath.\n";
    }
} catch (\Throwable $e) {
    echo " - [ERROR] Exception loading autoload: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

try {
    echo "\nAttempting to load Laravel Application Container:\n";
    $appPath = __DIR__ . '/../bootstrap/app.php';
    if (file_exists($appPath)) {
        $app = require $appPath;
        echo " - [OK] bootstrap/app.php returned successfully.\n";
        
        echo "\nAttempting to resolve kernel:\n";
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
        echo " - [OK] Resolved Kernel.\n";
    } else {
        echo " - [FAIL] bootstrap/app.php not found.\n";
    }
} catch (\Throwable $e) {
    echo " - [ERROR] Exception booting Laravel: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
    echo $e->getTraceAsString() . "\n";
}
