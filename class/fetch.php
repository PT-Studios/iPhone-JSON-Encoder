<?php



// Make a MySQL Connection
require_once $_SERVER["DOCUMENT_ROOT"] . '/app/class/json.php';

header('Content-Type: application/json; charset=utf-8');

//EXAMPLE URL:  ?proc=cards_get&type=card&params[]=1

$getProc = empty($_GET['proc']) ? '' : $_GET['proc'];
$getType = empty($_GET['type']) ? '' : $_GET['type'];
$getParams = empty($_GET['params']) ? '' : $_GET['params'];

$json = new jsonFetch($getProc, $getType, $getParams);
echo ($json->results());

?>
