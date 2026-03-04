<?php
$conn = mysqli_connect("localhost", "root", "", "IT16", 3307);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
