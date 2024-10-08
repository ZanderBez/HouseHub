<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo 'Invalid property ID.';
    exit;
}

$property_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

include 'database.php';

$user_id = $_SESSION["user_id"];
$userSql = "SELECT full_name FROM users WHERE UserID = $user_id";
$userResult = mysqli_query($con, $userSql);
$user = mysqli_fetch_assoc($userResult);

// Fetch property details
$sql = "SELECT * FROM properties WHERE PropertyID = $property_id";
$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo 'Property not found.';
    exit;
}

$property = mysqli_fetch_assoc($result);

$agentSql = "SELECT * FROM agents WHERE Agent_ID = " . $property['AgentID'];
$agentResult = mysqli_query($con, $agentSql);
$agent = mysqli_fetch_assoc($agentResult);

// Handle purchase and availability
$availabilityMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['purchase'])) {
        // Update the property status to 'sold'
        $updateSql = "UPDATE properties SET Status = 'sold' WHERE PropertyID = $property_id";
        if (mysqli_query($con, $updateSql)) {
            $availabilityMessage = 'This property has been sold.';
            echo "<script>alert('Successfully purchased the property!');</script>";
        } else {
            $availabilityMessage = 'Failed to update property status.';
        }
    } else {
        // Check for availability
        $status = $property['Status'];
        if ($status === 'available') {
            $availabilityMessage = 'This property is available!';
        } elseif ($status === 'pending') {
            $availabilityMessage = 'This property is pending.';
        } elseif ($status === 'sold') {
            $availabilityMessage = 'This property has been sold.';
        } else {
            $availabilityMessage = 'Status is unknown.';
        }
    }
}

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review'])) {
    $reviewText = mysqli_real_escape_string($con, $_POST['review']);
    $rating = intval($_POST['rating']);

    $insertReview = "INSERT INTO reviews (PropertyID, UserID, ReviewText, rating) VALUES ('$property_id', '$user_id', '$reviewText', '$rating')";
    
    if (mysqli_query($con, $insertReview)) {
        echo "<div class='alert alert-success'>Review added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to add review: " . mysqli_error($con) . "</div>";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/details.css">
    <title><?php echo htmlspecialchars($property['Title']); ?> - Details Page</title>
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
            <li><a href="pending.php" class="active">Approval</a></li>
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

<!-- Hero Section -->
<div class="hero-section">
    <img src="<?php echo htmlspecialchars($property['ImageOne']); ?>" alt="Property Image">
    <div class="overlay">
        <h1><?php echo htmlspecialchars($property['Title']); ?></h1>
        <a href="properties.php" class="btn">GO BACK</a>
        <form method="POST" style="display: inline-block;">
            <button type="submit" class="btn">Check for Availability</button>
        </form>
        <p><?php echo $availabilityMessage; ?></p>
    </div>
</div>

<!-- Property Details Section -->
<div class="property-details">
    <div class="property-description">
        <h2><?php echo htmlspecialchars($property['PropertyType']); ?></h2>
        <p><?php echo htmlspecialchars($property['Description']); ?></p>
        <ul class="details-list">
            <li><i class="fas fa-bed"></i> <?php echo htmlspecialchars($property['Bedrooms']); ?> Bedrooms</li>
            <li><i class="fas fa-bath"></i> <?php echo htmlspecialchars($property['Bathrooms']); ?> Bathrooms</li>
            <li><i class="fas fa-car"></i> <?php echo htmlspecialchars($property['GarageSpace']); ?> Garage</li>
            <li><i class="fas fa-paw"></i> Pet Friendly</li>
            <li><i>Price: R</i><?php echo htmlspecialchars($property['Price']); ?></li>
        </ul>
        <form action="bookmark.php" method="POST">
            <input type="hidden" name="property_id" value="<?php echo $property['PropertyID']; ?>">
            <button type="submit" class="btn btn-outline-light">Bookmark this Property</button>
        </form>

        <button type="button" class="btn btn-outline-light mt-3" data-bs-toggle="modal" data-bs-target="#mortgageCalculatorModal">
            Mortgage Calculator
        </button>
    </div>
    <div class="property-images">
        <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <?php if (!empty($property['ImageTwo'])) { ?>
                <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <?php } ?>
                <?php if (!empty($property['ImageThree'])) { ?>
                <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <?php } ?>
                <?php if (!empty($property['ImageFour'])) { ?>
                <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <?php } ?>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?php echo htmlspecialchars($property['ImageTwo']); ?>" class="d-block w-100" alt="Image 1">
                </div>
                <?php if (!empty($property['ImageThree'])) { ?>
                <div class="carousel-item">
                    <img src="<?php echo htmlspecialchars($property['ImageThree']); ?>" class="d-block w-100" alt="Image 2">
                </div>
                <?php } ?>
                <?php if (!empty($property['ImageFour'])) { ?>
                <div class="carousel-item">
                    <img src="<?php echo htmlspecialchars($property['ImageFour']); ?>" class="d-block w-100" alt="Image 3">
                </div>
                <?php } ?>
                <?php if (!empty($property['ImageOne'])) { ?>
                <div class="carousel-item">
                    <img src="<?php echo htmlspecialchars($property['ImageOne']); ?>" class="d-block w-100" alt="Image 4">
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="container mt-5">
    <div class="row">
        <!-- Reviews Section -->
        <div class="col-md-6">
            <div class="reviews-section">
                <h2>Reviews</h2>
                <div class="review-list">
                    <?php
                        $reviewSql = "SELECT r.ReviewText, r.CreatedAt, u.full_name, r.rating 
                                      FROM reviews r
                                      JOIN users u ON r.userID = u.UserID
                                      WHERE r.PropertyID = '$property_id'
                                      ORDER BY r.CreatedAt DESC";
                        $reviewResult = mysqli_query($con, $reviewSql);

                        if (mysqli_num_rows($reviewResult) > 0) {
                            while ($review = mysqli_fetch_assoc($reviewResult)) {
                                echo "<div class='review-item'>";
                                echo "<h5><strong>" . htmlspecialchars($review['full_name']) . "</strong> - " . htmlspecialchars($review['CreatedAt']) . "</h5>";
                                echo "<p>" . htmlspecialchars($review['ReviewText']) . "</p>";
                                echo "<div class='star-rating'>";
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $review['rating']) {
                                        echo "<i class='fas fa-star'></i>";
                                    } else {
                                        echo "<i class='far fa-star'></i>";
                                    }
                                }
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No reviews yet. Be the first to review this property!</p>";
                        }
                    ?>
                </div>
                <div class="add-review">
                    <h3>Add a review</h3>
                    <form action="details.php?id=<?php echo $property_id; ?>" method="POST">
                        <div class="rating">
                            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                        </div>
                        <textarea name="review" placeholder="Write your review here..." required></textarea>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Agent Section -->
        <div class="col-md-6">
            <div class="card">
                <img src="<?php echo $agent['ImageOne']; ?>" alt="Agent Image">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($agent['AgentName']); ?></h5>
                    <p class="card-text">Phone: <?php echo htmlspecialchars($agent['Number']); ?></p>
                    <p class="card-text">Email: <?php echo htmlspecialchars($agent['email']); ?></p>
                    <p class="card-text">Region: <?php echo htmlspecialchars($agent['City']); ?></p>
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#purchaseModal">
                        Buy Property
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Purchase Modal -->
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseModalLabel">Purchase Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="purchase" value="true">
                    <div class="form-group mb-3">
                        <label for="buyerName">Your Name:</label>
                        <input type="text" id="buyerName" name="buyerName" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="buyerEmail">Your Email:</label>
                        <input type="email" id="buyerEmail" name="buyerEmail" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="buyerPhone">Phone Number:</label>
                        <input type="tel" id="buyerPhone" name="buyerPhone" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-outline-dark">Purchase</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mortgage Calculator Modal -->
<div class="modal fade" id="mortgageCalculatorModal" tabindex="-1" aria-labelledby="mortgageCalculatorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mortgageCalculatorModalLabel">Mortgage Calculator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="mortgageCalculatorForm">
                    <div class="form-group mb-3">
                        <label for="loanAmount">Loan Amount (R):</label>
                        <input type="number" id="loanAmount" name="loanAmount" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="interestRate">Interest Rate (%):</label>
                        <input type="number" step="0.01" id="interestRate" name="interestRate" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="loanTerm">Loan Term (Years):</label>
                        <input type="number" id="loanTerm" name="loanTerm" class="form-control" required>
                    </div>
                    <button type="button" onclick="calculateMortgage()" class="btn btn-primary">Calculate</button>
                </form>
                
                <div id="result" class="result mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Section -->
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
                    <li><a href="bookmarked.php">BookMarked</a></li>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
function calculateMortgage() {
    var loanAmount = parseFloat(document.getElementById('loanAmount').value);
    var interestRate = parseFloat(document.getElementById('interestRate').value) / 100 / 12;
    var loanTerm = parseInt(document.getElementById('loanTerm').value) * 12;

    var x = Math.pow(1 + interestRate, loanTerm);
    var monthlyPayment = (loanAmount * x * interestRate) / (x - 1);

    // Display the result
    document.getElementById('result').innerHTML = "Estimated Monthly Payment: R" + monthlyPayment.toFixed(2);
}
</script>
</body>
</html>
