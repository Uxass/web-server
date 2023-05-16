<div class="sendsms">
  <?php
  include 'connect.php';
  ?>
  <form method="post">
    <label for="channel">Канал отправки:</label>
    <input type="text" id="channel" name="channel" required>
    <label for="message">Сообщение:</label>
    <textarea id="message" name="message"></textarea>
    <label for="field">Область знаний:</label>
    <select name="field" id="field" required>
      <?php
      $field_query = "SELECT * FROM field";
      $field_result = $conn->query($field_query);

      while ($field_row = $field_result->fetch_assoc()) {
        echo "<option value='" . $field_row['id'] . "'>" . $field_row['name'] . "</option>";
      }
      ?>
    </select>
    <label for="save">Не показывать другим пользователям</label>
    <input type="checkbox" value="true" name="save" id="save">
    <input type="submit" value="Отправить">

  </form>
  <?php
  session_start();

  if (!isset($_SESSION['user_id'])) {
    header('Location: ?menu=signin');
    exit;
  }
  if (isset($_POST['channel']) && isset($_POST['message']) && isset($_POST['field'])) {

    $channel = $_POST['channel'];
    $field = $_POST['field'];
    $message = $_POST['message'];
    if (isset($_POST['save'])) {
      $save = 1;
    } else {
      $save = 0;
    }

    $channel_id = 0;
    $result = $conn->query("SELECT id FROM channel WHERE name='$channel'");
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $channel_id = $row['id'];
    } else {
      $stmt = $conn->prepare("INSERT INTO channel (name) VALUES (?)");
      $stmt->bind_param("s", $channel);
      $stmt->execute();
      $channel_id = $conn->insert_id;
      $stmt->close();
    }

    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO sms (user_id, channel_id, message, save) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $user_id, $channel_id, $message, $save);
    $stmt->execute();
    $sms_id = $conn->insert_id;
    $stmt->close();

    preg_match_all("/#([\p{Cyrillic}\w]+)/u", $message, $matches);
    foreach ($matches[1] as $tag) {
      $stmt = $conn->prepare("INSERT INTO hashtag (name, sms_id) VALUES (?, ?)");
      $stmt->bind_param("si", $tag, $sms_id);
      $stmt->execute();
      $stmt->close();
    }

    $tagtofield_sql = "INSERT INTO tagtofield (id_sms, id_field) VALUES ('$sms_id', '$field')";
    $conn->query($tagtofield_sql);
  }
  ?>
</div>
<?php
$conn->close();
?>