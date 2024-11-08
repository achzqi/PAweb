<?php
// Ambil ID pengguna yang akan dihapus
if (isset($_POST['idPengguna'])) {
    $idPengguna = $_POST['idPengguna'];
    require 'db_connect.php'; // File koneksi database

    // // Koneksi ke database
    // $conn = new mysqli("localhost", "root", "", "resep_nusantara");

    // // Periksa koneksi
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    // SQL query untuk menghapus pengguna
    $sql = "DELETE FROM users WHERE id = ?";

    // Menyiapkan dan mengeksekusi query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $idPengguna); // Bind parameter ID pengguna
        if ($stmt->execute()) {
            echo "<script>alert('Pengguna berhasil dihapus!'); window.location.href='adminPage.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menghapus pengguna.'); window.location.href='adminPage.php';</script>";
        }
    } else {
        echo "<script>alert('Terjadi kesalahan saat mempersiapkan query.'); window.location.href='adminPage.php';</script>";
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo "<script>alert('ID pengguna tidak ditemukan.'); window.location.href='adminPage.php';</script>";
}
?>
