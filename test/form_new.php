<?php
	session_start();
	
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
		mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('".$_POST['name']."', '".$_POST['telephone']."', '1')");
		mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('1', '213231321231', '1', '4', 'Gosto muito dela')");
	}

?>

<html>

<head>
</head>
<body>

<div>
	<form name="add_new" action="" method="post">
		Nomee: <input type="text" name="name" /><br>
		Telefone: <input type="text" name="telephone" /><br>
		Rating: <input type="text" name="rating" /><br>
		Comentario: <input type="text" name="comment" /><br>
		<input type="submit" value="Submit" />
	</form>
</div>
</body>
</html>