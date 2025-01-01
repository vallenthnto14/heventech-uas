<?php
session_start();
include('../config.php');
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';
$sql = "SELECT id_pesanan, id_pengguna, tanggal_pesanan, total_harga, status FROM pesanan ORDER BY tanggal_pesanan DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan</title>
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
        <h1 class="text-center mb-5">Kelola Pesanan</h1>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Pesanan</th>
                    <th>ID Pengguna</th>
                    <th>Tanggal Pesanan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Kelola</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_pesanan']) ?></td>
                            <td><?= htmlspecialchars($row['id_pengguna']) ?></td>
                            <td><?= htmlspecialchars(date("d-m-Y H:i", strtotime($row['tanggal_pesanan']))) ?></td>
                            <td>IDR <?= htmlspecialchars(number_format($row['total_harga'], 2, ',', '.')) ?></td>
                            <td>
                                <span class="badge bg-<?= getStatusBadgeClass($row['status']) ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td>
                                <form action="proses_pesanan.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id_pesanan" value="<?= htmlspecialchars($row['id_pesanan']) ?>">
                                    <select name="status" class="form-select form-select-sm d-inline w-auto">
                                        <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Diproses" <?= $row['status'] === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                        <option value="Dikirim" <?= $row['status'] === 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
                                        <option value="Selesai" <?= $row['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                        <option value="Dibatalkan" <?= $row['status'] === 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                                    </select>
                                    <button type="submit" class="btn btn-warning btn-sm ms-2">Ubah</button>
                                </form>
                                <form action="hapus_pesanan.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id_pesanan" value="<?= htmlspecialchars($row['id_pesanan']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm ms-2" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    function getStatusBadgeClass($status)
    {
        switch ($status) {
            case 'Selesai':
                return 'success';
            case 'Diproses':
            case 'Dikirim':
                return 'info';
            case 'Dibatalkan':
                return 'danger';
            default:
                return 'warning';
        }
    }
    ?>

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
    </div>
</body>

</html>
<?php $conn->close(); ?>