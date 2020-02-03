<?php 
session_start();
$referrer = $_SERVER['HTTP_REFERER']; 
include_once("ws.php");
define("ERROR", "<h1>Atencion: Debe diligenciar todos los campos!</h1>");
$ws = new ws();

if(isset($_POST['servicio']) && count($_POST) == 1) {
	echo json_encode($ws->getPeticion($_POST['servicio'])); 
} elseif (count($_POST) > 1) {
	if(isset($_POST['consultas'])) {            
		switch ($_POST['consultas']) {
			case 'estudiantes_periodo_especifico_zona_especifica':
				if(isset($_POST['periodos']) && isset($_POST['zonas']))
					echo formatoResultados($ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "zona_especifica,$_POST[zonas]"));
				else 
					echo ERROR;
			break;
			case 'estudiantes_periodo_especifico_curso_especifico':
				if(isset($_POST['periodos']) && isset($_POST['curso'])) {
					if(isset($_POST['nota']))
						echo formatoResultados($ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "curso,$_POST[curso]", "nota,$_POST[nota]"));
					else
						echo formatoResultados($ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "curso,$_POST[curso]"));
				}
				else 
					echo ERROR;
			break;
			case 'estudiantes_periodo_especifico_escuela_especifica_programa_especifico':
				if(isset($_POST['periodos']) && isset($_POST['escuelas'])/* && isset($_POST['programas_escuela_especifica'])*/) {
					$estudiantes = array();
					if ($_POST['escuelas'] == 'T') {
						$escuelas = explode(',',$_POST['escuelas_hidden']);
						foreach ($escuelas as $escuela) {
							$programas = array_column($ws->getPeticion("programas_escuela_especifica,$escuela"), 'id');
							$programas = array_map('base64_decode', $programas);
							foreach ($programas as $programa) {
								$estudiantes = array_merge($estudiantes, $ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "escuela_especifica_,$escuela", "programa_especifico_,$programa"));
								/*echo "$_POST[periodos] - $escuela - $programa";
								print_r($ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "escuela_especifica_,$escuela", "programa_especifico_,$programa"));*/
							}
						}
						// echo formatoResultados($estudiantes);
					} elseif (isset($_POST['programas_escuela_especifica'])) {
						$estudiantes = $ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "escuela_especifica_,$_POST[escuelas]", "programa_especifico_,$_POST[programas_escuela_especifica]");						
					} else {
						$programas = array_column($ws->getPeticion("programas_escuela_especifica,$_POST[escuelas]"), 'id');
						$programas = array_map('base64_decode', $programas);
						foreach ($programas as $programa) {
							$estudiantes = array_merge($estudiantes, $ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "escuela_especifica_,$_POST[escuelas]", "programa_especifico_,$programa"));
							/*echo "$_POST[periodos] - $escuela - $programa";
							print_r($ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "escuela_especifica_,$escuela", "programa_especifico_,$programa"));*/
						}
					}
					// var_dump($estudiantes);
					echo empty($estudiantes)?'<p>No existen matriculados para ese programa</p>':formatoResultados($estudiantes);
				}
				else 
					echo ERROR;
			break;
			case 'estudiantes_periodo_especifico_zona_especifica_centro_especifico':
				if(isset($_POST['periodos']) && isset($_POST['zonas'])/* && isset($_POST['programas_escuela_especifica'])*/) {
					$estudiantes = array();
					if ($_POST['zonas'] == 'T') {
						$zonas = explode(',',$_POST['zonas_hidden']);
						foreach ($zonas as $zona) {
							$centros = array_column($ws->getPeticion("centros_zona_especifica,$zona"), 'id');
							$centros = array_map('base64_decode', $centros);
							foreach ($centros as $centro) {
								$estudiantes = array_merge($estudiantes, $ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "zona_especifica,$zona", "centro_especifico_,$centro"));
								/*echo "$_POST[periodos] - $escuela - $programa";
								print_r($ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "escuela_especifica_,$escuela", "programa_especifico_,$programa"));*/
							}
						}
						// echo formatoResultados($estudiantes);
					} elseif (isset($_POST['programas_escuela_especifica'])) {
						$estudiantes = $ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "zona_especifica,$_POST[zonas]", "centro_especifico_,$_POST[centros_zona_especifica]");						
					} else {
						$centros = array_column($ws->getPeticion("centros_zona_especifica,$_POST[zonas]"), 'id');
						$centros = array_map('base64_decode', $centros);
						foreach ($centros as $centro) {
							$estudiantes = array_merge($estudiantes, $ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "zona_especifica,$_POST[zonas]", "centro_especifico_,$centro"));
							/*echo "$_POST[periodos] - $escuela - $programa";
							print_r($ws->getPeticion("estudiantes_periodo_especifico,$_POST[periodos]", "escuela_especifica_,$escuela", "programa_especifico_,$programa"));*/
						}
					}
					// var_dump($estudiantes);
					echo empty($estudiantes)?'<p>No existen matriculados para ese centro</p>':formatoResultados($estudiantes);
				}
				else 
					echo ERROR;
			break;
			case 'estudiante_periodo_especifico_cedula':
				if(isset($_POST['periodos']) && isset($_POST['documento'])) {
					$informacion = $ws->getPeticion("periodo_individual,$_POST[periodos]", "documento,$_POST[documento]");
					echo empty($informacion)?'<p>No existe información para el documento consultado</p>':formatoResultados($informacion);
				}
				else 
					echo ERROR;			
			break;
                        case 'desde_archivo_JSON':
                            if(isset($_FILES['json']['name']) && !empty($_FILES['json']['name'])) {
                                $upload_file = './tmp/'.$_FILES['json']['name'];
                                if(move_uploaded_file($_FILES['json']['tmp_name'], $upload_file)) {
                                    echo 'Archivo cargado correctamente.<br>Espere mientras se genera la tabla...<br><br>';
                                    $str_data = file_get_contents('./tmp/'.$_FILES['json']['name']);
                                    $estudiantes = json_decode($str_data, true);
                                    echo empty($estudiantes['info'])?'<p>No existen matriculados es ese JSON</p>':formatoResultados($estudiantes['info']);
                                } else {
                                    echo 'Ha ocurrido un error en la carga!';
                                }
                            } else {
                                echo ERROR;
                            }
                        break;
		}
	} else
		echo ERROR;
} else
	echo ERROR;


