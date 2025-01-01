<?php
session_start();
include('../config.php');
if (!isset($_SESSION['user_id'])) {
    die("Silakan login terlebih dahulu.");
}

$id_pengguna = $_SESSION['user_id'];
if (!isset($_GET['id_pesanan']) || empty($_GET['id_pesanan'])) {
    die("ID Pesanan tidak valid.");
}

$id_pesanan = intval($_GET['id_pesanan']);
$query = "SELECT * FROM view_pesanan_detail WHERE id_pesanan = ? AND status_bayar = 'Sudah Dibayar'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pesanan);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div class="container my-5">
        <h1 class="text-center mb-4">Detail Pesanan</h1>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Status Pembayaran</th>
                    <th>Total Pembayaran</th>
                    <th>Tanggal Pesanan</th>
                    <th>Status Pesanan</th>
                    <th>Nama Pengguna</th>
                    <th>Email Pengguna</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['status_bayar']) ?></td>
                            <td>IDR <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['tanggal_pesanan']) ?></td>
                            <td><?= htmlspecialchars($row['status_pesanan']) ?></td>
                            <td><?= htmlspecialchars($row['nama_pengguna']) ?></td>
                            <td><?= htmlspecialchars($row['email_pengguna']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada detail pesanan yang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>