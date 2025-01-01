<?php
session_start();
include('../config.php');

$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pesanan'], $_POST['status'])) {
    $id_pesanan = intval($_POST['id_pesanan']);
    $status = $_POST['status'];

    $allowed_status = ['Pending', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
    if (!in_array($status, $allowed_status)) {
        die("Status tidak valid.");
    }

    $sql = "UPDATE pesanan SET status = ? WHERE id_pesanan = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $status, $id_pesanan);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Status pesanan berhasil diubah.";
        } else {
            $_SESSION['error'] = "Gagal mengubah status pesanan.";
        }
        $stmt->close();
    } else {
        die("Kesalahan pada query: " . $conn->error);
    }
} else {
    $_SESSION['error'] = "Data tidak valid.";
}

$conn->close();
header("Location: kelola_pesanan.php");
exit();
