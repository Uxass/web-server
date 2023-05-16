<?php
include 'connect.php';

if (isset($_POST['field'])) {
    $field = $_POST['field'];
    $field_query = "SELECT id FROM field WHERE name = '$field'";
    $field_result = $conn->query($field_query);

    if ($field_result->num_rows > 0) {
        $field_row = $field_result->fetch_assoc();
        $field_id = $field_row['id'];

        $hashtag_query = "SELECT hashtag.name FROM hashtag JOIN tagtofield ON hashtag.id = tagtofield.id_tag WHERE tagtofield.id_field = '$field_id'";
        $hashtag_result = $conn->query($hashtag_query);

        if ($hashtag_result->num_rows > 0) {
            echo "<h2>Хештеги для области знаний '$field':</h2>";
            echo "<ul>";
            while ($hashtag_row = $hashtag_result->fetch_assoc()) {
                echo "<li>" . $hashtag_row['name'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Нет хештегов для выбранной области знаний";
        }
    } else {
        echo "Область знаний не найдена";
    }
}

$hashtag_query = "SELECT name FROM hashtag WHERE id NOT IN (SELECT id_tag FROM tagtofield)";
$hashtag_result = $conn->query($hashtag_query);

if ($hashtag_result->num_rows > 0) {
    echo "<h2>Хештеги без привязки к области знаний:</h2>";
    echo "<ul>";
    while ($hashtag_row = $hashtag_result->fetch_assoc()) {
        echo "<li>" . $hashtag_row['name'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Нет хештегов без привязки к области знаний";
}

?>

<h2>Выбрать область знаний:</h2>
<form action="" method="post">
    <label for="field">Область знаний:</label>
    <select name="field" id="field">
        <?php
        $field_query = "SELECT name FROM field";
        $field_result = $conn->query($field_query);

        while ($field_row = $field_result->fetch_assoc()) {
            echo "<option value='" . $field_row['name'] . "'>" . $field_row['name'] . "</option>";
        }
        ?>
    </select>
    <button type="submit">Выбрать</button>
</form>

<?php
$conn->close();
?>
