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
// $servicio = $ws->getPeticion('periodos'); 
// $servicio = $ws->getPeticion('estudiantes_periodo_especifico,475', 'zona_especifica,9'); 

?>

<head>
	<title>Consulta WebService</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap.min.css">
	<script src="jquery.min.js"></script>
	<script src="bootstrap.min.js"></script>
	<script src="spin.min.js"></script>
	<script type="text/javascript" src="ws.js"></script>
</head>
<body>
	<header>
		<form id='consulta' name='consulta' method="POST" action="consulta.php" enctype="multipart/form-data">
			<div class="container">
				<select id="consultas" name='consultas' onchange="camposConsulta()">
					<option selected="selected" disabled>Seleccione una opción</option>
					<option value="estudiantes_periodo_especifico_zona_especifica">estudiantes_periodo_especifico_zona_especifica</option>
					<option value="estudiantes_periodo_especifico_curso_especifico">estudiantes_periodo_especifico_curso_especifico</option>
					<option value="estudiantes_periodo_especifico_escuela_especifica_programa_especifico">estudiantes_periodo_especifico_escuela_especifica_programa_especifico</option>
					<option value="estudiantes_periodo_especifico_zona_especifica_centro_especifico">estudiantes_periodo_especifico_zona_especifica_centro_especifico</option>
					<option value="estudiante_periodo_especifico_cedula">estudiante_periodo_especifico_cedula</option>
                                        <option value="desde_archivo_JSON">desde_archivo_JSON</option>
				</select>
				<div id="modificadores">
				</div>
				<input type="button" id="buttonConsultar" value="Consultar" onclick="listaEstudiantes()">
			</div>
		</form>
	</header>
	<hr>
	<section>
		<div id ="center" style="position:fixed;top:50%;left:50%"></div>
		<div>
			<div id="resultado"></div>
		</div>
	</section>
</body>