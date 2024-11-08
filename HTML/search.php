<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/search.css">   
    <title>Resep Nusantara</title>
</head>
<body>
    <header>
        <div class="container">
            <h1 class="logo">RESEP NUSANTARA</h1>
            <nav>
                <ul class="nav-list">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="aboutus.html">About</a></li>
                    <li><a href="#footer">Contact</a></li>
                    <li><a href="login.html">👤</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <section class="hero">
    <div class="hero">
        <h2>Selamat Datang Di Galeri Resep Nusantara!</h2>
        <p>Carilah resep menu yang kalian inginkan</p>

        <!-- Search Form -->
        <form action="search.php" method="GET" class="search-box">
            <input type="text" name="query" placeholder="Search Recipe">
            <button type="submit">Search</button>
        </form>
    </div>
</section>


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

// Get search query from URL if exists
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Sanitize the query to prevent SQL injection
$query = $conn->real_escape_string($query);

// If a search query exists, we modify the SQL to filter by name
$sql = "SELECT * FROM resep WHERE nama LIKE '%$query%'";
$result = $conn->query($sql);

// Fetch the recipes
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='recipe-card'>";
        echo "<img src='" . $row["gambar"] . "' alt='" . htmlspecialchars($row["nama"], ENT_QUOTES) . "'>";
        echo "<h2>" . htmlspecialchars($row["nama"], ENT_QUOTES) . "</h2>";
        echo "<p>" . htmlspecialchars($row["deskripsi"], ENT_QUOTES) . "</p>";
        echo "<a href='detail.php?id=" . $row["id"] . "'>Lihat Resep</a>";
        echo "</div>";
    }
} else {
    echo "<p>No recipes found for '$query'.</p>";
}

$conn->close();
?>
