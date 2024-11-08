<?php
session_start();
require 'db_connect.php'; // File koneksi database

// Cek apakah pengguna sudah login dan apakah mereka admin
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.html"); // Redirect ke halaman login jika bukan admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adminPage.css">
    <title>Dashboard Admin</title>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><b><a href="#" class="button" onclick="showSection('tambahResep')">Menambahkan Resep</a></b></li>
                <li><b><a href="#" class="button" onclick="showSection('lihatResep')">Melihat Resep</a></b></li>
                <li><b><a href="#" class="button" onclick="showSection('hapusResep')">Hapus Resep</a></b></li>
                <li><b><a href="#" class="button" onclick="showSection('editResep')">Edit Resep</a></b></li>
                <li><b><a href="#" class="button" onclick="showSection('tampilkanPengguna')">Tampilkan Pengguna</a></b></li>
            </ul>
        </div>
        
        <main class="main-content">
            <header>
                <h1>Dashboard Admin</h1>
            </header>
            <section id="dashboard" class="content-section">
                <h2>selamat datang admin</h2>
            </section>

            <section id="tambahResep" class="content-section" style="display: none;">
            <form action="proses_tambah.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="recipe-name">Nama Resep:</label>
        <input type="text" name="nama" required>
    </div>
    <div class="form-group">
    <label for="kategori">Jenis Makanan:</label>
    <select name="kategori" id="kategori">
        <option value="makanan ringan">Makanan Ringan</option>
        <option value="makanan berat">Makanan Berat</option>
    </select>
</div>

    <div class="form-group">
        <label for="describe">deskripsi:</label>
        <textarea name="deskripsi" required></textarea>
    </div>
    <div class="form-group">
        <label for="ingredients">Bahan:</label>
        <textarea name="bahan" required></textarea>
    </div>
    <div class="form-group">
        <label for="instructions">Instruksi:</label>
        <textarea name="instruksi" required></textarea>
    </div>
    <div class="form-group">
        <label for="gambar">Gambar:</label>
        <input type="file" name="gambar" required>
    </div>
    <button class="btn" type="submit">Tambah Resep</button>
</form>
            </section>
<!-- lihat resep -->
            <section id="lihatResep" class="content-section" style="display: none;">
    <h2>Daftar Resep</h2>
    <div class="recipe-list">
        <?php
        // $conn = new mysqli("localhost", "root", "", "resep_nusantara");
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        require 'db_connect.php';
        $sql = "SELECT * FROM resep";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Nama Resep</th>
                        <th>Gambar</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . htmlspecialchars($row["nama"], ENT_QUOTES) . "</td>
                        <td><img src='" . $row["gambar"] . "' alt='" . htmlspecialchars($row["nama"], ENT_QUOTES) . "' width='100'></td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada resep yang tersedia.</p>";
        }

        $conn->close();
        ?>
    </div>
</section>

            <!-- hapus -->
            <section id="hapusResep" class="content-section" style="display: none;">
    <h2>Hapus Resep</h2>
    <form action="proses_hapus.php" method="post">
        <label for="idResep">Pilih Resep untuk Dihapus:</label>
        <select name="idResep" id="idResep" required>
            <?php
            // Menampilkan daftar resep dari database
            // $conn = new mysqli("localhost", "root", "", "resep_nusantara");
            // if ($conn->connect_error) {
            //     die("Connection failed: " . $conn->connect_error);
            // }
            require 'db_connect.php'; // File koneksi database

            $sql = "SELECT id, nama FROM resep";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nama"], ENT_QUOTES) . "</option>";
                }
            } else {
                echo "<option>Tidak ada resep</option>";
            }
            $conn->close();
            ?>
        </select>
        <button class="btn" type="submit">Hapus Resep</button>
    </form>
</section>

            <!-- edit -->
<section id="editResep" class="content-section" style="display: none;">
    <h2>Edit Resep</h2>
    <form action="proses_edit.php" method="post" enctype="multipart/form-data">
        <label for="idResep">Pilih Resep untuk Diedit:</label>
        <select name="idResep" id="idResep" required>
            <?php
            // $conn = new mysqli("localhost", "root", "", "resep_nusantara");
            // if ($conn->connect_error) {
            //     die("Connection failed: " . $conn->connect_error);
            // }
            require 'db_connect.php'; // File koneksi database

            $sql = "SELECT id, nama FROM resep";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nama"], ENT_QUOTES) . "</option>";
                }
            } else {
                echo "<option>Tidak ada resep</option>";
            }
            $conn->close();
            ?>
        </select>

        <div class="form-group">
            <label for="nama">Nama Resep:</label>
            <input type="text" name="nama" id="nama" required>
        </div>

        <div class="form-group">
            <label for="kategori">Jenis Makanan:</label>
            <select name="kategori" id="kategori">
                <option value="makanan ringan">Makanan Ringan</option>
                <option value="makanan berat">Makanan Berat</option>
            </select>
        </div>
        <div class="form-group">
            <label for="describe">deskripsi:</label>
            <textarea name="deskripsi" required></textarea>
        </div>
        <div class="form-group">
            <label for="bahan">Bahan:</label>
            <textarea name="bahan" id="bahan" ></textarea>
        </div>

        <div class="form-group">
            <label for="instruksi">Instruksi:</label>
            <textarea name="instruksi" id="instruksi" ></textarea>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar (opsional):</label>
            <input type="file" name="gambar" id="gambar">
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
</section>


            
<!-- <section id="hapusReview" class="content-section" style="display: none;">
    <h2>Hapus Review</h2>
    <p>Pilih review yang ingin dihapus.</p>
</section> -->
            <!-- user -->
<section id="tampilkanPengguna" class="content-section" style="display: none;">
    <h2>Daftar Pengguna</h2>
    <div class="recipe-list">
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                // $conn = new mysqli("localhost", "root", "", "resep_nusantara");
                
                // Periksa koneksi
                // if ($conn->connect_error) {
                //     die("Connection failed: " . $conn->connect_error);
                // }
                require 'db_connect.php'; // File koneksi database

                // Query untuk mengambil data pengguna
                $sql = "SELECT id, username, email FROM users WHERE role = 'user' ";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    // Loop untuk menampilkan data pengguna
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["id"], ENT_QUOTES) . "</td>
                                <td>" . htmlspecialchars($row["username"], ENT_QUOTES) . "</td>
                                <td>" . htmlspecialchars($row["email"], ENT_QUOTES) . "</td>
                                <td>
                                    <form action='proses_hapus_pengguna.php' method='post' style='display: inline;'>
                                        <input type='hidden' name='idPengguna' value='" . htmlspecialchars($row["id"], ENT_QUOTES) . "'>
                                        <button class='btn' type='submit' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pengguna ini?\")'>Hapus</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada pengguna.</td></tr>";
                }

                // Tutup koneksi
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</section>



            
        </main>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>
