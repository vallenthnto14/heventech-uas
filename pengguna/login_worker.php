<?php
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = trim($_POST['key']); 

    if (empty($key)) {
        $error = "Kunci wajib diisi.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM worker WHERE `KEY` = ?");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            $_SESSION['worker_user_id'] = $user['id'];
            $_SESSION['worker_role'] = $user['ROLE'];

            if ($user['ROLE'] === 'ADMIN') {
                header("Location: ../admin/admin_home.php");
            } elseif ($user['ROLE'] === 'CS') {
                header("Location: ../cs/cs_home.php");
            } else {
                $error = "Role tidak valid.";
            }
            exit();
        } else {
            $error = "Kunci tidak valid.";
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Worker</title>
    <link rel="stylesheet" href="login.css"> 
</head>
<body>
    <div class="login-container">
        <h1>Login Worker</h1>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="login_worker.php">
            <label for="key">Masukkan Kunci</label>
            <input type="text" name="key" placeholder="Kunci" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
