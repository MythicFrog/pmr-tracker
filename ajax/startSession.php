<?php

require_once(__DIR__ . '/scripts/db.php');

query('INSERT INTO Sessions (data) VALUES (:data)', array(':data' => file_get_contents('php://input')));

echo json_encode(array('id' => lastInsertID()));