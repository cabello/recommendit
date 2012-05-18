<?php

$url=parse_url(getenv("CLEARDB_DATABASE_URL"));

mysql_connect(
        $server = $url["host"],
        $username = $url["user"],
        $password = $url["pass"]);
        $db=substr($url["path"],1);

mysql_select_db($db);

mysql_query('DROP TABLES');

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
mysql_query("INSERT INTO worker (name, phone, id_service) VALUES ('Silmara', '1188553322', '1')");
mysql_query("INSERT INTO recommendation (id_worker, id_facebook, id_service, rating, comment) VALUES ('1', '1023132131', '1', '4', 'Gosto muito dela')");

$result = mysql_query("SELECT * FROM service");
if ($result) {
    echo "<ul>";
    while ($row = mysql_fetch_assoc($result)) {
        echo "<li>";
        echo "ID: ";
        echo $row['id'];
        echo "Name: ";
        echo $row['name'];
        echo "</li>";
    }
    echo "</ul>";
}

echo "<hr />";

?>
