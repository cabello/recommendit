

<?php
	session_start();
	$_SESSION['user_id']="33";
	$service = 1;

// Nome, telefone, rating, comment
?>




<?php
	
$url=parse_url(getenv("CLEARDB_DATABASE_URL"));
mysql_connect(
        $server = $url["host"],
        $username = $url["user"],
        $password = $url["pass"]);
        $db=substr($url["path"],1);

mysql_select_db($db);

ini_set("display_errors", "1");
error_reporting(E_ALL);


	if(isset($_POST['name'])){
		mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('".$_SESSION['id_worker']."', '".$_SESSION['user_id']."', '".$_POST['service']."', '".$_POST['rating']."', '".$_POST['comment']."')");

	}

	
?>


<?php
if (count($_POST) > 0) {
  print json_encode($_POST);
  die();
}
?>


<div>
	<form name="add_new" action="#" method="post">
		<input type="hidden" name="id_worker" value="1" /><br>
		<input type="hidden" name="service" value="1" />
		Rating: <input type="text" name="rating" required="required" /><br>
		Comentario: <input type="text" name="comment" required="required" /><br>
		<input type="submit" value="Submit" />
	</form>
</div>