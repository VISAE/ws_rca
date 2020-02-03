<?php

/**
* 
*/
class ws
{
    private $base_url = "https://rca.unad.edu.co/api_edunat/v1";   
    private $token;
    private $curl;
    private $peticiones;

    function __construct() {
        $this->curl = curl_init($this->base_url . "/token");
        
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true); 
        $this->token = json_decode($this->exec());
        $this->peticiones = array(  'vigencias' => '/current',
                                    'periodos' => '/period',
                                    'periodo_especifico' => '/period/',
                                    'periodos_vigencia_especifica' => '/period/current/',
                                    'escuelas' => '/school',
                                    'escuela_especifica' => '/school/',
                                    'escuela_especifica_' => '/School/',
                                    'programas' => '/program',
                                    'programa_especifico' => '/program/',
                                    'programa_especifico_' => '/Program/',
                                    'programas_escuela_especifica' => '/program/school/',
                                    'programas_nivel_formacion' => '/program/level/',
                                    'programas_escuela_nivel_formacion' => '/program/level/',
                                    'niveles' => '/level',
                                    'nivel_especifico' => '/level/',
                                    'zonas' => '/zone',
                                    'zona_especifica' => '/Zone/',
                                    'centros' => '/center',
                                    'centro_especifico' => '/center/',
                                    'centro_especifico_' => '/Center/',
                                    'centros_zona_especifica' => '/center/zone/',
                                    'estudiantes_periodo_especifico' => '/EnrolledStudents/Period/',
                                    'aspirantes_pendientes_periodo_especifico' => '/Invoice/Pending/Period/',
                                    'curso' => '/Course/',
                                    'nota' => '/',
                                    'periodo_individual' => '/EnrolledStudents/Individual/Period/',
                                    'documento' => '/'
                                );
    }


    function getServicio($servicio) {
        // echo $this->base_url . $servicio;
        curl_setopt($this->curl, CURLOPT_URL, $this->base_url . $servicio);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: ' . $this->token->token));

        curl_setopt($this->curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        curl_setopt($this->curl, CURLOPT_ENCODING,  'gzip');

        $rta = json_decode($this->exec(), true);

        if ($rta['error'] == true) {
            /*print_r(utf8_decode($rta['message'] . ' En el servicio ' . $servicio));
            exit;*/
            return array();
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

    function getPeticion() {
        $argumentos = func_get_args();
        $servicio = '';
        foreach ($argumentos as $valores) {
            $valores = explode(',', $valores);
            $servicio .= isset($valores[1])?$this->peticiones[$valores[0]].base64_encode((int)$valores[1]):$this->peticiones[$valores[0]];
        }
        
        return $this->getServicio($servicio);
    }

}