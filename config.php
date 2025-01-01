<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "aksesoris_computer";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
