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
?>


