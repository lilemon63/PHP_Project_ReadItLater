<?php

$host="127.0.0.1"; 

$root="root"; 
$root_password="admin"; 

$user='Lilemon';
$pass='a1z2e3r4';
$db="RIT_DB"; 

    try {
		echo "before\n";
        $dbh = new PDO("mysql:host=$host", $root, $root_password);
		echo "after\n";
        $dbh->exec("CREATE DATABASE IF NOT EXISTS `$db`;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                GRANT ALL ON `$db`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;") 
        or die(print_r($dbh->errorInfo(), true));

    } catch (PDOException $e) {
        die("DB ERROR: ". $e->getMessage());
    }

/*
$servername = "localhost";
$username = "Lilemon";
$password = "a1z2e3#4";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "CREATE DATABASE RIL_DB";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
*/
/*
$servername = "localhost";
$username = "admin";
$password = "a1z2e3r4";

// Create connection
$conn = mysqli_connect($servername, $username, $password);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE RIT_DB";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

mysqli_close($conn);
*/

/*
$link = mysql_connect('localhost', 'mysql_user', 'mysql_password');
if (!$link) {
    die('Connexion impossible : ' . mysql_error());
}

echo "KEKECHOZ ?!";
$sql = 'CREATE DATABASE my_db';
if (mysql_query($sql, $link)) {
    echo "Base de données créée correctement\n";
} else {
    echo 'Erreur lors de la création de la base de données : ' . mysql_error() . "\n";
}*/

