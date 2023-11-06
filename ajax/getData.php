<?php

//Only proceed if the id is present in the URL and it is a positive, non-zero integer
if(!isset($_GET['id']) || !is_numeric($_GET['id']) || strpos($_GET['id'], '.') !== false || $_GET['id'] <= 0){
    http_response_code(400);
    die;
}
$id = $_GET['id'];
$updateTime = json_decode(file_get_contents('php://input'), true)['updateTime'];

require_once(__DIR__ . '/scripts/db.php');

$newData = query('SELECT data FROM Sessions WHERE id = :id AND JSON_EXTRACT(data, "$.updateTime") > :updateTime',
        array(':id' => $id, ':updateTime' => $updateTime));

if(count($newData) == 0){
    echo json_encode(array('status' => 'ok'));
}else{
    echo $newData[0]['data'];
}

