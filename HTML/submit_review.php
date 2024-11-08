<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "Silakan login untuk menambahkan review.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resep_id = $_POST['resep_id'];
    $user_id = $_SESSION['user_id'];
    $komentar = $_POST['komentar'];

    if (!empty($komentar)) {
        $stmt = $conn->prepare("INSERT INTO review (resep_id, user_id, komentar) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $resep_id, $user_id, $komentar);
        $stmt->execute();
        header("Location: detail.php?id=" . $resep_id);  // Redirect back to the recipe detail page
    } else {
        echo "Komentar tidak boleh kosong!";
    }
}
?>
