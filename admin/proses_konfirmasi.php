<?php
session_start();
include('../config.php');

$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_bayar = $_POST['id_bayar'];
    $status_bayar = $_POST['status_bayar'];

    $query = "UPDATE bayar SET status_bayar = ? WHERE id_bayar = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status_bayar, $id_bayar);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Status pembayaran berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui status pembayaran.";
    }

    $stmt->close();
    header('Location: konfirmasi_pembayaran.php');
    exit();
}
?>
