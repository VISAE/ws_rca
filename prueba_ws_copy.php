<?php
include_once("ws.php");

$ws = new ws("https://rca.unad.edu.co/api_edunat/v1/");

// $data = $ws->getServicio("EnrolledStudents/Period/".base64_encode('473'));
$data = $ws->getServicio("period");

var_dump($data);

/*foreach ($data as $value) {
	echo base64_decode($value['id']).': '.htmlentities(base64_decode($value['descripcion']));
	echo "<br>";

}*/