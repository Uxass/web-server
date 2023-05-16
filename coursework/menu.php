<?php
if ($_GET['menu'] == "signup") {
    $active_item = "Sign Up";
} elseif ($_GET['menu'] == "signin") {
    $active_item = "Sign In";
} elseif ($_GET['menu'] == "addfield") {
    $active_item = "Add Field";
} elseif ($_GET['menu'] == "sendsms") {
    $active_item = "Send SMS";
} elseif ($_GET['menu'] == "viewerhashtag") {
    $active_item = "Hashtags";
} elseif ($_GET['menu'] == "viewersms") {
    $active_item = "Sms";
} elseif ($_GET['menu'] == "likedsms") {
    $active_item = "Favourite";
} elseif ($_GET['menu'] == "usersms") {
    $active_item = "My sms";
}

function generateMenuItem($text, $url)
{
    global $active_item;
    if ($text == $active_item) {
        $class = "active";
    } else {
        $class = "";
    }
    echo "<li><a class=\"$class\" href=\"./?menu=$url\">$text</a></li>";
}
?>

<nav>
    <ul>
        <?php
        if (isset($_SESSION['user_name'])) {
            echo '<li>' . 'Имя:' . $_SESSION['user_name'] . '</li>';
            echo '<li><a href="exit.php">Выйти</a></li>';
        } else {
            generateMenuItem("Sign Up", "signup");
            generateMenuItem("Sign In", "signin");
        }
        generateMenuItem("Add Field", "addfield");
        generateMenuItem("Send SMS", "sendsms");
        generateMenuItem("Hashtags", "viewerhashtag");
        generateMenuItem("My sms", "usersms");
        generateMenuItem("Sms", "viewersms");
        generateMenuItem("Favourite", "likedsms");


        ?>
    </ul>
</nav>

<?php
if (isset($_GET['menu'])) {
    if ($_GET['menu'] == 'signup')
        include 'signup.php';
    else if ($_GET['menu'] == 'signin')
        include 'signin.php';
    else if ($_GET['menu'] == 'addfield')
        include 'addfield.php';
    else if ($_GET['menu'] == 'sendsms')
        include 'sendsms.php';
    else if ($_GET['menu'] == 'viewerhashtag')
        include 'viewerhashtag.php';
    else if ($_GET['menu'] == 'viewersms')
        include 'viewersms.php';
    else if ($_GET['menu'] == 'likedsms')
        include 'likedsms.php';
    else if ($_GET['menu'] == 'usersms')
        include 'usersms.php';
}
?>