function formatoResultados($answer) {	
	$str ="<table border='1'>";
	$str .= "<tr>";
	$keys = array_keys($answer[0]);
	foreach ($keys as $key)
		$str .= "<th>$key</th>";
	$str .= "</tr>";
	foreach ($answer as $registro) {
		$str .= "<tr>";
		foreach ($registro as $key => $value) {
			$str .= "<td>";
			if (is_array($value)) {
				foreach ($value as $keyVal => $valueVal) {
					if (!is_array($valueVal))
						$valueVal = array($keyVal => $valueVal);
					array_walk($valueVal, function(&$k, $v){$k = htmlentities(reemplazaCaracterEspecial(base64_decode($k))); htmlentities($v=reemplazaCaracterEspecial(base64_decode($v)));});
					$str .= implode(': ', $valueVal) ;
				} 
			} else
			$str .= htmlentities(reemplazaCaracterEspecial(base64_decode($value)));
			$str .= "</td>";
		}
		$str .= "<tr>";                
	}
	$str .= "</table>";
	return $str;
}

function reemplazaCaracterEspecial($str) {
    $str = trim(preg_replace(['/Ã/','/Ã/','/Ã/','/Ã/','/Ã/','/Ã³/','/I/','/A/','/I/','/I/','/AÂ/','/Ã/','/IÂ/'], 
                             ['Á','É','Í','Ó','Ñ','ó','Í','Á','Á','Í','Á','Ú','Í'], $str));
    return $str != '1'?$str:'';
}

 ?>