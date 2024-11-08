<?php
$host = "sql312.infinityfree.com";      // Nama host database
$user = "if0_37676231";           // Nama pengguna database
$password = "hShqFFkDGT";           // Kata sandi database
$dbname = "if0_37676231_resep_nusantara";  // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
