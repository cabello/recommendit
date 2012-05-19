
<?
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
$recs = mysql_query("SELECT * FROM recommendation");

if ($servs) {
    echo "<ul>";
    while ($row = mysql_fetch_assoc($servs)) {
        echo "<li>";
        print_r($row);
        echo "</li>";
    }
    echo "</ul>";
}

echo "<hr />";

if ($works) {
    echo "<ul>";
    while ($row = mysql_fetch_assoc($works)) {
        echo "<li>";
        print_r($row);
        echo "</li>";
    }
    echo "</ul>";
}

echo "<hr />";

if ($recs) {
    echo "<ul>";
    while ($row = mysql_fetch_assoc($recs)) {
        echo "<li>";
        print_r($row);
        echo "</li>";
    }
    echo "</ul>";
}
echo "<hr />";



?>
