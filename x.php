 <? echo "Hello world!"; 
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
  `id_facebook` INT NULL ,
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
mysql_query("INSERT INTO service (name) VALUES ('Maid')");
mysql_query("INSERT INTO service (name) VALUES ('Mechanical')");
mysql_query("INSERT INTO service (name) VALUES ('Car wash')");
mysql_query("INSERT INTO service (name) VALUES ('Taxi driver')");
mysql_query("INSERT INTO service (name) VALUES ('Mudança')");


 
 ?>
