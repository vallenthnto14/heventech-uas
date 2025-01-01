<?php
session_start();
include('../config.php');

$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_kategori = $_POST['id_kategori'];
  $nama_produk = $_POST['nama_produk'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];

  $gambar_produk = $_FILES['gambar_produk']['name'];
  $gambar_tmp = $_FILES['gambar_produk']['tmp_name'];
  $gambar_path = '../asset/uploads/' . $gambar_produk;

  if (move_uploaded_file($gambar_tmp, $gambar_path)) {
    $query = "INSERT INTO produk (id_kategori, nama_produk, deskripsi, harga, stok, gambar_produk) 
                  VALUES ('$id_kategori', '$nama_produk', '$deskripsi', '$harga', '$stok', '$gambar_produk')";

    if ($conn->query($query)) {
      header('Location: admin_produk.php');
    } else {
      echo "Error: " . $conn->error;
    }
  } else {
    echo "Error uploading image.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Produk</title>
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
    <div class="container my-5" style="max-width: 600px;">
      <h3 class="mb-4 text-center">Tambah Produk</h3>
      <div class="card" style="background-color: #f8f9fa;">
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="row mb-4">
              <div class="col-md-6">
                <label for="id_kategori" class="form-label fw-bold text-start d-block">Kategori</label>
                <select name="id_kategori" id="id_kategori" class="form-select" required>
                  <option value="">Pilih Kategori</option>
                  <?php
                  $kategori_result = $conn->query("SELECT id_kategori, nama_kategori FROM kategori");
                  while ($kategori = $kategori_result->fetch_assoc()) {
                    echo "<option value='" . $kategori['id_kategori'] . "'>" . htmlspecialchars($kategori['nama_kategori']) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="nama_produk" class="form-label fw-bold text-start d-block">Masukkan nama</label>
                <input type="text" class="form-control" name="nama_produk" placeholder="Masukkan nama produk" required>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-6">
                <label for="deskripsi" class="form-label fw-bold text-start d-block">Masukkan deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="4" placeholder="Masukkan deskripsi produk" required></textarea>
              </div>
              <div class="col-md-6">
                <label for="harga" class="form-label fw-bold text-start d-block">Masukkan harga</label>
                <input type="number" class="form-control" name="harga" placeholder="Masukkan harga produk" required>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-6">
                <label for="gambar_produk" class="form-label fw-bold text-start d-block">Upload gambar</label>
                <input type="file" class="form-control" name="gambar_produk" required>
              </div>
              <div class="col-md-6">
                <label for="stok" class="form-label fw-bold text-start d-block">Masukan stok</label>
                <input type="number" class="form-control" name="stok" placeholder="Masukkan jumlah stok" required>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-6">
                <button type="submit" class="btn btn-primary w-100">Simpan</button>
              </div>
              <div class="col-md-6">
                <a href="admin_produk.php" class="btn btn-danger w-100">Batal</a>
              </div>
            </div>
          </form>
        </div>
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