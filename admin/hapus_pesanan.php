<?php
session_start();
include('../config.php');


$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pesanan'])) {
    $id_pesanan = $conn->real_escape_string($_POST['id_pesanan']);


    $sql = "DELETE FROM pesanan WHERE id_pesanan = '$id_pesanan'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Pesanan berhasil dihapus.";
    } else {
        $_SESSION['message'] = "Gagal menghapus pesanan: " . $conn->error;
    }
}

header("Location: kelola_pesanan.php");
exit();
?>
