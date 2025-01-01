<?php
session_start();
include('../config.php');

$idkategori = $_GET['id_kategori'] ?? '';

$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';

$idkategori ? $query = "SELECT * FROM produk WHERE id_kategori = $idkategori" : $query = "SELECT * FROM produk ";
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
  <title>Produk</title>
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
    <h2 class="text-center text-black mb-5 fw-bold">Daftar Produk</h2>
    <div class="row row-cols-1 row-cols-md-4 g-4">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col">
          <div class="card shadow border-0" style="background-color: #1f48c2; color: white; border-radius: 10px; height: 100%;">
            <div class="position-absolute bg-light text-uppercase fw-bold px-2 py-1 text-primary" style="top: 10px; left: 10px; font-size: 0.8rem; border-radius: 5px;">
              Best Seller
            </div>
            <img src="../asset/uploads/<?= !empty($row['gambar_produk']) ? htmlspecialchars($row['gambar_produk']) : 'default.png'; ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_produk']); ?>" style="height: 200px; object-fit: cover; border-radius: 10px 10px 0 0;">
            <div class="card-body text-center">
              <h5 class="card-title"><?= htmlspecialchars($row['nama_produk']); ?></h5>
              <p class="mb-2">Stok: <?= htmlspecialchars($row['stok']); ?></p>
              <h6 class="fw-bold text-warning">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></h6>
              <a href="detail_produk.php?id_produk=<?= $row['id_produk']; ?>"
                class="btn text-black px-3 py-1 mt-3"
                style="background-color: white; color: black;">Detail</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
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