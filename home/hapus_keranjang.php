<?php
session_start();
include('../config.php');

if (!isset($_SESSION['user_id'])) {
    die("Silakan login terlebih dahulu.");
}

$id_pengguna = $_SESSION['user_id'];

if (isset($_POST['id_keranjang'])) {
    $id_keranjang = $_POST['id_keranjang'];

    $sql = "DELETE FROM keranjang WHERE id = ? AND id_pengguna = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_keranjang, $id_pengguna);

    if ($stmt->execute()) {
        header("Location: keranjang.php");
        exit;
    } else {
        echo "Gagal menghapus produk dari keranjang.";
    }
    $stmt->close();
}
?>
