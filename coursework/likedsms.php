<?php
session_start();
include 'connect.php';
$user_id = $_SESSION['user_id'];
$select = "SELECT likedsms.sms FROM likedsms WHERE likedsms.user_id = '$user_id'";
$select_result = $conn->query($select);
while ($select_row = $select_result->fetch_assoc()) {
    echo '<ul>';
    echo '<li>'.$select_row['sms'].'</li>';
    echo '</ul>';
}
?>