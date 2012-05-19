<?
session_start();
echo "here";
$actual_code = $_GET["code"];
//echo phpinfo();
//var_dump($_GET);
//var_dump($_SESSION);

ini_set("display_errors", "1");
error_reporting(E_ALL);


if (isset($actual_code)) {
//	echo "INSIDE";
	$app_id = 	$_SESSION["app_id"];
	$redirect_uri = $_SESSION["redirect_uri"];
	$app_secret =	$_SESSION["app_secret"];

	$url = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_uri&client_secret=$app_secret&code=$actual_code";
	ini_set('allow_url_fopen', "on");

//	$url = "hwww.google.com";
	$answer = file_get_contents($url);	
	
	$matches = explode($answer, "&");
	var_dump($matches);
	$token = $matches[0];
	echo "[".$token."]<br>";
}



?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
xmlns:fb="https://www.facebook.com/2008/fbml"> 
<head
<title>OG Tutorial App</title>
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
