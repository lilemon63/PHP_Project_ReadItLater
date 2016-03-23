<?php

/*
$host="127.0.0.1"; 

$root="root"; 
$root_password="admin"; 

$user='Lilemon';
$pass='a1z2e3r4';
$db="RIT_DB"; 
*/

$servername = "127.0.0.1";
$username = "Lilemon";
$password = "a1z2e3r4";
$dbname = "RIT_DB";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS RIT_Link (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		lien VARCHAR(256),
		status INT(2) NOT NULL
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table RIT_Link created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
