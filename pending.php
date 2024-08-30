<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'database.php';

// Handle approval/rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $property_id = intval($_POST['property_id']); // Use PendingID instead of PropertyID

    if (isset($_POST['approve'])) {
        // Move property to 'properties' table
        $sql = "INSERT INTO properties (Title, Description, Price, Address, City, State, ZipCode, PropertyType, Status, GarageSpace, Bedrooms, Bathrooms, ImageOne, ImageTwo, ImageThree, ImageFour)
                SELECT Title, Description, Price, Address, City, State, ZipCode, PropertyType, 'available', GarageSpace, Bedrooms, Bathrooms, ImageOne, ImageTwo, ImageThree, ImageFour
                FROM pendingproperties WHERE PendingID = $property_id";

        if (mysqli_query($con, $sql)) {
            // Delete from 'pendingproperties'
            $delete_sql = "DELETE FROM pendingproperties WHERE PendingID = $property_id";
            mysqli_query($con, $delete_sql);
            echo "<script>alert('Property approved and moved to properties list!');</script>";
        } else {
            echo "<script>alert('Error in approving the property.');</script>";
        }
    } elseif (isset($_POST['reject'])) {
        // Delete from 'pendingproperties'
        $delete_sql = "DELETE FROM pendingproperties WHERE PendingID = $property_id";
        if (mysqli_query($con, $delete_sql)) {
            echo "<script>alert('Property rejected and deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error in rejecting the property.');</script>";
        }
    }
}

// Fetch pending properties
$sql = "SELECT * FROM pendingproperties";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/pending.css">
    <title>Pending Properties</title>
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

<div class="container">
    <h1>Pending Properties</h1>
    <?php if (mysqli_num_rows($result) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Title']); ?></td>
                <td><?php echo htmlspecialchars($row['Description']); ?></td>
                <td><?php echo htmlspecialchars($row['Price']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="property_id" value="<?php echo $row['PendingID']; ?>"> <!-- Changed PropertyID to PendingID -->
                        <button type="submit" name="approve" class="btn btn-success">Approve</button>
                        <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No pending properties.</p>
    <?php endif; ?>
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
