<?php
$conn = new mysqli("localhost", "root", "", "tourist");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
