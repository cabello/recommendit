
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
$recs = mysql_query("SELECT id, id_facebook, id_worker, avg(rating), comment FROM recommendation GROUP BY id");

echo "Services:<br />";
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

echo "Workers:<br />";
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

echo "Recommendations:<br />";
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
