
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

$recs = mysql_query("SELECT id, id_facebook, id_worker, avg(rating), comment FROM recommendation GROUP BY id_worker");
//$recs = mysql_query("SELECT * FROM recommendation GROUP BY id");


if ($servs) {

    while ($serv_i = mysql_fetch_assoc($servs)) {

        echo $serv_i["name"]."<br />";

	$service_id = $serv_i["id"];

	$works = mysql_query("SELECT * FROM worker where id_service = service_id");

	if ($works) {
    		while ($worker_i = mysql_fetch_assoc($works)) {
			$worker_id = $worker_i["id"];
			$q = mysql_query("select avg(rating) AS rating FROM recommendation WHERE id_worker = $worker_id");
			$x = mysql_fetch_assoc($q);
			$rating = $x["rating"];
			echo $worker_i["nome"]." ".$worker_i["phone"]." ".$rating." ".$comments."<br />";
		}
	}
    }
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
