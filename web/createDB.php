<?php

$host="127.0.0.1"; 

$root="root"; 
$root_password="admin"; 

$user='rit_user';
$pass='a1z2e3r4';
$db="rit_db"; 

grant all privileges on rit_db.* to 'rit_user'@'localhost' identified by 'a1z2e3r4';

try {
	$dbh = new PDO("mysql:host=$host", $root, $root_password);
	$dbh->exec("CREATE DATABASE IF NOT EXISTS `$db`;
			CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
			GRANT ALL ON `$db`.* TO '$user'@'localhost';
			FLUSH PRIVILEGES;") 
	or die(print_r($dbh->errorInfo(), true));
	echo "Database created.";
} catch (PDOException $e) {
	die("DB ERROR: ". $e->getMessage());
}
