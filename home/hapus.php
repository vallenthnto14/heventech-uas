<?php
include 'config.php';

$id = $_GET['id'];

$query = "DELETE FROM pesanan WHERE id = $id";

if ($conn->query($query) === TRUE) {
    echo "Pesanan berhasil dihapus.";
    header('Location: daftar_pesanan.php');
} else {
    echo "Error: " . $conn->error;
}
?>
