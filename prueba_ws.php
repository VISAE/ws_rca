<?php
include_once("ws.php");

$ws = new ws();

/*
'vigencias'
'periodos'
'periodo_especifico'
'periodos_vigencia_especifica'
'escuelas'
'escuela_especifica'
'programas'
'programa_especifico'
'programas_escuela_especifica'
'programas_nivel_formacion'
'programas_escuela_nivel_formacion'		* requiere escuela y nivel
'niveles'								1:pregrado, 2: especialización, 7: Maestría
'nivel_especifico'
'zonas'
'zona_especifica'
'centros'
'centro_especifico'
'centros_zona_especifica'
'estudiantes_periodo_especifico'
'aspirantes_pendientes_periodo_especifico'
'curso'
*/


// $servicio = $ws->getPeticion('estudiantes_periodo_especifico,474', 'curso,203033'); 
// $servicio = $ws->getPeticion('zonas'); 
$servicio = $ws->getPeticion('estudiantes_periodo_especifico,474', 'zona_especifica,2'); 