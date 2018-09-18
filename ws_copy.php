<?php

/**
* 
*/
class ws
{
	private $base_url;	
	private $token;
    private $curl;

	function __construct($base_url) {
    	$this->base_url = $base_url;
    	$this->curl = curl_init($this->base_url . "token");
    	
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);	
		$this->token = json_decode($this->exec());
    }


	function getServicio($servicio) {
        curl_setopt($this->curl, CURLOPT_URL, $this->base_url . $servicio);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: ' . $this->token->token));

        $rta = json_decode($this->exec(), true);
        if ($rta['error'] == true) {
            print_r(utf8_decode($rta['message'] . ' En el servicio ' . $servicio));
            exit;
        }
        return $rta['info'];
    }
// $servicio es la uri del servicio
// $this->base_url es la primera parte de la uri del servicio
	function exec() {
        return curl_exec($this->curl);
    }

    function getInfo() {
        echo $this->token->token;		
    }

}

/*$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://rca.unad.edu.co/api_edunat/v1/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$token = json_decode($res);
// echo ($token->token);
curl_close($ch);


// configuración de la petición indicando la URI
$path = "https://rca.unad.edu.co/api_edunat/v1/period";
$ch = curl_init($path);
// retorna los datos de salida como una cadena
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// se retorna información de quien conecta al servidor de R&C
// curl_setopt($ch, CURLOPT_USERAGENT, 'SIVISAE (omar.bautista@unad.edu.co)');
// configuración de las cabeceras
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token->token
    ));

// cadena con los datos de salida de la petición
$data =curl_exec($ch);
// información acerca de la petición
$info = curl_getinfo($ch);


var_dump($data);
var_dump($info);

curl_close($ch);*/