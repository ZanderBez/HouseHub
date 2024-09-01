<?php
session_start();
if (isset($_SESSION["user"])){
    header("Location: index.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Syne:wght@400..800&display=swap" rel="stylesheet">
    <title>Login Form</title>
    <link rel="stylesheet" href="./CSS/login.css"> 
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="overlay">
            </div>
        </div>
        <div class="right-section">
            <?php
                if (isset($_POST["login"])) {
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    require_once "database.php";

                    $email = mysqli_real_escape_string($con, $email);

                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $result = mysqli_query($con, $sql);
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    if ($user) {
                        if (password_verify($password, $user["password"])) {
                            $_SESSION["user_id"] = $user["UserID"];
                            $_SESSION["user_name"] = $user["full_name"];
                            $_SESSION["user_type"] = $user["Type"];
                    

                            header("Location: index.php");
                            exit;
                        } else {
                            echo "<div class='alert alert-danger'>Password does not match</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Email does not match</div>";
                    }
                }
            ?>
            <div class="sign-logo">
                <img src="./assets/Log_1.png" alt="Logo">
            </div>
            <div class="text-1" style="text-align: center; color: #FF9F47;">
                <h1>LOG IN</h1>
            </div>
            <form action="login.php" method="post">
                <div class="form-group">
                    <input type="email" placeholder="User name or email address" name="email" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Your password" name="password" required>
                </div>
                <br>
                <div class="form-bnt">
                    <input type="submit" value="Sign in" name="login" class="btn-primary">
                </div>
            </form>
            <br>
            <div class="sign-up-link">
                <p>Don't have an account? <a href="registration.php">Sign up</a></p>
            </div>
        </div>
    </div>
</body>
</html>
