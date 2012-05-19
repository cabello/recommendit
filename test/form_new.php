<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>

<script>

$.post(
  'nosource/request', 
  {
    this: 'is the',
    coolest: 'hack',
    ever: '',
  },
  function(response) {
    alert(response);
  }
);
</script>


<?php
	session_start();
	$_SESSION['user_id']="33";
	$service = 1;

// Nome, telefone, rating, comment




	
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
		mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('".$_POST['name']."', '".$_POST['telephone']."', '".$_POST['service']."')");
		$new_id = mysql_insert_id();
		mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('".$new_id."', '".$_SESSION['user_id']."', '".$_POST['service']."', '".$_POST['rating']."', '".$_POST['comment']."')");

	}

	
?>

<html>

<head>
</head>
<body>

<div>
	<form name="add_new" action="#" method="post">
		Nomee: <input type="text" name="name" required="required" /><br>
		<input type="hidden" name="service" value="1" />
		Telefone: <input type="text" name="telephone" required="required" /><br>
		Rating: <input type="text" name="rating" required="required" /><br>
		Comentario: <input type="text" name="comment" required="required" /><br>
		<input type="submit" value="Submit" />
	</form>
</div>
</body>
</html>