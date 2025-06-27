<?php
// This is an example configuration file.
// Copy this file to 'koneksi.php' and fill in your actual database credentials.

$host = "127.0.0.1";
$port = 3306;

$user = "YOUR_USERNAME"; // Replace with your MySQL username
// Note: If you are using XAMPP, the default username is usually 'root'

$password = "YOUR_PASSWORD"; // Replace with your MySQL password
// Note: If you are using XAMPP, the default password is usually empty

$db_name = "db_mahasiswa";

$connection = mysqli_connect($host, $user, $password, $db_name, $port);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>