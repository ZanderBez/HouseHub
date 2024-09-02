<?php
session_start();
if (!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit;
}

include 'database.php';

$user_id = $_SESSION["user_id"];
$userSql = "SELECT full_name FROM users WHERE UserID = $user_id";
$userResult = mysqli_query($con, $userSql);
$user = mysqli_fetch_assoc($userResult);

$propertyListed = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $zipcode = mysqli_real_escape_string($con, $_POST['zipcode']);
    $propertyType = mysqli_real_escape_string($con, $_POST['propertyType']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $garageSpace = mysqli_real_escape_string($con, $_POST['garageSpace']);
    $bedrooms = mysqli_real_escape_string($con, $_POST['bedrooms']);
    $bathrooms = mysqli_real_escape_string($con, $_POST['bathrooms']);
    $imageOne = mysqli_real_escape_string($con, $_POST['imageOne']);
    $imageTwo = mysqli_real_escape_string($con, $_POST['imageTwo']);
    $imageThree = mysqli_real_escape_string($con, $_POST['imageThree']);
    $imageFour = mysqli_real_escape_string($con, $_POST['imageFour']);

    $sql = "INSERT INTO pendingproperties (Title, Description, Price, Address, City, State, ZipCode, PropertyType, Status, AgentID, GarageSpace, Bedrooms, Bathrooms, ImageOne, ImageTwo, ImageThree, ImageFour)
        VALUES ('$title', '$description', '$price', '$address', '$city', '$state', agentID, '$zipcode', '$propertyType', '$status', '$garageSpace', '$bedrooms', '$bathrooms','$imageOne', '$imageTwo', '$imageThree', '$imageFour')";

    if (mysqli_query($con, $sql)) {
        $propertyListed = true;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./CSS/sell.css">
    <title>Sell Property</title>
</head>
<body>
<nav class="navbar">
        <div class="nav-logo"></div>
        <div class="nav-center">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="properties.php">Properties</a></li>
                <?php if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === 'agent'): ?>
                <li><a href="sell.php" class="active">Add Property</a></li>
                <?php endif; ?>
                    <?php if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === 'admin'): ?>
                    <li><a href="pending.php">Approval</a></li>
                <?php endif; ?>
                <li><a href="agents.php">Our Agents</a></li>
                <li><a href="bookmarked.php">BookMarked</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <?php if ($user): ?>
                <span class="navbar-text">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</span>
            <?php endif; ?>
            <a href="logout.php" class="custom-logout-btn">Logout</a>
        </div>
    </nav>

<div class="container">
    <h1>List a New Property</h1>

    <?php if ($propertyListed): ?>
    <script type="text/javascript">
        alert("New property listed successfully!");
    </script>
    <?php endif; ?>

    <form action="sell.php" method="POST">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="price">Price</label>
        <input type="number" id="price" name="price" required>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" required>

        <label for="city">City</label>
        <input type="text" id="city" name="city" required>

        <label for="state">State</label>
        <input type="text" id="state" name="state" required>

        <label for="zipcode">Zip Code</label>
        <input type="text" id="zipcode" name="zipcode" required>

        <label for="propertyType">Property Type</label>
        <input type="text" id="propertyType" name="propertyType" required>

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="available">Available</option>
            <option value="sold">Sold</option>
            <option value="pending">Pending</option>
        </select>

        <label for="agentID">AgentID</label>
        <input type="text" id="agentID" name="agentID" required>

        <label for="garageSpace">Garage Space</label>
        <input type="number" id="garageSpace" name="garageSpace" required>

        <label for="bedrooms">Bedrooms</label>
        <input type="number" id="bedrooms" name="bedrooms" required>

        <label for="bathrooms">Bathrooms</label>
        <input type="number" id="bathrooms" name="bathrooms" required>

        <label for="imageOne">Image One URL</label>
        <input type="text" id="imageOne" name="imageOne" required>

        <label for="imageTwo">Image Two URL</label>
        <input type="text" id="imageTwo" name="imageTwo">

        <label for="imageThree">Image Three URL</label>
        <input type="text" id="imageThree" name="imageThree">

        <label for="imageFour">Image Four URL</label>
        <input type="text" id="imageFour" name="imageFour">

        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
