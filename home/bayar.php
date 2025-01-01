<?php
session_start();
include('../config.php');
if (!isset($_SESSION['user_id'])) {
  die("Silakan login terlebih dahulu.");
}

$id_pengguna = $_SESSION['user_id'];
if (isset($_POST['id_keranjang']) || isset($_GET['id_keranjang'])) {
  $id_keranjang = $_POST['id_keranjang'] ?? $_GET['id_keranjang'];
  $query = "SELECT k.id, p.nama_produk, k.harga, k.jumlah, (k.harga * k.jumlah) AS total_harga 
              FROM keranjang k
              JOIN produk p ON k.id_produk = p.id_produk
              WHERE k.id_pengguna = ? AND k.id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ii", $id_pengguna, $id_keranjang);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $produk_keranjang = $result->fetch_assoc();
    $total_bayar = $produk_keranjang['total_harga'];
  } else {
    echo "<script>alert('Produk yang dipilih tidak valid. Silakan kembali ke keranjang.');</script>";
    header("Location: keranjang.php");
    exit;
  }
} else {
  echo "<script>alert('ID keranjang tidak ditemukan. Silakan kembali ke keranjang.');</script>";
  header("Location: keranjang.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bukti_bayar'])) {
  $query_pesanan = "INSERT INTO pesanan (id_pengguna, tanggal_pesanan, total_harga, status) VALUES (?, ?, ?, ?)";
  $stmt_pesanan = $conn->prepare($query_pesanan);
  $status = 'Pending';
  $tanggal_pesanan = date('Y-m-d H:i:s');
  $stmt_pesanan->bind_param("isss", $id_pengguna, $tanggal_pesanan, $total_bayar, $status);
  $stmt_pesanan->execute();
  $id_pesanan = $conn->insert_id;
  $bukti_bayar = $_FILES['bukti_bayar'];
  $gambar_produk = time() . '_' . $bukti_bayar['name'];
  $target_dir = __DIR__ . '/../asset/uploads/';
  $gambar_path = $target_dir . $gambar_produk;


  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
  }

  if (move_uploaded_file($bukti_bayar['tmp_name'], $gambar_path)) {
    $query_bayar = "INSERT INTO bayar (id_pengguna, total_bayar, id_pesanan, metode_bayar, status_bayar, tanggal_bayar, bukti_bayar) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_bayar = $conn->prepare($query_bayar);
    $status_bayar = 'Menunggu Konfirmasi';
    $metode_bayar = $_POST['metode_bayar'] ?? 'Transfer Bank';
    $tanggal_bayar = date('Y-m-d H:i:s');
    $stmt_bayar->bind_param("iidssss", $id_pengguna, $total_bayar, $id_pesanan, $metode_bayar, $status_bayar, $tanggal_bayar, $gambar_produk);
    $stmt_bayar->execute();

    header("Location: pesanan.php");
    exit;
  } else {
    echo "<script>alert('Gagal mengunggah bukti pembayaran.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran</title>
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
    <h1 class="text-center mb-4">Pesanan Belanja</h1>
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>Nama Produk</th>
          <th>Harga Satuan</th>
          <th>Jumlah</th>
          <th>Total Harga</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?= htmlspecialchars($produk_keranjang['nama_produk']) ?></td>
          <td>Rp <?= number_format($produk_keranjang['harga'], 0, ',', '.') ?></td>
          <td><?= $produk_keranjang['jumlah'] ?></td>
          <td>Rp <?= number_format($produk_keranjang['total_harga'], 0, ',', '.') ?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3">Total Bayar</th>
          <th>Rp <?= number_format($total_bayar, 0, ',', '.') ?></th>
        </tr>
      </tfoot>
    </table>

    <form method="post" enctype="multipart/form-data" class="mt-4">
      <input type="hidden" name="id_keranjang" value="<?= $id_keranjang; ?>">
      <div class="mb-3 text-end">
        <label for="metode_bayar" class="form-label"><strong>Pembayaran:</strong></label>
        <select id="metode_bayar" name="metode_bayar" class="form-select d-inline-block" style="width: 280px;" required>
          <option value="">Pilih Metode</option>
          <option value="Transfer Bank">Transfer Bank</option>
          <option value="Kartu Kredit">Kartu Kredit</option>
          <option value="E-Wallet">E-Wallet</option>
        </select>
      </div>
      <div class="mb-3 text-end">
        <label for="bukti_bayar" class="form-label"><strong>Upload Bukti:</strong></label>
        <input type="file" class="form-control d-inline-block" style="width: 280px;" name="bukti_bayar" id="bukti_bayar" required>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-success">Kirim Bukti</button>
      </div>
    </form>
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