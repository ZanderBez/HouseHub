<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_bookmark'])) {
    $property_id = intval($_POST['property_id']);
    $delete_sql = "DELETE FROM bookmarks WHERE UserID = ? AND PropertyID = ?";
    $stmt = mysqli_prepare($con, $delete_sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $property_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Bookmark removed successfully.');</script>";
        header("Location: bookmarked.php");
        exit;
    } else {
        echo "<script>alert('Error removing bookmark.');</script>";
    }
}


$sql = "SELECT p.* FROM bookmarks b 
        JOIN properties p ON b.PropertyID = p.PropertyID 
        WHERE b.UserID = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo "Error fetching bookmarks: " . mysqli_error($con);
    exit;
}
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/bookmarked.css">
    <title>BookMarked Page</title>
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
            <li><a href="agents.php">Our Agents</a></li>
            <li><a href="bookmarked.php">BookMarked</a></li>
        </ul>
    </div>
    <div class="nav-right">
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
</nav>

<div class="container">
    <div class="prop-text"><h1>Your Bookmarks</h1></div>
    <div class="properties-section text-center">
        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card">';
                    echo '<img src="' . htmlspecialchars($row["ImageOne"]) . '" class="card-img-top" alt="Property Image">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row["Title"]) . '</h5>';
                    echo '<p class="card-text">Address: ' . htmlspecialchars($row["Address"]) . ', ' . htmlspecialchars($row["City"]) . ', ' . htmlspecialchars($row["State"]) . '</p>';
                    echo '<div class="d-flex justify-content-between align-items-center">';
                    echo '<div class="property-icons">';
                    echo isset($row["Bedrooms"]) ? '<span><i class="fas fa-bed"></i> ' . htmlspecialchars($row["Bedrooms"]) . '</span>' : '';
                    echo isset($row["Bathrooms"]) ? '<span><i class="fas fa-bath"></i> ' . htmlspecialchars($row["Bathrooms"]) . '</span>' : '';
                    echo isset($row["GarageSpace"]) ? '<span><i class="fas fa-car"></i> ' . htmlspecialchars($row["GarageSpace"]) . '</span>' : '';
                    echo '</div>';
                    echo '<div class="price">R' . number_format($row["Price"]) . '</div>';
                    echo '</div>';

                    echo '<form method="POST" action="bookmarked.php" class="d-flex justify-content-between mt-3">';
                    echo '<input type="hidden" name="property_id" value="' . htmlspecialchars($row["PropertyID"]) . '">';
                    echo '<button type="submit" name="remove_bookmark" class="btn btn-danger">Remove</button>';
                    echo '<a href="details.php?id=' . htmlspecialchars($row["PropertyID"]) . '" class="btn btn-outline-light">See offer</a>';
                    echo '</form>';

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
                    <li><a href="bookmarked.php" class="active">BookMarked</a></li>
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
