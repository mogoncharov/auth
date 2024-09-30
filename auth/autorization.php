<?php
session_start();
include "app/config.php";

if (isset($_SESSION['user'])) {
    header('Location: index.php');
}
$token = hash('gost-crypto', random_int(0,999999));
$_SESSION["CSRF"] = $token;

$clientId     = ID; 
$clientSecret = SECRET; 
$redirectUri  = URL; 

$params = array(
	'client_id'     => $clientId,
	'redirect_uri'  => $redirectUri,
	'response_type' => 'code',
	'v'             => '5.126',
	'scope'         => 'photos,offline',
);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="registr">
    <form>
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <input type="hidden" name="token" value="<?=$token?>"> <br/>
        <button type="submit" class="login-btn">Войти</button>
        <p>
            Еще нет аккаунта? - <a href="/registration.php">Зарегистрироваться</a>!
        </p>
        <p class="msg none">Скрытое поле.</p>
        <a href="http://oauth.vk.com/authorize?' . http_build_query( $params ) . '">Войти через Вконтакте</a>
        <a href="/index.php">Вернуться на главную страницу</a>
    </form>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>
</html>