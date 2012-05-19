<?php
echo '-4';
ini_set("display_errors", "1");
error_reporting(E_ALL);

$url=parse_url(getenv("CLEARDB_DATABASE_URL"));

mysql_connect(
        $server = $url["host"],
        $username = $url["user"],
        $password = $url["pass"]);
        $db=substr($url["path"],1);

mysql_select_db($db);
echo '-3';

$result = mysql_query('DROP TABLES recommendation');
if (! $result) {
  $message  = 'Invalid query: ' . mysql_error() . "\n";
  $message .= 'Whole query: ' . $query;
  echo $message;
}
$result = mysql_query('DROP TABLES worker');
if (! $result) {
  $message  = 'Invalid query: ' . mysql_error() . "\n";
  $message .= 'Whole query: ' . $query;
  echo $message;
}
$result = mysql_query('DROP TABLES service');
if (! $result) {
  $message  = 'Invalid query: ' . mysql_error() . "\n";
  $message .= 'Whole query: ' . $query;
  echo $message;
}
echo '-2';
mysql_query('
CREATE  TABLE IF NOT EXISTS `service` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
');

echo '-1';
mysql_query('
CREATE  TABLE IF NOT EXISTS `worker` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL ,
  `phone` VARCHAR(255) NULL ,
  `id_service` INT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fg_service` (`id_service` ASC) ,
  CONSTRAINT `fg_worker_service`
    FOREIGN KEY (`id_service` )
    REFERENCES `service` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
');

echo '0';

mysql_query('
CREATE  TABLE IF NOT EXISTS `recommendation` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_facebook` VARCHAR(255) NULL ,
  `id_worker` INT NULL ,
  `id_service` INT NULL ,
  `rating` TINYINT NULL ,
  `comment` VARCHAR(140) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fg_worker` (`id_worker` ASC) ,
  INDEX `fg_service` (`id_service` ASC) ,
  CONSTRAINT `fg_recommendation_worker`
    FOREIGN KEY (`id_worker` )
    REFERENCES `worker` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fg_recommendation_service`
    FOREIGN KEY (`id_service` )
    REFERENCES `service` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
');

echo '1';
mysql_query("INSERT INTO service (name) VALUES ('Housemaid')");
mysql_query("INSERT INTO service (name) VALUES ('Mechanical')");
mysql_query("INSERT INTO service (name) VALUES ('Car wash')");
mysql_query("INSERT INTO service (name) VALUES ('Taxi driver')");
mysql_query("INSERT INTO service (name) VALUES ('Movers')");

echo '2';
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Silmara',  '1188541320', '1')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Jurema',   '2184544320', '1')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Cleonice', '4168544320', '1')");

mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Mr. Anderson',     '2185647312', '11')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Mr. Anderson Jr.', '1185443312', '11')");

mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Mr. Cleanish', '1197552328', '21')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Carlao', '1187552328', '21')");

mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Jonny boy', '1284504024', '31')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Fasty Carl', '1284233024', '31')");

mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Cyntia', '1185355322', '41')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Maria', '1184353312', '41')");

$vns = "100000425648853";
$lucas = "100001263599179";
$thiago = "100001086552469";
$marcos = "1263110684";
$carlos = "1051587225";
$pa = "1389995798"; //rafael
$pb = "100001196684302"; //nanda
$pc = "628355049"; //naty


echo '3';
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('1', ".$carlos.",  '1', '5', 'Very good one')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('1', ".$vns.",     '1', '4', 'She was great!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('11', ".$pc.",     '1', '3', 'High price')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('11', ".$thiago.", '1', '4', '')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('21', ".$marcos.", '1', '2', 'Stole my cash!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('21', ".$lucas.",  '1', '4', 'Top na balada')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('21', ".$pa.",     '1', '1', 'Way too bad')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('21', ".$pb.",     '1', '3', 'No comments!')");


echo '4';
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('31', ".$pc.",     '11', '5', 'Fixed my car quickly')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('31', ".$lucas.",  '11', '4', 'Good price')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('31', ".$thiago.", '11', '5', 'Very nice dude')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('31', ".$marcos.", '11', '3', 'Ok..ok')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('41', ".$vns.",    '11', '1', 'Horrible service')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('41', ".$carlos.", '11', '2', 'Avoid at all cost')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('41', ".$pb.",     '11', '5', 'Record time :-)')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('41', ".$pa.",     '11', '5', 'Very cheap!')");

echo '5';
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('51', ".$pa.", 	 '21', '3', 'Not bad..')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('51', ".$pb.", 	 '21', '1', 'Very expensive!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('51', ".$carlos.", '21', '5', 'Saved a lot of water')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('51', ".$marcos.", '21', '1', 'Asshole')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('61', ".$vns.", 	 '21', '5', 'Perfect guy for the job')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('61', ".$pc.",  	 '21', '4', 'Pretty Goood!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('61', ".$lucas.",  '21', '3', 'So so!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('61', ".$thiago.", '21', '1', 'Pretty bad..')");

echo '6';
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('71', ".$thiago.", '31', '3', 'Not bad..')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('71', ".$pc.", 	 '31', '5', 'Dijkstra FTW! Loved it!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('71', ".$carlos.", '31', '2', 'Very expensive!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('81', ".$pa.", 	 '31', '1', 'Took the longest way')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('81', ".$marcos.", '31', '3', 'Depth first search..')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('81', ".$lucas.",  '31', '4', 'Good!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('81', ".$pb.", 	 '31', '1', 'Knows nothing about graphs...')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('81', ".$vns.",    '31', '4', 'Good!')");

echo '7';
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('91', ".$marcos.", '41', '5', 'Great team')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('91', ".$vns.", 	 '41', '4', 'I'd call him again!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('91', ".$pa.", 	 '41', '1', 'Sucked so bad')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('91', ".$carlos.", '41', '4', 'Not bad..')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('101', ".$thiago.", '41', '3', 'Ok..ok')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('101', ".$pb.", 	 '41', '2', 'Terrible assistence')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('91', ".$lucas.",  '41', '1', 'Throwed my stuff from the truck..')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('101', ".$pc.", 	 '41', '4', 'Speed ticked detected')");

echo "Done!";

?>
