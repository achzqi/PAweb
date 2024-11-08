<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    // Cek jika username dan password adalah "admin" untuk akses ke adminPage.php
    if ($usernameOrEmail === 'admin' && $password === 'admin') {
        $_SESSION['user_id'] = 'admin'; // Set sesi khusus untuk admin
        $_SESSION['username'] = 'admin';
        header("Location: adminPage.php");  // Arahkan ke halaman admin
        exit();
    }

    // Jika bukan admin, lanjutkan pemeriksaan di database untuk pengguna biasa
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $usernameOrEmail;
            header("Location: landingpage.php");  // Arahkan ke landing page untuk pengguna biasa
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username atau email tidak ditemukan!";
    }
}
?>
