<?php
$servername = "std-mysql";
$username = "std_2080_php";
$password = "12345678";
$dbname = "std_2080_php";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo die("Connection failed: " . $conn->connect_error);
}
?>