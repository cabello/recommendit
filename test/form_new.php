<?php

		echo $_POST['name']." ".$_POST['telephone']." ".$_POST['rating']." ".$_POST['comment'];
	

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