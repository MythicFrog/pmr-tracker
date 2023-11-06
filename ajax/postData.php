<?php

//Only proceed if the id is present in the URL and it is a positive, non-zero integer
if(!isset($_GET['id']) || !is_numeric($_GET['id']) || strpos($_GET['id'], '.') !== false || $_GET['id'] <= 0){
    http_response_code(400);
    die;
}
$id = $_GET['id'];

require_once(__DIR__ . '/scripts/db.php');

query('UPDATE Sessions SET data = :data WHERE id = :id AND JSON_EXTRACT(data, "$.updateTime") < JSON_EXTRACT(:data, "$.updateTime");',
        array(':id' => $id, ':data' => file_get_contents('php://input')));

echo json_encode(array('status' => 'ok'));