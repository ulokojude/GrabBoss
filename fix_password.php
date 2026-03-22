<?php
require_once("config/db.php");

try {
    // Enlarge password field to accommodate full bcrypt hashes
    $pdo->exec("ALTER TABLE users MODIFY COLUMN password VARCHAR(255)");
    
    // Clear old test users
    $pdo->exec("DELETE FROM users");
    
    echo "✓ Database fixed!<br>";
    echo "✓ Password field expanded to VARCHAR(255)<br>";
    echo "✓ Old test users cleared<br><br>";
    echo "Now register a new test account and login: <a href='auth/register.php'>Registration</a>";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
