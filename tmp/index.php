<?
session_start();
echo "here";
$actual_code = $_GET["code"];

ini_set("display_errors", "1");
error_reporting(E_ALL);


/*if (isset($actual_code)) {
	$app_id = 	$_SESSION["app_id"];
	$redirect_uri = $_SESSION["redirect_uri"];
	$app_secret =	$_SESSION["app_secret"];

	$url = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_uri&client_secret=$app_secret&code=$actual_code";
	ini_set('allow_url_fopen', "on");

	$answer = file_get_contents($url);

	$matches = explode("&", $answer);
	$token = $matches[0];
	$_SESSION["token"] = $token;

}*/
if (isset($_SESSION["token"])) {
	$query = "https://graph.facebook.com/me?access_token=".$_SESSION["token"];
	$answer = file_get_contents($query);

	$user_data = json_decode($answer, true);

	var_dump($user_data);

	var_dump($user_data["id"]);
	echo "ID: ".$user_data["id"]."<br />";

	$_SESSION["user_id"] = $user_data["id"];

	$query = "https://graph.facebook.com/".$user_data["id"]."?fields=picture";

	$answer = file_get_contents($query);
	$answer = json_decode($answer, true);
	echo "Photo query: ".$query."<br />";

	echo "<img src='".$answer["picture"]."'/><br />";
	$query = "https://graph.facebook.com/me/friends?access_token=".$_SESSION["token"];
	$answer = file_get_contents($query);
	$friends = json_decode($answer);
}


$x = "<a href='all.php'>ALL HERE</a>";
$y = "<a href='form_new.php'>ALL HERE</a>";
$z = "<a href='form_eval.php'>ALL HERE</a>";
echo "<br>";
echo $x."<br>";
echo $y."<br>";
echo $z."<br>";

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
xmlns:fb="https://www.facebook.com/2008/fbml">
<head
<title>Main App</title>
</head>
<body>
<div id="fb-root"></div>
<script>

window.fbAsyncInit = function() {
	FB.init({
appId      : 362571837137094, // App ID
status     : true, // check login status
cookie     : true, // enable cookies to allow the server to access the session
xfbml      : true  // parse XFBML
});
};

// Load the SDK Asynchronously
(function(d){
 var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
 js = d.createElement('script'); js.id = id; js.async = true;
 js.src = "//connect.facebook.net/en_US/all.js";
 d.getElementsByTagName('head')[0].appendChild(js);
 }(document));
</script>

<fb:login-button show-faces="true" width="400" height="1000" max-rows="1" scope="publish_actions">
</fb:login-button>

<div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1"></div>
</p>
</body>
</html>
