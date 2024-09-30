<?php 
include "config.php";

if(!$_GET['code']) {
    exit('error code');
}
$params = array(
    'client_id'     => ID,
    'client_secret' => SECRET,
    'code'          => $_GET['code'],
    'redirect_uri'  => $URL
);

if (!$content = @file_get_contents('https://oauth.vk.com/access_token?' . http_build_query($params))) {
    $error = error_get_last();
    throw new Exception('HTTP request failed. Error: ' . $error['message']);
}

$response = json_decode($content);

if (isset($response->error)) {
    throw new Exception('При получении токена произошла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description);
}
$token = $response->access_token;
$expiresIn = $response->expires_in;
$userId = $response->user_id;

$_SESSION['user'] = [
    "vk_token" => $token,
    "user_id" => $userId,
    'role' => 'vk'
];

header('Location: index.php');