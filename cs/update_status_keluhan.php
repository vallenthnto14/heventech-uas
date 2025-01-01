<?php
session_start();
include('../config.php');

$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_keluhan = $_POST['id_keluhan'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE keluhan SET status = ? WHERE id_keluhan = ?");
    $stmt->bind_param("si", $status, $id_keluhan);

    if ($stmt->execute()) {
        echo "Status keluhan berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui status keluhan: " . $conn->error;
    }

    header("Location: daftar_keluhan.php");
}
?>
