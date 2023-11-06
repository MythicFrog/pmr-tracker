<?php

// This file should contain 1 line with the string 
//      MYSQL_HOST|DB_NAME|USERNAME|PASSWORD
$dbInfo = explode('|', file_get_contents('PATH/TO/DB_CREDENTIALS'));

$mysqlHost = trim($dbInfo[0]);
$mysqlDatabase = trim($dbInfo[1]);
$mysqlUser = trim($dbInfo[2]);
$mysqlPassword = trim($dbInfo[3]);

/* CREATING THE DB TABLE

CREATE TABLE `Sessions` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`data` LONGTEXT NOT NULL DEFAULT '{}' COLLATE 'utf8mb4_bin',
	PRIMARY KEY (`id`) USING BTREE,
	CONSTRAINT `data` CHECK (json_valid(`data`))
);

*/
$con = new PDO('mysql:host=' . $mysqlHost . ';dbname=' . $mysqlDatabase, $mysqlUser, $mysqlPassword);

function query($query, $params = null){
        global $con;

        ping();

        $statement = $con->prepare($query);
        if($params != null)
                $statement->execute($params);
        else
                $statement->execute();

        $retVal = $statement->fetchAll();
        $statement = null;
        return $retVal;
}

function lastInsertID(){
        global $con;

        return $con->lastInsertId();
}

function ping(){
        global $con;
        global $mysqlHost;
        global $mysqlDatabase;
        global $mysqlUser;
        global $mysqlPassword;

        try{
                $statement = $con->prepare('SELECT 1');
                $statement->execute();
                $statement = null;
        }catch(Exception $e){
                $con = null;
                $con = new PDO('mysql:host=' . $mysqlHost . ';dbname=' . $mysqlDatabase, $mysqlUser, $mysqlPassword);
        }
}
