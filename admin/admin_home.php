<?php
session_start();
require_once '../config.php';
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';
$query = "SELECT * FROM kategori";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

    <main class="container py-4">
        <h1 class="mb-4 text-center">Selamat Datang, Admin</h1>
        <section class="mb-5">
            <h2 class="mb-3">Manajemen Kategori</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nama Kategori</th>
                            <th>Gambar</th>
                            <th>Kelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $row['id_kategori'] ?></td>
                                <td class="align-middle"><?= htmlspecialchars($row['nama_kategori']); ?></td>
                                <td class="text-center align-middle">
                                    <img src="../asset/uploads/<?= htmlspecialchars($row['Gambar_kategori']); ?>" alt="Gambar Kategori" class="img-thumbnail" style="width: 100px; height: auto;">
                                </td>
                                <td class="text-center align-middle">
                                    <a href="admin_home.php?edit_id=<?= $row['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="proses_upload.php?id_kategori=<?= $row['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php if (isset($_GET['edit_id'])): ?>
            <?php
            $edit_id = $_GET['edit_id'];
            $edit_query = "SELECT * FROM kategori WHERE id_kategori = $edit_id";
            $edit_result = $conn->query($edit_query);
            $edit_data = $edit_result->fetch_assoc();
            ?>
            <section class="mb-5">
                <h2 class="mb-3 text-center">Edit Kategori</h2>
                <form action="proses_upload.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded bg-light col-md-6 mx-auto">
                    <input type="hidden" name="id_kategori" value="<?= $edit_data['id_kategori']; ?>">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama_kategori" value="<?= $edit_data['nama_kategori']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_kategori" class="form-label">Upload Gambar (Opsional)</label>
                        <input type="file" class="form-control" name="gambar_kategori">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </section>
        <?php else: ?>
            <section class="mb-5">
                <h2 class="mb-3 text-center">Tambah Kategori</h2>
                <form action="proses_upload.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded bg-light col-md-6 mx-auto">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama_kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_kategori" class="form-label">Upload Gambar</label>
                        <input type="file" class="form-control" name="gambar_kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </section>
        <?php endif; ?>
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