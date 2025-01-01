<?php
session_start();
include('../config.php');
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';

$query = "SELECT 
            produk.id_produk AS id_produk, 
            produk.nama_produk, 
            produk.harga, 
            produk.stok, 
            produk.gambar_produk, 
            kategori.nama_kategori 
          FROM produk 
          JOIN kategori ON produk.id_kategori = kategori.id_kategori";
$result = $conn->query($query);
if (!$result) {
  die("Query gagal: " . $conn->error);
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/home.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-lg-top">
      <div class="container-fluid">
        <div class="d-flex align-items-center">
          <div class="logo me-3">
            <a href="admin_home.php">
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
              <a class="nav-link" href="admin_home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="admin_produk.php">Produk</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="kelola_pesanan.php">Pesanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="konfirmasi_pembayaran.php">Pembayaran</a>
            </li>
          </ul>
          <div class="auth">
            <a class="btn btn-primary" href="../pengguna/login_worker.php">Logout</a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <div class="container my-5">
    <h1 class="text-center mb-5">Daftar Produk</h1>
    <div class="mb-4 d-flex justify-content-start">
      <a href="tambah_produk.php" class="btn btn-success">Tambah Produk</a>
    </div>
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th style="text-align: center; width: 15%;">Nama Kategori</th>
          <th style="text-align: center; width: 20%;">Nama Produk</th>
          <th style="text-align: center; width: 15%;">Harga</th>
          <th style="text-align: center; width: 10%;">Stok</th>
          <th style="text-align: center; width: 20%;">Gambar</th>
          <th style="text-align: center; width: 20%;">Kelola</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td style="text-align: center; vertical-align: middle; width: 15%;"><?= htmlspecialchars($row['nama_kategori']) ?></td>
            <td style="text-align: center; vertical-align: middle; width: 20%;"><?= htmlspecialchars($row['nama_produk']) ?></td>
            <td style="text-align: center; vertical-align: middle; width: 15%;">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td style="text-align: center; vertical-align: middle; width: 10%;"><?= htmlspecialchars($row['stok']) ?></td>
            <td style="text-align: center; vertical-align: middle; width: 20%;">
              <?php if (!empty($row['gambar_produk'])): ?>
                <img src="../asset/uploads/<?= htmlspecialchars($row['gambar_produk']) ?>" alt="Gambar" style="width: 100px; height: 100px; object-fit: contain;">
              <?php else: ?>
                <span>Gambar tidak tersedia</span>
              <?php endif; ?>
            </td>
            <td style="text-align: center; vertical-align: middle; width: 20%;">
              <a href="edit_produk.php?id_kategori=<?= htmlspecialchars($row['id_produk']) ?>" class="btn btn-primary btn-sm me-2">Edit</a>
              <form method="post" action="hapus_produk.php" style="display: inline;">
                <input type="hidden" name="id_produk" value="<?= htmlspecialchars($row['id_produk']) ?>">
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
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
        <a href="admin_home.php">Home</a>
        <a href="admin_produk.php">Produk</a>
        <a href="kelola_pesanan.php">Pesanan</a>
        <a href="konfirmasi_pembayaran.php">Pembayaran</a>
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