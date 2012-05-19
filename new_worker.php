<?php session_start(); ?>

<?php
require('bd.php');

if(count($_POST)){
	mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('".$_POST['name']."', '".$_POST['phone']."', '".$_POST['id_service']."')");
	$new_id = mysql_insert_id();
	$result = mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('".$new_id."', '".$_SESSION['user_id']."', '".$_POST['id_service']."', '".$_POST['rating']."', '".$_POST['comment']."')");
    if ( ! $result) {
        die(mysql_error());
    }
}
// TODO: Protect against SQL injection

$urll = "https://www.facebook.com/dialog/feed?app_id=".$_SESSION["app_id"]."&link=https://developers.facebook.com/docs/reference/dialogs/&picture=http://fbrell.com/f8.jpg&name=Facebook%20Dialogs&caption=Reference%20Documentation&description=Using%20Dialogs%20to%20interact%20with%20users.&redirect_uri=http://www.example.com/response";

header("location: $urll");
?>


