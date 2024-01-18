<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $username = "root";
    $password = "";
    $database = "stegano";
    $hostname = "localhost";

    $connection = mysqli_connect($hostname, $username, $password, $database);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = $_SESSION['username'];
    $tableName = $username . "stegano";

    // Delete record from the database
    $sql = "DELETE FROM $tableName WHERE id = $id";

    if (mysqli_query($connection, $sql)) {
        echo "Record deleted successfully";
        header("Location: ./akun.php");
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }

    mysqli_close($connection);
} else {
    // If no 'id' parameter is provided, redirect to the main page
    header("Location: ./index.php");
    exit;
}
