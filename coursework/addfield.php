<form action="" class="form-add" method="post">
    <div class="add">
        <label for="field">Название области знаний</label>
        <input type="text" name="field" id="field">
        <label for="description">Описание</label>
        <textarea name="description" id="description"></textarea>
        <button type="submit" class="submit">Добавить</button>
    </div>
</form>
<?php
include 'connect.php';

if (isset($_POST['field'])) {
$field = strtolower($_POST["field"]);
$description = $_POST["description"];

$result = $conn->query("SELECT id FROM field WHERE name = '$field'");

if ($result->num_rows > 0) {
    echo "Такая область знаний уже существует";
} else {
    $sql = "INSERT INTO field (name, description) VALUES ('$field','$description')";

    if ($conn->query($sql) === TRUE) {
        echo "New field created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
}

$conn->close();
?>