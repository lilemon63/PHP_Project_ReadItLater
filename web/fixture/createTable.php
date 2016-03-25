<?php

$servername = "127.0.0.1";
$username = "rit_user";
$password = "a1z2e3r4";
$dbname = "rit_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "drop table if exists rit_link;
drop table if exists rit_categorie;


create table rit_categorie (
    cat_id integer not null primary key auto_increment,
    cat_name varchar(128) not null
);


create table rit_link (
	lnk_id integer not null primary key auto_increment,
	lnk_url varchar(256) not null,
	lnk_status integer not null,
	lnk_content TEXT,
	lnk_title varchar(128),
	cat_id integer,
	
    constraint fk_cat_lnk foreign key(cat_id) references rit_categorie(cat_id)
);
";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Tables created.";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
