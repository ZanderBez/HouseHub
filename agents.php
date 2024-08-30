<?php
session_start();
if (!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit;
}

include 'database.php'; 

// Fetch agents from the database
$sql = "SELECT * FROM agents";
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
    <link rel="stylesheet" href="./CSS/agent.css">
    <title>Our Agents</title>
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
                <h1 class="display-4">Our Agents</h1>
            </div>
        </div>
    </div>
    <div class="agent-text"><h1>Agents</h1></div>
    <!-- Agents Section -->
    <div class="container my-5">
        <div class="row">
            
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($agent = mysqli_fetch_assoc($result)) {
                    echo '
                    <div class="col-md-3">
                        <div class="card card-custom mb-4 shadow-sm">
                            <img src="'.htmlspecialchars($agent['ImageOne']).'" class="card-img-top" alt="Agent Image">
                            <div class="card-body card-body-custom">
                                <h5 class="card-title">'.htmlspecialchars($agent['AgentName']).'</h5>
                                <p class="card-text">Number:  + '.htmlspecialchars($agent['Number']).'</p>
                                <p class="card-text">Email: '.htmlspecialchars($agent['email']).'</p>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>No agents found.</p>';
            }
            ?>
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
                        <li><a href="agents.php">Our Agents</a></li>
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
