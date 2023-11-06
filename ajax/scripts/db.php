<?php

$dbInfo = explode('|', file_get_contents('/home/cupcake/dbPass'));

$mysqlHost = trim($dbInfo[0]);
$mysqlDatabase = trim($dbInfo[1]);
$mysqlUser = trim($dbInfo[2]);
$mysqlPassword = trim($dbInfo[3]);

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
