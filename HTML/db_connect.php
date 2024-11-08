<?php
$host = "localhost";      // Nama host database
$user = "root";           // Nama pengguna database
$password = "";           // Kata sandi database
$dbname = "resep_nusantara";  // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
