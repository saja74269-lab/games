<?php
// Database setup script for PT Roti
// Run this file once to set up the database tables

include "database.php";

// Read the SQL file
$sql = file_get_contents('setup_database.sql');

// Split the SQL into individual statements
$statements = explode(';', $sql);

// Execute each statement
foreach ($statements as $statement) {
    $statement = trim($statement);
    if (!empty($statement)) {
        if (mysqli_query($conn, $statement)) {
            echo "✓ Executed: " . substr($statement, 0, 50) . "...<br>";
        } else {
            echo "✗ Error: " . mysqli_error($conn) . "<br>";
        }
    }
}

echo "<br><strong>Database setup completed!</strong><br>";
echo "<a href='login.php'>Go to Login</a>";
?>
