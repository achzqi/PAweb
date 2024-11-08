<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resep_nusantara";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form saat ada data yang dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $bahan = $_POST['bahan'];
    $instruksi = $_POST['instruksi'];
    $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : null;


    // Mengelola upload gambar
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);

    $gambar = $target_file;

    // Menyimpan data ke tabel
    $sql = "INSERT INTO resep (nama, deskripsi, bahan, instruksi, gambar, kategori) VALUES ('$nama','$deskripsi', '$bahan', '$instruksi', '$gambar', '$kategori')";

    if ($conn->query($sql) === TRUE) {
        echo "Resep berhasil ditambahkan!";
        header("Location: adminPage.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Resep</title>
</head>
<body>
    <h2>Form Tambah Resep</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nama">Nama Resep:</label>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="bahan">Bahan:</label>
        <textarea id="bahan" name="bahan" required></textarea><br><br>

        <label for="instruksi">Instruksi:</label>
        <textarea id="instruksi" name="instruksi" required></textarea><br><br>

        <label for="kategori">Kategori:</label>
        <select name="kategori" id="kategori" required>
            <option value="Makanan Pembuka">Makanan Pembuka</option>
            <option value="Makanan Utama">Makanan Utama</option>
            <option value="Makanan Penutup">Makanan Penutup</option>
        </select><br><br>

        <label for="gambar">Gambar:</label>
        <input type="file" id="gambar" name="gambar" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
