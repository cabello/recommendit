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
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<title>Share your recommendation!</title>
</head>
<body>
<div id='fb-root'></div>
<script src='http://connect.facebook.net/en_US/all.js'></script>
<p><a onclick='postToFeed(); return false;'>Post to Feed</a></p>
<p id='msg'></p>

<script> 
FB.init({appId: <? echo $_SESSION["appid"]; ?>, status: true, cookie: true});

function postToFeed() {

	// calling the API ...
	var obj = {
method: 'feed',
	link: 'https://developers.facebook.com/docs/reference/dialogs/',
	picture: 'http://fbrell.com/f8.jpg',
	name: 'Facebook RecommendIt',
	caption: 'RecommendIt!',
	description: 'Share you your friends.'
	};

	function callback(response) {
		document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
	}

	FB.ui(obj, callback);
}

</script>
</body>
</html>



