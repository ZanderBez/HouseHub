<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "real_estate";
$con = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$con) {
    die ("Something went wrong");
}

?>