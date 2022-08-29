<?php
$url = "localhost:3306";
$name = "nothung";
$passwd  = "123";

$con = mysqli_connect($url, $name, $passwd);

$create_db = "CREATE DATABASE IF NOT EXISTS database1";
mysqli_query($con, $create_db);
mysqli_select_db($con, "database1");


/// init dtbs

$sql_user  = "
CREATE TABLE IF NOT EXISTS user (
  id int NOT NULL AUTO_INCREMENT,
  firstname varchar(255) NOT NULL,
  lastname varchar(255) NOT NULL,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  status tinyint(1) NOT NULL,
  isAdmin tinyint(1) NOT NULL,
    PRIMARY KEY (id)
);";

$sql_post = "
    CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);";

mysqli_query($con, $sql_user);
mysqli_query($con, $sql_post);
