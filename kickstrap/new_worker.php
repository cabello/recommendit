<?php session_start(); ?>

<?php
$url=parse_url(getenv("CLEARDB_DATABASE_URL"));

mysql_connect(
        $server = $url["host"],
        $username = $url["user"],
        $password = $url["pass"]);
        $db=substr($url["path"],1);

mysql_select_db($db);

if(count($_POST)){
	mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('".$_POST['name']."', '".$_POST['phone']."', '".$_POST['id_service']."')");
	$new_id = mysql_insert_id();
	mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('".$new_id."', '".$_SESSION['user_id']."', '".$_POST['id_service']."', '".$_POST['rating']."', '".$_POST['comment']."')");
}

// TODO: Protect against SQL injection

?>
