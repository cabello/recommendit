<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
xmlns:fb="https://www.facebook.com/2008/fbml"> 
<head>
<title>OG Tutorial App</title>
</head>
<body>
<div id="fb-root"></div>
<script>
<?
	$app_id = "362571837137094";
	$index_url = "http://fb-hacktoon.herokuapp.com/";
	$permittion_names = "read_friendlists,read_insights";
	$last_param = "_unique_are_you";
?>
window.fbAsyncInit = function() {
	FB.init({
appId      : <?$app_id?>, // App ID
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
<?
header("location: https://www.facebook.com/dialog/oauth?client_id=$app_id&redirect_uri=$index_url&scope=$permittion_names&state=$last_param");
?>
</p>
</body>
</html>
