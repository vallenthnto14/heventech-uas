<?php
session_start();
include('../config.php');

if (!isset($_SESSION['user_id'])) {
    die("Silakan login terlebih dahulu.");
}

if (isset($_GET['id'])) {
    $id_pesanan = $_GET['id'];
    $id_pengguna = $_SESSION['user_id'];

    $query = "SELECT * FROM pesanan WHERE id_pesanan = ? AND id_pengguna = ? AND status = 'Pending'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_pesanan, $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $update_query = "UPDATE pesanan SET status = 'Dibatalkan' WHERE id_pesanan = ?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("i", $id_pesanan);
        $stmt_update->execute();

        echo "<script>alert('Pesanan berhasil dibatalkan.'); window.location.href = 'pesanan.php';</script>";
    } else {
        echo "<script>alert('Pesanan tidak valid atau sudah dibayar.'); window.location.href = 'pesanan.php';</script>";
    }
} else {
    echo "<script>alert('ID Pesanan tidak ditemukan.'); window.location.href = 'pesanan.php';</script>";
}

$stmt->close();
$stmt_update->close();
