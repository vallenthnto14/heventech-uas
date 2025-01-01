<?php
session_start();
include('../config.php');
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'CS';
$query = "SELECT keluhan.*, pengguna.nama FROM keluhan 
          JOIN pengguna ON keluhan.id_user = pengguna.id";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <div class="logo me-3">
                        <a href="cs_home.php">
                            <img src="../asset/logo.png" alt="logo" height="40">
                        </a>
                    </div>
                    <a class="navbar-brand ms-2" href="cs_home.php">HavenTech</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="cs_home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="daftar_keluhan.php">Daftar Keluhan</a>
                        </li>
                    </ul>
                </div>
                <div class="auth">
                    <a class="btn btn-primary me-2" href="../pengguna/login_worker.php">logout</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <h2 class="text-center my-4 text-dark">Daftar Keluhan</h2>
        <div class="text-center mb-4"></div>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Nama Pengguna</th>
                            <th class="text-center">Subjek</th>
                            <th class="text-center">Isi Keluhan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanggal Kirim</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center align-middle"><?= htmlspecialchars($row['nama']) ?></td>
                                <td class="text-center align-middle"><?= htmlspecialchars($row['subjek']) ?></td>
                                <td class="text-center align-middle"><?= htmlspecialchars($row['isi_keluhan']) ?></td>
                                <td class="text-center align-middle">
                                    <span class="badge bg-<?= getStatusBadgeClass($row['status']) ?>">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>
                                </td>
                                <td class="text-center align-middle"><?= htmlspecialchars($row['tanggal_kirim']) ?></td>
                                <td class="text-center align-middle">
                                    <!-- Form to update the status of the complaint -->
                                    <form method="POST" action="update_status_keluhan.php" class="d-inline">
                                        <input type="hidden" name="id_keluhan" value="<?= htmlspecialchars($row['id_keluhan']) ?>">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="Diterima" <?= $row['status'] === 'Diterima' ? 'selected' : '' ?>>Diterima</option>
                                            <option value="Ditolak" <?= $row['status'] === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                        </select>
                                        <button type="submit" class="btn btn-warning btn-sm mt-2">Update</button>
                                    </form>

                                    <!-- Form to delete the complaint -->
                                    <form method="POST" action="hapus_keluhan.php" class="d-inline">
                                        <input type="hidden" name="id_keluhan" value="<?= htmlspecialchars($row['id_keluhan']) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Apakah Anda yakin ingin menghapus keluhan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        function getStatusBadgeClass($status)
        {
            switch ($status) {
                case 'Diterima':
                    return 'success';
                case 'Ditolak':
                    return 'danger';
                default:
                    return 'warning';
            }
        }
        ?>
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
                <a href="cs_home.php">Home</a>
                <a href="daftar_keluhan.php">Daftar Keluhan</a>
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