<?php

include 'Proccess.php';
require 'Autoload.php';
#print_r($_SERVER);exit;


$method = $_SERVER['REQUEST_METHOD'];
$url = $_SERVER['PATH_INFO'];

$proccess = new Proccess();
try {
    $res = $proccess->run($url,  strtolower($method));
    
    echo json_encode($res);
} catch (Exception $ex) {
    echo json_encode(array("errorMessage" => $ex->getMessage()));
}