<?php
define("DBHOST", "127.0.0.1:3311");
define("DBNAME", "elephant-flowers.ru");
define("DBUSER", "elephant-flowers.ru");
define("DBPASS", "kG3pD1jU8a");

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);



if (!$db) {
    echo '<div class="alert alert-danger">Ошибка: подключение к базе данных не установлено.</div>';
    exit;
}

$db->set_charset("utf8mb4");

$name = isset($_POST['name']) ? $db->real_escape_string(trim($_POST['name'])) : '';
$phone = isset($_POST['phone']) ? $db->real_escape_string(trim($_POST['phone'])) : '';
$email = isset($_POST['email']) ? $db->real_escape_string(trim($_POST['email'])) : '';

if (empty($name) || empty($phone) || empty($email)) {
    echo '<div class="alert alert-warning">Все поля должны быть заполнены.</div>';
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<div class="alert alert-warning">Неправильный формат электронной почты.</div>';
    exit;
}

$checkPhoneQuery = "SELECT 1 FROM store_leads WHERE phone = '$phone'";
$result = $db->query($checkPhoneQuery);

if ($result && $result->num_rows > 0) {
    echo '<div class="alert alert-warning">Заявка с таким телефоном уже существует.</div>';
    exit;
}

$sql = "INSERT INTO store_leads (name, phone, email, status) VALUES ('$name', '$phone', '$email', 'Нет')";

if ($db->query($sql) === TRUE) {
    echo '<div class="alert alert-success">Заявка принята.</div>';
} else {
    echo '<div class="alert alert-danger">Ошибка базы данных: ' . htmlspecialchars($db->error) . '</div>';
}


