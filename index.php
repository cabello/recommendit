<?php


$actual_code = $_GET["code"];

if (!isset($actual_code)) {
	$app_id = 	$_SESSION["app_id"];
	$redirect_uri = $_SESSION["redirect_uri"];
	$app_secret =	$_SESSION["app_secret"];

	$url = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_uri&client_secret=$app_secret&code=$actual_code";

	$answer = file_get_contents($url);
	echo $answer."<br>";
}

$url=parse_url(getenv("CLEARDB_DATABASE_URL"));

mysql_connect(
        $server = $url["host"],
        $username = $url["user"],
        $password = $url["pass"]);
        $db=substr($url["path"],1);

mysql_select_db($db);

$result = mysql_query("SELECT * FROM service");
if ($result) {
    echo "<ul>";
    while ($row = mysql_fetch_assoc($result)) {
        echo "<li>";
        print_r($row);
        echo "</li>";
    }
    echo "</ul>";
}

echo "<hr />";

$result = mysql_query("SELECT * FROM worker");
if ($result) {
    echo "<ul>";
    while ($row = mysql_fetch_assoc($result)) {
        echo "<li>";
        print_r($row);
        echo "</li>";
    }
    echo "</ul>";
}

echo "<hr />";

$result = mysql_query("SELECT * FROM recommendation");
if ($result) {
    echo "<ul>";
    while ($row = mysql_fetch_assoc($result)) {
        echo "<li>";
        print_r($row);
        echo "</li>";
    }
    echo "</ul>";
} else {
  $message  = 'Invalid query: ' . mysql_error() . "\n";
  $message .= 'Whole query: ' . $query;
  echo $message;
}

echo "<hr />";


?>
