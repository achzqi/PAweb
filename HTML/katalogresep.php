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
            <nav>
                <ul class="nav-list">
                    <li><a href="landingpage.php">Home</a></li>
                    <li><a href="aboutus.html">About</a></li>
                    <li><a href="katalogresep.php">Resep</a></li>
                    <li><a href="#footer">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <section class="hero">
        <div class="hero">
            <h2>Selamat Datang Di Galeri Resep Nusantara!</h2>
            <p>Carilah resep menu yang kalian inginkan</p>
        </div>
    </section>

    <section class="recipe-details">
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "resep_nusantara";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);


                if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM resep";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='recipe-detail'>";
                        echo "<img src='" . $row["gambar"] . "' alt='" . htmlspecialchars($row["nama"], ENT_QUOTES) . "' class='recipe-image'>";
                        echo "<h2>" . htmlspecialchars($row["nama"], ENT_QUOTES) . "</h2>";
                        echo "<p>" . htmlspecialchars($row["deskripsi"], ENT_QUOTES). "</p>";

                        echo "<h3>Bahan-bahan:</h3>";
                        echo "<ul>";
                        $bahan = explode("\n", $row["bahan"]); // Asumsikan bahan dipisah per baris
                        foreach ($bahan as $item) {
                        echo "<li>" . htmlspecialchars($item, ENT_QUOTES) . "</li>";
                        }
                        echo "</ul>";

                        echo "<h3>Langkah-langkah Pembuatan:</h3>";
                        echo "<ol>";
                        $instruksi = explode("\n", $row["instruksi"]); // Asumsikan instruksi dipisah per baris
                        foreach ($instruksi as $step) {
                        echo "<li>" . htmlspecialchars($step, ENT_QUOTES) . "</li>";
                        }
                        echo "</ol>";
                        echo "</div>";
                        }
                        } else {
                         echo "Belum ada resep.";
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
    
        <div class="col">
            <h4>About</h4>
            <a href="#">About</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Contact</a>
        </div>
    </footer>

    <div class="copyright">
        <div>
            <p>&copy; Resep Nusantara. Made by Tiara, Zidan, Adie, Marlon</p>
        </div>
    </div>
</body>
</html>