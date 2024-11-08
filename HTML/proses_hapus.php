<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resep_nusantara";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idResep = $_POST['idResep'];

    // Query untuk menghapus resep berdasarkan ID
    $sql = "DELETE FROM resep WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idResep);

    if ($stmt->execute()) {
        echo "Resep berhasil dihapus!";
        header("Location: adminPage.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
