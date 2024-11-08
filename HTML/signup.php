<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);

    $conn = new mysqli("localhost", "root", "", "resep_nusantara");

    if ($conn->connect_error) {
        echo "<script>alert('Koneksi gagal: " . $conn->connect_error . "');</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registrasi berhasil!');
                window.location.href = 'register.html';  
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal! Silakan coba lagi.');
                window.location.href = 'login.html'; 
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
