<?php
session_start();
require_once '../config.php';
if (!isset($_SESSION['worker_role']) || $_SESSION['worker_role'] !== 'CS') {
    header("Location: ../pengguna/login_worker.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/home.css">
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="logo me-3">
                    <a href="cs_home.php">
                        <img src="../asset/logo.png" alt="logo" height="40">
                    </a>
                </div>
                <a class="navbar-brand ms-2" href="cs_home.php">HavenTech</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                        <a class="nav-link" href="cs_home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="daftar_keluhan.php">Daftar Keluhan</a>
                    </li>
                </ul>
            </div>
            <div class="auth">
                <a class="btn btn-primary me-2" href="../pengguna/login_worker.php">logout</a>
            </div>
        </div>
    </nav>
</header>

<body class="bg-light">
    <div class="container my-5 d-flex justify-content-center">
        <div class="card shadow-lg border-0 w-50">
            <div class="card-body text-center py-4">
                <h1 class="display-6 fw-bold text-primary">Selamat Datang, Customer Service</h1>
                <p class="lead text-muted">Halaman ini khusus untuk Customer Service.</p>
            </div>
        </div>
    </div>

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
                <a href="cs_home.php">Home</a>
                <a href="daftar_keluhan.php">Daftar Keluhan</a>
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