<?php

$url=parse_url(getenv("CLEARDB_DATABASE_URL"));

mysql_connect(
        $server = $url["host"],
        $username = $url["user"],
        $password = $url["pass"]);
        $db=substr($url["path"],1);

mysql_select_db($db);

mysql_query('CREATE  TABLE IF NOT EXISTS `service` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;');

mysql_query("INSERT INTO service (name) VALUES ('Diarista');");

$result = mysql_query("SELECT * FROM service;");
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        echo $row['id'];
        echo $row['name'];
    }
}

?>
