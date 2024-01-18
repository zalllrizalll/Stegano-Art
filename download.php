<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
    exit;
}

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    // Connect to the database
    $username = "root";
    $password = "";
    $database = "stegano";
    $hostname = "localhost";

    $connection = mysqli_connect($hostname, $username, $password, $database);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the current username from the session
    $username = $_SESSION['username'];

    // Sanitize and get the image ID from the URL
    $imageId = mysqli_real_escape_string($connection, $_GET['id']);


    // Construct the query to fetch the image details
    $tableName = $username . "stegano";
    $sql = "SELECT * FROM $tableName WHERE id = $imageId";
    $result = mysqli_query($connection, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['pathImg'];

        // Set the appropriate headers for a download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($imagePath) . '"');

        // Read the image file and output it to the browser
        readfile($imagePath);

        // Close the database connection
        mysqli_close($connection);
        exit;
    } else {
        echo "Image not found.";
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    echo "Invalid request.";
}
