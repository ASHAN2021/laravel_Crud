<?php

// Test SQLite connection
$dbPath = __DIR__ . '/database/database.sqlite';
echo "Database path: " . $dbPath . "\n";
echo "File exists: " . (file_exists($dbPath) ? 'Yes' : 'No') . "\n";

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    echo "SQLite connection: Success\n";

    // Test a simple query
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables found: " . implode(', ', $tables) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
