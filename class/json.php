<?php


// Make a MySQL Connection
require_once $_SERVER["DOCUMENT_ROOT"] . '/app/config/config.php';

//EXAMPLE URL:  http://tethyr.palmtree-studios.net/app/class/fetch.php?proc=getCard&type=card&params[]=1
// http://tethyr.palmtree-studios.net/app/class/fetch.php?proc=getCardsAll&type=card

class jsonFetch{

	public $proc;
	public $type;
	public $params = array();

	private $paramArray;
	private $valueArray;
	private $data;

	public function __construct($proc, $type, $params){
		$this->proc = $proc;
		$this->type = $type;
		$this->params = $params;

		$this->paramArray = $paramArray;
		$this->valueArray = $valueArray;
		$this->data = $data;

		//If parameters, build Array
		if (!empty($this->params)){
			foreach ($this->params as $i => $value) {
				$this->paramArray [":param".$i] = $value;
			}

			//Prepare Stored Procedure Call w/ Params
			$dbConn = new ConnDB();
			$dbConn->query("CALL " . $this->proc . '('.implode(', ', array_keys($this->paramArray )).')');

			//Bind Params
			foreach ($this->paramArray as $key => $value) {
				$dbConn->bind($key, $value);
			}

			//Get Result$$$
			$row = $dbConn->single();

			//Build Value Array for JSON
			foreach ($row as $key => $value) {
				$this->valueArray[$key] = $value;
			}

			//Json Format
			$this->data = array(
				"results" => array(
					array(
						$this->type => $this->valueArray
					),
				)
			);
		} else {
			// Prepare Stored Procedure Call
			$dbConn = new ConnDB();
			$dbConn->query("CALL " . $this->proc);

			//Get Result$$$
			$row = $dbConn->resultset();

			//
			$jsonArray = array();
			foreach ($row as $key => $value) {
				array_push($jsonArray, array($this->type => $value));
			}

			$this->data = array(
				"results" => $jsonArray,
			);
		}

	//END Class
	}

	public function results(){
		return json_encode($this->data, JSON_PRETTY_PRINT);
	}

}


//DEPRICIATED FUNCTION
function fetchProc($proc, $type, $params){

	//Build Parameter Array
	$paramArray = array();
	foreach ($params as $i => $value) {
		$paramArray[":param".$i] = $value;
	}

	// Prepare Stored Procedure Call
	$dbConn = new ConnDB();
	//$query = "CALL " . $_GET['proc'] . '('.implode(', ', array_keys($paramArray)).')';
	$dbConn->query("CALL " . $proc . '('.implode(', ', array_keys($paramArray)).')');
	foreach ($paramArray as $key => $value) {
		$dbConn->bind($key, $value);
	}
	//$dbConn->bind(':card_id', $params);
	$row = $dbConn->single();

	$valueArray = array();
	foreach ($row as $key => $value) {
		$valueArray[$key] = $value;
	}

	$dataMult = array(
		"results" => array(
			array(
				$type => $valueArray
			),
		)
	);

	return json_encode($dataMult, JSON_PRETTY_PRINT);
}

//echo fetchProc($getProc, $getType, $getParams);


?>