<?php
require 'db_credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $db_password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "DROP DATABASE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database dropped successfully<br>";
} else {
    echo "<br>Error dropping database: " . mysqli_error($conn);
}