<?php
session_start();
if (!isset($_SESSION["user"])){
    header("Location: login.php");
    exit;
}

include 'database.php';

// Initialize the base query
$sql = "SELECT Title, Address, City, State, Price, ImageOne, Bedrooms, Bathrooms, GarageSpace FROM properties WHERE 1=1";

// Apply filters based on GET parameters
if (isset($_GET['property_type']) && $_GET['property_type'] !== '') {
    $property_type = mysqli_real_escape_string($con, $_GET['property_type']);
    $sql .= " AND PropertyType = '$property_type'";
}

if (isset($_GET['city']) && $_GET['city'] !== '') {
    $city = mysqli_real_escape_string($con, $_GET['city']);
    $sql .= " AND City = '$city'";
}

if (isset($_GET['bedrooms']) && $_GET['bedrooms'] !== '') {
    $bedrooms = (int)$_GET['bedrooms'];
    $sql .= " AND Bedrooms >= $bedrooms";
}

if (isset($_GET['bathrooms']) && $_GET['bathrooms'] !== '') {
    $bathrooms = (int)$_GET['bathrooms'];
    $sql .= " AND Bathrooms >= $bathrooms";
}

if (isset($_GET['garage']) && $_GET['garage'] !== '') {
    $garage = (int)$_GET['garage'];
    $sql .= " AND GarageSpace >= $garage";
}

if (isset($_GET['price_range']) && $_GET['price_range'] !== '') {
    switch ($_GET['price_range']) {
        case '1':
            $sql .= " AND Price BETWEEN 500000 AND 1000000";
            break;
        case '2':
            $sql .= " AND Price BETWEEN 1000000 AND 2000000";
            break;
        case '3':
            $sql .= " AND Price BETWEEN 2000000 AND 4000000";
            break;
    }
}

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
    <link rel="stylesheet" href="./CSS/properties.css">
    <title>Properties</title>
</head>
<body>
<nav class="navbar">
        <div class="nav-logo"></div>
        <div class="nav-center">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="properties.php">Properties</a></li>
                <li><a href="sell.php">Sell</a></li>
                <li><a href="#">Bookmarked</a></li>
                <li><a href="#">Our Agents</a></li>
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
                <h1 class="display-4"><strong>ALL PROPERTIES</strong></h1>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="container my-4">
        <form method="GET" action="properties.php">
            <div class="row text-center mb-2">
                <div class="col-md-2">
                    <select class="form-select" name="property_type" aria-label="Property Type">
                        <option value="" selected>PROPERTY TYPE</option>
                        <option value="House">House</option>
                        <option value="Apartment">Apartment</option>
                        <option value="Farm">Farm</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="city" aria-label="City">
                        <option value="" selected>CITY</option>
                        <option value="Pretoria">Pretoria</option>
                        <option value="Cape Town">Cape Town</option>
                        <option value="Durban">Durban</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="bedrooms" aria-label="Bedrooms">
                        <option value="" selected>BEDROOMS</option>
                        <option value="1">1 Room</option>
                        <option value="2">2 Rooms</option>
                        <option value="3">3 Rooms</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="bathrooms" aria-label="Bathrooms">
                        <option value="" selected>BATHROOMS</option>
                        <option value="1">1 Bathroom</option>
                        <option value="2">2 Bathrooms</option>
                        <option value="3">3 Bathrooms</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="garage" aria-label="Garage">
                        <option value="" selected>GARAGESPACE</option>
                        <option value="0">0 Garages</option>
                        <option value="1">1 Garage</option>
                        <option value="2">2 Garages</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="price_range" aria-label="Price Range">
                        <option value="" selected>PRICE RANGE</option>
                        <option value="1">R500,000 - R1,000,000</option>
                        <option value="2">R1,000,000 - R2,000,000</option>
                        <option value="3">R2,000,000 - R4,000,000</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row text-center">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Properties Grid Section -->
    <div class="background">
        <div class="container">
            <div class="prop-text"><h1>PROPERTIES</h1></div>
            <div class="properties-section text-center">
                <div class="row">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="col-md-4">';
                            echo '<div class="card">';
                            echo '<img src="' . $row["ImageOne"] . '" class="card-img-top" alt="Property Image">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $row["Title"] . '</h5>';
                            echo '<p class="card-text">Address: ' . $row["Address"] . ', ' . $row["City"] . ', ' . $row["State"] . '</p>';
                            echo '<div class="d-flex justify-content-between align-items-center">';
                            echo '<div class="property-icons">';
                            echo isset($row["Bedrooms"]) ? '<span><i class="fas fa-bed"></i> ' . $row["Bedrooms"] . '</span>' : '';
                            echo isset($row["Bathrooms"]) ? '<span><i class="fas fa-bath"></i> ' . $row["Bathrooms"] . '</span>' : '';
                            echo isset($row["GarageSpace"]) ? '<span><i class="fas fa-car"></i> ' . $row["GarageSpace"] . '</span>' : '';
                            echo '</div>';
                            echo '<div class="price">R' . number_format($row["Price"]) . '</div>';
                            echo '</div>';
                            echo '<a href="#" class="btn btn-outline-light mt-3">See offer</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "No properties available.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="./assets/Layer_1.png" alt="HomeHub Logo" class="footer-logo">
                    <p>Connecting You to Your Perfect Home</p>
                </div>
                <div class="col-md-4">
                    <h5>QUICK MENU</h5>
                    <ul class="footer-menu">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Properties</a></li>
                        <li><a href="#">Sell</a></li>
                        <li><a href="#">Bookmarked</a></li>
                        <li><a href="#">Our Agents</a></li>
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
                <p>&copy; 2024 Homehub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
