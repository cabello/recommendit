<?php
	session_start();
	
	
$url=parse_url(getenv("CLEARDB_DATABASE_URL"));
mysql_connect(
        $server = $url["host"],
        $username = $url["user"],
        $password = $url["pass"]);
        $db=substr($url["path"],1);

mysql_select_db($db);



$servs = mysql_query("SELECT * FROM service");
$works = mysql_query("SELECT * FROM worker");
$recs = mysql_query("SELECT id, id_facebook, id_worker, avg(rating), comment FROM recommendation GROUP BY id");

	if(isset($_POST['name'])){
		$SQLQuery = "INSERT INTO worker (name, phone, id_service) VALUES (".$_POST['name'].", ".$_POST['telephone'].", 2)";
		echo $SQLQuery;
		mysql_query($SQLQuery);
		
	}

?>

<html>

<head>
</head>
<body>

<div>
	<form name="add_new" action="#" method="post">
		Nome: <input type="text" name="name" /><br>
		Telefone: <input type="text" name="telephone" /><br>
		Rating: <input type="text" name="rating" /><br>
		Comentario: <input type="text" name="comment" /><br>
		<input type="submit" value="Submit" />
	</form>
</div>
</body>
</html>