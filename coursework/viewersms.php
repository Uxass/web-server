<h2>Введите хештег:</h2>
<form action="" method="post">
    <label for="hashtag">Хештег:</label>
    <input type="text" name="hashtag" id="hashtag">
    <button type="submit">Найти</button>
</form>
<form action="" method="post">
    <label for="field">Область знаний:</label>
    <select name="field" id="field" required>
      <?php
      include 'connect.php';

      $field_query = "SELECT * FROM field";
      $field_result = $conn->query($field_query);

      while ($field_row = $field_result->fetch_assoc()) {
        echo "<option value='" . $field_row['id'] . "'>" . $field_row['name'] . "</option>";
      }
      ?>
    </select>
    <button type="submit">Найти</button>
</form>
<?php
session_start();

if (isset($_POST['field'])) {
    $field_id = $_POST['field'];
    $sms_query = "SELECT sms.message, channel.name, users.login FROM sms JOIN channel ON channel.id = sms.channel_id JOIN users ON users.id = sms.user_id JOIN tagtofield ON tagtofield.id_sms = sms.id WHERE tagtofield.id_field = $field_id";
    $sms_result = $conn->query($sms_query);

    if ($sms_result->num_rows > 0) {
        echo "<ul>";
        while ($sms_row = $sms_result->fetch_assoc()) {
            echo "<li>" . $sms_row['name'] . ' ' . $sms_row['login'] . ": " . $sms_row['message'] . "</li>";
        }
        echo "</ul>";
    }

} else {
    echo 'Нет сообщений с выбранной областью знаний';
}


if (isset($_POST['saveflag'])) {
    $user_id = $_SESSION['user_id'];
    foreach ($_POST['saveflag'] as $value) {
        $save_query = "INSERT INTO likedsms (sms, user_id) VALUES ('$value', '$user_id')";
        if ($conn->query($save_query) === TRUE) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . $save_query . "<br>" . $conn->error;
        }
    }
}

if (!empty($_POST['hashtag'])) {
    $user_id = $_SESSION['user_id'];
    $hashtag = $_POST['hashtag'];
    $hashtag_query = "SELECT name FROM hashtag WHERE name = '$hashtag'";
    $hashtag_result = $conn->query($hashtag_query);

    if ($hashtag_result->num_rows > 0) {
        $hashtag_row = $hashtag_result->fetch_assoc();
        $hashtag_name = $hashtag_row['name'];

        $message_query = "SELECT sms.message, channel.name , users.login, sms.id FROM sms JOIN hashtag ON sms.id=hashtag.sms_id JOIN users ON sms.user_id=users.id JOIN channel ON channel.id = sms.channel_id WHERE hashtag.name = '$hashtag_name' AND sms.save != 1";
        $message_result = $conn->query($message_query);

        if ($message_result->num_rows > 0) {
            echo "<h2>Сообщения с хештегом #$hashtag:</h2>";
            echo '<form action="" method="post">';
            echo "<ul>";
            while ($message_row = $message_result->fetch_assoc()) {
                echo "<li>" . $message_row['name'] . ' ' . $message_row['login'] . ": " . $message_row['message'] . "<input type='checkbox' name='saveflag[]' value='" . $message_row['message'] . "'></li>";
            }
            echo "</ul>";
            echo '<input type="submit" value="добавить в избранное">';
            echo '</form>';
        } else {
            echo "Нет сообщений для выбранного хештега";
        }
    } else {
        echo "Хештег не найден";
    }
} else {
    $message_query = "SELECT sms.message, channel.name , users.login, sms.id FROM sms JOIN hashtag ON sms.id=hashtag.sms_id JOIN users ON sms.user_id=users.id JOIN channel ON channel.id = sms.channel_id WHERE sms.save != 1";
    $message_result = $conn->query($message_query);

    if ($message_result->num_rows > 0) {
        echo "<h2>Все сообщения</h2>";
        echo "<ul>";
        while ($message_row = $message_result->fetch_assoc()) {
            echo "<li>" . $message_row['name'] . ' ' . $message_row['login'] . ": " . $message_row['message'] . "</li>";
        }
        echo "</ul>";
    }
}

$conn->close();
?>