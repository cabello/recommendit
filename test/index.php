<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
xmlns:fb="https://www.facebook.com/2008/fbml"> 
<head>
<title>OG Tutorial App</title>
</head>
<body>
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
	FB.init({
appId      : '[362571837137094]', // App ID
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

<fb:login-button show-faces="true" width="200" max-rows="1" scope="publish_actions">
</fb:login-button>

<h3>Stuffed Cookies</h3>
<p>
<img title="Stuffed Cookies" 
src="http://fbwerks.com:8000/zhen/cookie.jpg" 
width="550"/>
</p>
</body>
</html>
