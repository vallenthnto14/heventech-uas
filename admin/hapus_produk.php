<?php
session_start();
include('../config.php');


$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';


if (isset($_POST['id_produk'])) {
    $id_produk = $_POST['id_produk'];

    $result = $conn->query("SELECT gambar_produk FROM produk WHERE id_produk = $id_produk");
    $row = $result->fetch_assoc();
    $gambar_produk = $row['gambar_produk'];

    unlink('../asset/uploads/' . $gambar_produk);

    $query = "DELETE FROM produk WHERE id_produk = $id_produk";
    if ($conn->query($query)) {
        header('Location: admin_produk.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
