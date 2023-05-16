<h2>Ваши личные сообщения</h2>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ?menu=signin');
    exit;
}
include 'connect.php';
$user_id = $_SESSION['user_id'];
$message_query = "SELECT sms.message, channel.name, sms.id FROM sms JOIN users ON sms.user_id=users.id JOIN channel ON channel.id = sms.channel_id WHERE $user_id = sms.user_id";
$message_result = $conn->query($message_query);

if ($message_result->num_rows > 0) {
    echo "<ul>";
    while ($message_row = $message_result->fetch_assoc()) {
        echo "<li>" . $message_row['name'] . ": " . $message_row['message'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Вы не отправляли сообщения";
}
$conn->close();
?>