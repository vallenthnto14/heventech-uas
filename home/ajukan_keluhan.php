<?php
session_start();
include('../config.php');
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['user_id'];
    $subjek = $_POST['subjek'];
    $isi_keluhan = $_POST['isi_keluhan'];
    $stmt = $conn->prepare("INSERT INTO keluhan (id_user, subjek, isi_keluhan) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_user, $subjek, $isi_keluhan);

    if ($stmt->execute()) {
        echo "Keluhan Anda telah diajukan.";
    } else {
        echo "Gagal mengajukan keluhan: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Keluhan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-lg-top">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <div class="logo me-3">
                        <a href="home.php">
                            <img src="../asset/logo.png" alt="logo" height="40">
                        </a>
                    </div>
                    <a class="navbar-brand">HavenTech</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produk.php">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="kontak.html">Kontak</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="pesananDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Status
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="pesananDropdown">
                                <li><a class="dropdown-item" href="pesanan.php">Pesanan</a></li>
                                <li><a class="dropdown-item" href="keranjang.php">Keranjang</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ajukan_keluhan.php">Keluhan</a>
                        </li>
                    </ul>
                    <div class="auth">
                        <a class="btn btn-primary" href="../pengguna/logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container my-5">
            <div class="form-container p-3 border rounded shadow-sm" style="max-width: 450px; margin: 0 auto; background-color: #d3d3d3; color: black">
                <h2 class="text-center mb-5">Ajukan Keluhan</h2>
                <form method="POST" class="keluhan-form">
                    <div class="mb-3">
                        <label for="subjek" class="form-label" style="font-weight: bold; color: black; text-align: left; display: block;">Masukkan Subjek</label>
                        <input type="text" name="subjek" id="subjek" class="form-control" placeholder="Tuliskan subjek keluhan" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi_keluhan" class="form-label" style="font-weight: bold; color: black; text-align: left; display: block;">Masukkan Keluhan</label>
                        <textarea name="isi_keluhan" id="isi_keluhan" class="form-control" rows="5" placeholder="Tuliskan keluhan di sini" required></textarea>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <button type="submit" class="btn btn-primary mb-2 w-100">Kirim</button>
                        <a href="lihat_keluhan.php" class="btn btn-secondary w-100">Lihat</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="footer-kontak">
            <h3>Kontak Kami</h3>
            <p>Email: haventech@startup.ac.id</p>
            <p>Telepon: 088764349532 </p>
            <p>Alamat: Yogyakarta</p>
        </div>
        <div class="footer-kontak">
            <h3>Link</h3>
            <div class="footer-link">
                <a href="home.php">Home</a>
                <a href="about.html">Tentang Kami</a>
                <a href="produk.php">Produk</a>
                <a href="kontak.html">Kontak</a>
            </div>
        </div>
        <div class="footer-kontak">
            <h3>Ikuti Kami</h3>
            <div class="footer-icon">
                <a href="https://www.instagram.com/"><img src="../asset/icon1.png"></a>
                <a href="https://www.facebook.com/?locale=id_ID"><img src="../asset/icon2.png"></a>
                <a href="https://x.com/?lang=id"><img src="../asset/icon3.png"></a>
            </div>
        </div>
    </footer>
    <div class="footer-copyright">
        &copy;2024 Febry Vallentihanto | Diki Prasetia Dekanata | Anas Abiyyu Falah | Muhammad Rizqy Wahyu Kurniawan | Satrio Hayu Wibowo | All rights reserved
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>