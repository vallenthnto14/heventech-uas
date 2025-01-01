<?php
session_start();
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_keluhan'])) {
    $id_keluhan = intval($_POST['id_keluhan']);

    $query = "DELETE FROM keluhan WHERE id_keluhan = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id_keluhan);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Keluhan berhasil dihapus.";
            header("Location: daftar_keluhan.php");
            exit();
        } else {
            
            $_SESSION['error'] = "Gagal menghapus keluhan.";
            header("Location: daftar_keluhan.php");
            exit();
        }
    } else {
        die("Query gagal: " . $conn->error);
    }
} else {
    
    header("Location: daftar_keluhan.php");
    exit();
}
?>
