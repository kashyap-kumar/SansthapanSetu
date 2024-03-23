<?php
    // Database configuration
    $host = 'localhost';
    $dbname = 'sansthapansetu';
    $username = 'root';
    $password = '';

    // Connect to the database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>