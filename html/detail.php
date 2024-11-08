<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Silakan login untuk melihat detail resep.');
            window.location.href = 'login.html';
          </script>";
    exit();
}

// Ambil ID resep dari URL
$resep_id = $_GET['id'] ?? null;

if (!$resep_id) {
    echo "<p class='not-found'>Resep tidak ditemukan.</p>";
    exit();
}

// Ambil detail resep berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM resep WHERE id = ?");
$stmt->bind_param("i", $resep_id);
$stmt->execute();
$result = $stmt->get_result();
$resep = $result->fetch_assoc();

if (!$resep) {
    echo "<p class='not-found'>Resep tidak ditemukan.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Resep</title>
    <link rel="stylesheet" href="../css/detail.css"> <!-- Pastikan jalur CSS benar -->
</head>
<body>

<div class="recipe-detail">
    <h1><?php echo htmlspecialchars($resep['nama'], ENT_QUOTES); ?></h1>
    <img src="<?php echo htmlspecialchars($resep['gambar'], ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($resep['nama'], ENT_QUOTES); ?>" class="recipe-image">
    <p class="recipe-description"><?php echo htmlspecialchars($resep['deskripsi'], ENT_QUOTES); ?></p>
    <p class="recipe-category">Kategori: <?php echo htmlspecialchars($resep['kategori'], ENT_QUOTES); ?></p>

    <h4>Bahan-Bahan:</h4>
    <ul>
        <?php 
        $bahan = explode("\n", $resep["bahan"]); // Asumsikan bahan dipisah per baris
        foreach ($bahan as $item) {
            echo "<li>" . htmlspecialchars($item, ENT_QUOTES) . "</li>";
        }
        ?>
    </ul>

    <h3>Langkah-langkah Pembuatan:</h3>
    <ol>
        <?php 
        $instruksi = explode("\n", $resep["instruksi"]); // Asumsikan instruksi dipisah per baris
        foreach ($instruksi as $step) {
            echo "<li>" . htmlspecialchars($step, ENT_QUOTES) . "</li>";
        }
        ?>
    </ol>
    <div class="review-section">
    
    <?php if (isset($_SESSION['user_id'])): ?>
    <form action="submit_review.php" method="POST" class="review-form">
        <input type="hidden" name="resep_id" value="<?php echo $resep_id; ?>">
        <textarea name="komentar" rows="4" placeholder="Tambahkan review..." required></textarea>
        <button type="submit">Kirim Review</button>
    </form>
    <?php else: ?>
    <p class="not-found">Silakan login untuk menambahkan review.</p>
    <?php endif; ?>

    <h3>Review:</h3>
    <?php
    // Tampilkan review terkait
    $stmt = $conn->prepare("SELECT r.komentar, u.username FROM review r JOIN users u ON r.user_id = u.id WHERE r.resep_id = ?");
    $stmt->bind_param("i", $resep_id);
    $stmt->execute();
    $reviews = $stmt->get_result();

    if ($reviews->num_rows > 0) {
        while ($review = $reviews->fetch_assoc()) {
            echo "<div class='review'><strong>" . htmlspecialchars($review['username']) . ":</strong> " . htmlspecialchars($review['komentar']) . "</div>";
        }
    } else {
        echo "<p class='not-found'>Belum ada review.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
    
</div>
</div>


<button class='btn' onclick="window.location.href='landingpage.php'">kembali</button>
</body>
</html>
