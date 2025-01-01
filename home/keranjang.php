<?php
session_start();
include('../config.php');
if (!isset($_SESSION['user_id'])) {
  die("Silakan login terlebih dahulu.");
}

$id_pengguna = $_SESSION['user_id'];
$query = "SELECT k.id, p.nama_produk, k.harga, k.jumlah, (k.harga * k.jumlah) AS total_harga 
          FROM keranjang k
          JOIN produk p ON k.id_produk = p.id_produk
          WHERE k.id_pengguna = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pesanan</title>
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
    <h1 class="text-center mb-5">Keranjang Belanja</h1>
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>Nama Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Total Harga</th>
          <th>Kelola</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
            <td style="text-align: center;">
              <form action="bayar.php" method="post" style="display: inline;">
                <input type="hidden" name="id_keranjang" value="<?= $row['id']; ?>">
                <button type="submit" class="btn btn-primary btn-sm me-2">Beli Sekarang</button>
              </form>
              <form action="hapus_keranjang.php" method="post" style="display: inline;">
                <input type="hidden" name="id_keranjang" value="<?= $row['id']; ?>">
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>