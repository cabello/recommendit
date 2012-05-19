<?php

$url=parse_url(getenv("CLEARDB_DATABASE_URL"));

mysql_connect(
        $server = $url["host"],
        $username = $url["user"],
        $password = $url["pass"]);
        $db=substr($url["path"],1);

mysql_select_db($db);

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

mysql_query('
CREATE  TABLE IF NOT EXISTS `service` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
');

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


mysql_query("INSERT INTO service (name) VALUES ('Diarista')");
mysql_query("INSERT INTO service (name) VALUES ('Mecanico')");
mysql_query("INSERT INTO service (name) VALUES ('Medico')");
mysql_query("INSERT INTO service (name) VALUES ('Taxista')");
mysql_query("INSERT INTO service (name) VALUES ('Dentista')");


mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Silmara', '1188544320', '1')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Mr. Anderson', '1185443312', '11')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Dr. Evil', '1197552328', '21')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Jonny_boy', '12846d3024', '31')");
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Cyntia', '1185355322', '41')");


mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('1', '501050133', '1', '4', 'Gosto muito dela')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('1', '361759103', '1', '2', 'Robo minha grana')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('2', '462734163', '11', '5', 'Melhor do Mundo!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('3', '356134103', '21', '5', 'Melhor do Mundo!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('4', '262184106', '31', '5', 'Melhor do Mundo!')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('5', '15213u183', '41', '5', 'Melhor do Mundo!')");

echo "Done!";

?>
