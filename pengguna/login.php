<?php
session_start();
require_once '../config.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi.";
    } else {
        $email = $conn->real_escape_string($email); 
        $query = "SELECT * FROM pengguna WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nama'];
                $_SESSION['user_role'] = $user['role'];
                if ($user['role'] === 'Admin') {
                    header("Location: ../home/home.php");
                } else {
                    header("Location: ../home/home.php");
                }
                exit();
            } else {
                $error = "Email atau password salah.";
            }
        } else {
            $error = "Email atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> 
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <label for="name">Masukkan Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <label for="name">Masukkan Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="signup.php">Daftar di sini</a></p>
    </div>
</body>
</html>
