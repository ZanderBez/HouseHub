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
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Syne:wght@400..800&display=swap" rel="stylesheet">
    <title>Registration form</title>
    <link rel="stylesheet" href="./CSS/registration.css">
</head>
<body>
    <div class="container">
        <!-- Form Section -->
        <div class="left-section">
            <?php
            if (isset($_POST["submit"])){
                $fullName = $_POST["fullname"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $passwordRepeat = $_POST["repeat_password"];
                $userType = $_POST["user_type"];

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $errors = array();

                if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat)) {
                    array_push($errors,"All fields are required");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors,"Email is not valid");
                }
                if (strlen($password) < 8) {
                    array_push($errors,"Password must be 8 characters long");
                }
                if ($password !== $passwordRepeat) {
                    array_push($errors,"Passwords do not match");
                }

                require_once "database.php";
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($con, $sql);
                $rowCount = mysqli_num_rows($result);

                if ($rowCount > 0) {
                    array_push($errors,"Email already exists!");
                }

                if (count($errors) > 0) {
                    foreach ($errors as $error){
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    $sql = "INSERT INTO users (full_name, email, password, type) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($con);
                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssss", $fullName, $email, $passwordHash, $userType);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>You are registered successfully.</div>";
                    } else {
                        die("Something went wrong");
                    }
                }
            }
            ?>
            <form action="registration.php" method="post">
                <div class="sign-logo">
                    <img src="./assets/Log_1.png" alt="Logo">
                </div>
                <div class="text-1" style="text-align: center; color: #FF9F47;">
                    <h1>SIGN UP</h1>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="fullname" placeholder="Full Name:" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="Email:" required>
                </div>

                <div class="form-group">
                    <div class="radio-group">
                        <label for="user">User</label>
                        <input type="radio" id="user" name="user_type" value="user" required>
                    </div>
                    <div class="radio-group">
                        <label for="agent">Agent</label>
                        <input type="radio" id="agent" name="user_type" value="agent" required>
                    </div>
                    <div class="radio-group">
                        <label for="admin">Admin</label>
                        <input type="radio" id="admin" name="user_type" value="admin" required>
                    </div>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password:" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:" required>
                </div>


                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" name="submit" value="Sign Up">
                </div>
            </form>
            <br>
            <div>
                <p>Already Registered? <a href="login.php">Login Here</a></p>
            </div>
        </div>
        <div class="right-section">
            <div class="overlay">
            </div>
        </div>
    </div>
</body>
</html>
