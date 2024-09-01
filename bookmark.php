<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$property_id = intval($_POST['property_id']);
include 'database.php';

$checkSql = "SELECT * FROM bookmarks WHERE UserID = ? AND PropertyID = ?";
$stmt = mysqli_prepare($con, $checkSql);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $property_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    $sql = "INSERT INTO bookmarks (UserID, PropertyID) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $property_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Property bookmarked successfully!'); window.location.href='details.php?id=$property_id';</script>";
    } else {
        echo "<script>alert('Error bookmarking the property: " . mysqli_error($con) . "'); window.location.href='details.php?id=$property_id';</script>";
    }
} else {
    echo "<script>alert('You have already bookmarked this property.'); window.location.href='details.php?id=$property_id';</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
