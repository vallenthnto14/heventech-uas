<?php
session_start();
include('../config.php');
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'];
    $gambar_kategori = "";
    if (!empty($_POST['id_kategori'])) {
        $id_kategori = intval($_POST['id_kategori']);
        if (!empty($_FILES["gambar_kategori"]["name"])) {
            $target_dir = "../asset/uploads/";
            $target_file = $target_dir . basename($_FILES["gambar_kategori"]["name"]);
            if (move_uploaded_file($_FILES["gambar_kategori"]["tmp_name"], $target_file)) {
                $gambar_kategori = basename($_FILES["gambar_kategori"]["name"]);
            }
        }

        $sql = $gambar_kategori
            ? "UPDATE kategori SET nama_kategori = ?, Gambar_kategori = ? WHERE id_kategori = ?"
            : "UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?";
        
        $stmt = $conn->prepare($sql);
        if ($gambar_kategori) {
            $stmt->bind_param("ssi", $nama_kategori, $gambar_kategori, $id_kategori);
        } else {
            $stmt->bind_param("si", $nama_kategori, $id_kategori);
        }
    } 

    else {
        if (!empty($_FILES["gambar_kategori"]["name"])) {
            $target_dir = "../asset/uploads/";
            $target_file = $target_dir . basename($_FILES["gambar_kategori"]["name"]);
            if (move_uploaded_file($_FILES["gambar_kategori"]["tmp_name"], $target_file)) {
                $gambar_kategori = basename($_FILES["gambar_kategori"]["name"]);
            }
        }

        $sql = "INSERT INTO kategori (nama_kategori, Gambar_kategori) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nama_kategori, $gambar_kategori);
    }

    if ($stmt->execute()) {
        header("Location: admin_home.php?message=success");
    } else {
        header("Location: admin_home.php?message=error");
    }
    $stmt->close();
} 

elseif (isset($_GET['id_kategori']) && is_numeric($_GET['id_kategori'])) {
    $id_kategori = intval($_GET['id_kategori']);
    $sql = "DELETE FROM kategori WHERE id_kategori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kategori);

    if ($stmt->execute()) {
        header("Location: admin_home.php?message=deleted");
    } else {
        header("Location: admin_home.php?message=error_delete");
    }
    $stmt->close();
} 

else {
    die('Aksi tidak valid!');
}

$conn->close();
?>
