<?php
$ret = file_get_contents('https://paper-mario-randomizer-server.ue.r.appspot.com/randomizer_settings/' . urlencode($_GET['seed']));

try{
    json_decode($ret);
    http_response_code(200);
    echo $ret;
}catch(Exception $e){
    http_response_code(404);
}