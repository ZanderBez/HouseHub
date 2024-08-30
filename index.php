<?php
session_start();
if (!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit;
}

include 'database.php'; 

// Modify the SQL query to limit the results to 3
$sql = "SELECT PropertyID, Title, Address, City, State, ZipCode, Price, ImageOne, Bedrooms, Bathrooms, GarageSpace FROM properties LIMIT 3";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Syne:wght@400..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/index.css">
    <title>User Dashboard</title>
</head>
<body>
<nav class="navbar">
        <div class="nav-logo"></div>
        <div class="nav-center">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="properties.php">Properties</a></li>
                <?php if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === 'agent'): ?>
                <li><a href="sell.php">Add Property</a></li>
                <?php endif; ?>
                    <?php if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === 'admin'): ?>
                    <li><a href="pending.php">Approval</a></li>
                <?php endif; ?>
                <li><a href="properties.php">Our Agents</a></li>
            </ul>
        </div>
        <div class="nav-right">
        <a href="logout.php" class="btn btn-warning">Logout</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="overlay">
            <div class="hero-content text-center">
                <h1 class="display-4">HomeHub</h1>
                <h3>Welcome to HomeHub, your trusted destination for buying and selling homes. Whether you're searching for your dream house or looking to sell, we're here to guide you every step of the way, making the process as seamless and rewarding as possible.</h3>
                <a href="properties.php" class="btn btn-outline-light">ALL PROPERTIES</a>
            </div>
        </div>
    </div>

    <!-- Our Mission Section -->
    <div class="container mission-photo-section">
        <div class="row align-items-center">
            <div class="col-md-6 mission-text">
                <h2>Our Mission</h2>
                <p>At HomeHub, our mission is to simplify the real estate journey by connecting buyers and sellers in a transparent, efficient, and personalized way. We strive to empower our clients with the tools and knowledge they need to make informed decisions, ensuring every transaction is smooth and successful. Whether you're buying your first home or selling a cherished property, our goal is to provide exceptional service, fostering trust and satisfaction at every stage of the process.</p>
                <a href="#" class="btn btn-outline-light">VIEW PROPERTIES</a>
            </div>
            <div class="col-md-6">
                <img src="./assets/AdobeStock_586090420.jpeg" alt="Mission Image" class="img-fluid rounded">
            </div>
        </div>
    </div>

    <!-- Property on Show Section -->
    <div class="background">
        <div class="container">
            <div class="properties-section text-center">
                <h2>PROPERTY ON SHOW</h2>
                <div class="row">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="col-md-4">';
                            echo '<div class="card">';
                            echo '<img src="' . $row["ImageOne"] . '" class="card-img-top" alt="Property Image">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $row["Title"] . '</h5>';
                            echo '<p class="card-text">Address: ' . $row["Address"] . ', ' . $row["City"] . ', ' . $row["State"] . ', ' . $row["ZipCode"] . '</p>';
                            echo '<div class="d-flex justify-content-between align-items-center">';
                            echo '<div class="property-icons">';
                            echo isset($row["Bedrooms"]) ? '<span><i class="fas fa-bed"></i> ' . $row["Bedrooms"] . '</span>' : '';
                            echo isset($row["Bathrooms"]) ? '<span><i class="fas fa-bath"></i> ' . $row["Bathrooms"] . '</span>' : '';
                            echo isset($row["GarageSpace"]) ? '<span><i class="fas fa-car"></i> ' . $row["GarageSpace"] . '</span>' : '';
                            echo '</div>';
                            echo '<div class="price">R' . number_format($row["Price"]) . '</div>';
                            echo '</div>';
                            echo '<a href="details.php?id=' . $row["PropertyID"] . '" class="btn btn-outline-light mt-3">See offer</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "No properties available.";
                    }
                    ?>
                </div>
                <a href="properties.php" class="btn btn-outline-light mt-3">View more...</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a href="index.php"><img src="./assets/Layer_1.png" alt="HomeHub Logo" class="footer-logo"></a>
                    <p>Connecting You to Your Perfect Home</p>
                </div>
                <div class="col-md-4">
                    <h5>QUICK MENU</h5>
                    <ul class="footer-menu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="properties.php">Properties</a></li>
                        <?php if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === 'agent'): ?>
                        <li><a href="sell.php">Add Property</a></li>
                        <?php endif; ?>
                            <?php if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === 'admin'): ?>
                            <li><a href="pending.php">Approval</a></li>
                        <?php endif; ?>
                        <li><a href="properties.php">Our Agents</a></li>
                        </ul>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>CONTACT US</h5>
                    <p>+27 98 678 483</p>
                    <p>info@Homehub.co.za</p>
                    <div class="footer-socials">
                        <a href="https://www.instagram.com/openwindowinstitute/"><img src="./assets/Vector.png" alt="Instagram"></a>
                        <a href="https://www.facebook.com/theopenwindow/"><img src="./assets/ic_outline-facebook.png" alt="Facebook"></a>
                        <a href="https://x.com/open_window_"><img src="./assets/prime_twitter.png" alt="Twitter"></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 HomeHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
