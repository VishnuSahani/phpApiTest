<?php


    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        header('Access-Control-Max-Age: 1728000');
        header('Content-Length: 0');
        // header('Content-Type: text/plain');
        die();
    }

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Content-Type: application/json');
// 'Content-Type':'application/json'

header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');


   
//echo "Hiii";

// $a = file_get_contents('php://input');
$a = simplexml_load_file('php://input');

$b = json_encode($a);

if(isset($a->acton)){

    $ret = [
        'result' => 'Post Api proper work',
    ];
    print json_encode($ret);

}else{
    echo "wrong";

    print_r($b['action']);

}


?>