<?php

session_start();
require_once 'connect.php';

if($_POST["token"] != $_SESSION["CSRF"])
{
    $response = [
        "status" => false,
        "message" => 'Неправильный token.'
    ];

    echo json_encode($response);

    die();

}
$login = $_POST['login'];
$password = $_POST['password'];

$error_fields = [];

if ($login === '') {
    $error_fields[] = 'login';
}

if ($password === '') {
    $error_fields[] = 'password';
}

if (!empty($error_fields)) {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => "Проверьте заполнение полей",
        "fields" => $error_fields
    ];

    echo json_encode($response);

    die();
}

$password = md5($password);

$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
if (mysqli_num_rows($check_user) > 0) {

    $user = mysqli_fetch_assoc($check_user);

    $_SESSION['user'] = [
        "id" => $user['id'],
        "login" => $user['login'],
        "email" => $user['email'],
        'role' => 'normal'
    ];

    $response = [
        "status" => true
    ];

    echo json_encode($response);

} else {

    $response = [
        "status" => false,
        "message" => 'Не верный логин или пароль'
    ];
    $data = date("H:i:s") . " - Неудачная попытка входа в систему. Логин: $login, Пароль: " . $_POST['password'] . ".\n";
    file_put_contents("../logs/" . date("Y-m-d") . ".txt", $data, FILE_APPEND);

    echo json_encode($response);
}
?>