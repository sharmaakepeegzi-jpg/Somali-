<?php
// db.php - Xidhiidhka database-ka Dallo Tourism
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dallo_tourism";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Xidhiidhku wuu fashilmay: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>