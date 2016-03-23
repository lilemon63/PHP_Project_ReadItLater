<?php

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/index/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});


$app->get('/index', function ($name) use ($app) {
	include (__DIR__ . '');
    return '';
});

$app->get('/info', function () use ($app) {
    return phpinfo();//'Hello '.$app->escape($name);
});


$app->get('/system/createDB', function () use ($app) {
	include(__DIR__ .'/DB/createDB.php');
	//return phpinfo();//'Hello '.$app->escape($name);
	return "<br/>";
});


$app->get('/system/createTable', function () use ($app) {
	include(__DIR__ . '/DB/createTable.php'); 

	//return phpinfo();//'Hello '.$app->escape($name);
	return "<br/>";
});

$app->run();

/*
 [Tue Mar 22 13:37:11 2016] PHP Warning:  
 * include(	/home/lilemon/priv/PHP_Project_ReadItLater/web/DB/createTable.php)
			/home/lilemon/priv/PHP_Project_ReadItLater/web/BD/


  : failed to open stream: No such file or directory in /home/lilemon/priv/PHP_Project_ReadItLater/web/index.php on line 26
[Tue Mar 22 13:37:11 2016] PHP Warning:  include(): Failed opening '/home/lilemon/priv/PHP_Project_ReadItLater/web/DB/createTable.php' for inclusion (include_path='.:/usr/share/php') in /home/lilemon/priv/PHP_Project_ReadItLater/web/index.php on line 26

 * */

//require_once __DIR__.'/createDB.php';

/*
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
*/
