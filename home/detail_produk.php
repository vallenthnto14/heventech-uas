<?php
session_start();
include('../config.php');
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_pengguna = $_SESSION['user_id'];
  $id_produk = $_POST['id_produk'];
  $harga = $_POST['harga'];
  $jumlah = 1;
  $query_check = "SELECT id FROM keranjang WHERE id_produk = ? AND id_pengguna = ?";
  $stmt_check = $conn->prepare($query_check);
  $stmt_check->bind_param("ii", $id_produk, $id_pengguna);
  $stmt_check->execute();
  $result_check = $stmt_check->get_result();

  if ($result_check->num_rows > 0) {
    $query_update = "UPDATE keranjang SET jumlah = jumlah + ? WHERE id_produk = ? AND id_pengguna = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("iii", $jumlah, $id_produk, $id_pengguna);
    $stmt_update->execute();
  } else {
    $query_insert = "INSERT INTO keranjang (id_produk, id_pengguna, harga, jumlah) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($query_insert);
    $stmt_insert->bind_param("iidi", $id_produk, $id_pengguna, $harga, $jumlah);
    $stmt_insert->execute();
  }

  header("Location: keranjang.php");
  exit;
}
if (!isset($_GET['id_produk'])) {
  die("Data tidak lengkap. Harap akses halaman ini melalui link yang sesuai.");
}

$id_produk = $_GET['id_produk'];
$query = "SELECT p.nama_produk, p.deskripsi, p.harga, p.stok, p.gambar_produk 
          FROM produk p
          WHERE p.id_produk = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
} else {
  die("Produk tidak ditemukan.");
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Produk</title>
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

  <div class="container my-4">
    <h2 class="text-center text-black">Detail Produk</h2>
    <div class="card shadow border-0 mx-auto" style="background-color: #1f48c2; color: white; border-radius: 10px; max-width: 700px;">
      <div class="row g-0">
        <!-- Bagian Gambar -->
        <div class="col-md-5 position-relative">
          <div class="position-absolute bg-light text-uppercase fw-bold px-2 py-1 text-primary" style="top: 10px; left: 10px; font-size: 0.8rem; border-radius: 5px;">
            Best Seller
          </div>
          <img src="../asset/uploads/<?= !empty($row['gambar_produk']) ? htmlspecialchars($row['gambar_produk']) : 'default.png'; ?>"
            class="img-fluid rounded-start "
            alt="<?= htmlspecialchars($row['nama_produk']); ?>"
            style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px 0 0 10px;">
        </div>
        <div class="col-md-7">
          <div class="card-body">
            <h3 class="fw-bold" style="font-size: 1.25rem; margin-bottom: 0.5rem; text-align: left;">
              <?= htmlspecialchars($row['nama_produk']); ?>
            </h3>
            <p class="text-white-50" style="font-size: 0.9rem; line-height: 1.5; text-align: left;">
              <?= nl2br(htmlspecialchars($row['deskripsi'])); ?>
            </p>
            <div class="mt-3" style="text-align: left;">
              <h5 class="fw-bold" style="font-size: 1rem;">Harga</h5>
              <p class="text-warning" style="font-size: 1rem; font-weight: bold;">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
            </div>
            <div class="mt-3" style="text-align: left;">
              <h5 class="fw-bold" style="font-size: 1rem;">Stok</h5>
              <p class="text-white" style="font-size: 1rem;">
                <?= htmlspecialchars($row['stok']); ?> unit tersedia
              </p>
            </div>
            <form method="post" action="" class="mt-4" style="text-align: left;">
              <input type="hidden" name="harga" value="<?= $row['harga'] ?>">
              <input type="hidden" name="id_produk" value="<?= $id_produk ?>">
              <button type="submit" class="btn text-black px-3 py-1 mt-3"
                style="background-color: white; color: black; border-radius: 5px;">
                Keranjang
              </button>
            </form>
          </div>
        </div>
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