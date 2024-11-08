<?php
require 'db_connect.php'; // File koneksi database

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "resep_nusantara";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idResep = $_POST['idResep'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $bahan = $_POST['bahan'];
    $instruksi = $_POST['instruksi'];

    // Handle image upload if there is a new image
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . "/uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        $gambar = basename($_FILES["gambar"]["name"]);
    }

    // Update query
    if ($gambar) {
        $sql = "UPDATE resep SET nama = ?, kategori = ?, deskripsi = ?, bahan = ?, instruksi = ?, gambar = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $nama, $kategori, $deskripsi, $bahan, $instruksi, $gambar, $idResep);
    } else {
        $sql = "UPDATE resep SET nama = ?, kategori = ?, deskripsi = ?, bahan = ?, instruksi = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nama, $kategori, $deskripsi, $bahan, $instruksi, $idResep);
    }

    if ($stmt->execute()) {
        echo "Resep berhasil diperbarui!";
        header("Location: adminPage.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
