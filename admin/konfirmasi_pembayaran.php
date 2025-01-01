<?php
session_start();
include('../config.php');
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';
$query = "SELECT 
            bayar.id_bayar, 
            bayar.id_pesanan, 
            bayar.metode_bayar, 
            bayar.status_bayar, 
            bayar.tanggal_bayar, 
            bayar.bukti_bayar, 
            pesanan.total_harga
          FROM bayar
          JOIN pesanan ON bayar.id_pesanan = pesanan.id_pesanan";

$result = $conn->query($query);
if (!$result) {
  die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Pembayaran</title>
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

  <main>
    <div class="container my-5">
      <h1 class="text-center mb-5">Konfirmasi Pembayaran</h1>
      <table class="table table-bordered table-striped text-center table-hover">
        <thead class="table-dark">
          <tr>
            <th>ID Bayar</th>
            <th>ID Pesanan</th>
            <th>Metode Bayar</th>
            <th>Status Bayar</th>
            <th>Tanggal Bayar</th>
            <th>Total Harga</th>
            <th>Bukti Bayar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="align-middle">
                <td><?= htmlspecialchars($row['id_bayar']) ?></td>
                <td><?= htmlspecialchars($row['id_pesanan']) ?></td>
                <td><?= htmlspecialchars($row['metode_bayar']) ?></td>
                <td><?= htmlspecialchars($row['status_bayar']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_bayar']) ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td>
                  <?php if (!empty($row['bukti_bayar'])): ?>
                    <img src="../asset/uploads/<?= htmlspecialchars($row['bukti_bayar']) ?>" alt="Bukti Bayar" class="img-fluid" style="max-width: 100px; max-height: 100px; object-fit: contain;">
                  <?php else: ?>
                    <span>Tidak ada bukti</span>
                  <?php endif; ?>
                </td>
                <td>
                  <form method="post" action="proses_konfirmasi.php">
                    <input type="hidden" name="id_bayar" value="<?= htmlspecialchars($row['id_bayar']) ?>">
                    <select name="status_bayar" class="form-select mb-2">
                      <option value="Menunggu Konfirmasi" <?= $row['status_bayar'] === 'Menunggu Konfirmasi' ? 'selected' : '' ?>>Menunggu Konfirmasi</option>
                      <option value="Sudah Dibayar" <?= $row['status_bayar'] === 'Sudah Dibayar' ? 'selected' : '' ?>>Sudah Dibayar</option>
                      <option value="Belum Dibayar" <?= $row['status_bayar'] === 'Belum Dibayar' ? 'selected' : '' ?>>Belum Dibayar</option>
                    </select>
                    <button type="submit" class="btn btn-success">Simpan</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center">Belum ada data pembayaran.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
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