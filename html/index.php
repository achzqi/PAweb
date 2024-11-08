


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Resep Nusantara</title>
</head>
<body>
    <header>
        <div class="container">
            <h1 class="logo">RESEP NUSANTARA</h1>
            <nav class="navbar">
            <ul class="nav-list">
                <li><a href="index.php">Home</a></li>
                <li><a href="aboutus.html">About</a></li>
                <li><a href="#footer">Contact</a></li>
                <li><a href="login.html">👤</a></li>
            </ul>
            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
        </div>
    </header>
    
    <section class="hero">
    <div class="hero">
        <h2>Selamat Datang Di Galeri Resep Nusantara!</h2>
        <p>Carilah resep menu yang kalian inginkan</p>

        <!-- Search Form -->
        <form action="index.php" method="GET" class="search-box">
        <input type="text" name="query" placeholder="Search Recipe" value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>">
        <button type="submit">Search</button>
        </form>
    </div>
</section>


    <section class="recipes">
        <h1>Featured Recipes</h1>
        <div class="recipe-section">
        <?php
        // $servername = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname = "resep_nusantara";

        require 'db_connect.php';
        // Create connection
        // $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }

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
                echo "</div>";
            }
        } else {
            echo "<p>No recipes found for '$query'.</p>";
        }

        $conn->close();
        ?> 
        </div>
    </section>

    <footer class="section-p1" id="footer">
        <div class="col">
            <h4>Contact</h4>
            <p><strong>Address: </strong>24434 Jl. Menuju Pintu Surga, Indonesia</p>
            <p><strong>Phone:</strong> +12 3456 7890</p>
        </div>
    </footer>

    <div class="copyright">
        <div>
            <p>&copy; Resep Nusantara. Made by Tiara, Zidan, Adie, Marlon</p>
        </div>
    </div>
</body>
<script src="../js/script.js"></script>
</html>