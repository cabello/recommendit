<?php

session_start();
$_SESSION['token'] = $_POST['accessToken'];

$query = "https://graph.facebook.com/me?access_token=".$_SESSION["token"];
$response = file_get_contents($query);
$user_data = json_decode($response, true);
$_SESSION["user_id"] = $user_data["id"];

?>
