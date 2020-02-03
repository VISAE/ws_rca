

function variablesAjax(...campos) {
	campos.forEach(function(campo) {
		$.ajax({
			method: "POST",
			url: "consulta.php",
			data: {servicio: campo},
			dataType: 'JSON',
			success: function(data) {				
				// data  = JSON.parse(data);
				campo = campo.split(',')[0];	// para validar campos como los de escuela
				var elements = "<select id='"+ campo +"' name='"+ campo +"'>" +
								"<option selected='selected' disabled>Seleccione "+ campo +"</option>"
				data.forEach(function(e) {
					elements += "<option value='"+ decodeURIComponent(escape(window.atob(e['id']))) +"'>"+ 	decodeURIComponent(escape(window.atob(e['id']))) + ' - ' +
																											decodeURIComponent(escape(window.atob(e['descripcion']))) +"</option>";
				});				
				elements += "</select>";
				elements += "<input type='hidden' name='"+campo+"_hidden' id='"+campo+"_hidden' value='"+data.map(e => window.atob(e.id)).join(',')+"' />";
				$('#modificadores').append(elements);
				if (['escuelas', 'zonas'].indexOf(campo) >= 0) 
					$('#'+campo).append("<option value='T'>Todos</option>");
			}
		});
	});
}

function listaEstudiantes() {
	var form = document.consulta;
	var dataStr = $(form).serialize();
        if($('#json').length) {
            $.each($('#json')[0].files, function(i, file) {
                dataStr += '&json='+file;
            });console.log(dataStr);
        }
	var opts = {
            lines: 20, // The number of lines to draw
            length: 19, // The length of each line
            width: 4, // The line thickness
            radius: 30, // The radius of the inner circle
            corners: 1, // Corner roundness (0..1)
            rotate: 0, // The rotation offset
            color: '#000', // #rgb or #rrggbb
            speed: 1, // Rounds per second
            trail: 60, // Afterglow percentage
            shadow: false, // Whether to render a shadow
            hwaccel: false, // Whether to use hardware acceleration
            className: 'spinner', // The CSS class to assign to the spinner
            zIndex: 2e9, // The z-index (defaults to 2000000000)
            top: 25, // Top position relative to parent in px
            left: 25, // Left position relative to parent in px            
        };
	var spinner = new Spinner(opts);	
	$.ajax({
		method: "POST",
		url: "consulta.php",
		data: dataStr,
                cache: false,
                /*contentType: false,
                processData: false,*/
		beforeSend: function() {
			$('#buttonConsultar').prop('disabled', true);
			$("#resultado").hide('slow');
			$("#resultado").empty();
        	// var target = document.getElementById('areaResultados');
        	spinner.spin($('#center')[0]);
		},
		success: function(data) {
			$("#resultado").append(data);
			spinner.stop();
			$("#resultado").show('slow');
		}
	}).done(function() {
		$('#buttonConsultar').prop('disabled', false);
	});
	return false;
}

function camposConsulta() {
	$('#modificadores').empty();
	switch($('#consultas').val()) {		
		case('estudiantes_periodo_especifico_zona_especifica'):
			variablesAjax('periodos', 'zonas');
		break;		
		case('estudiantes_periodo_especifico_curso_especifico'):
			variablesAjax('periodos');
			var additonal = "<select id='curso' name='curso'>"+
								"<option selected='selected' disabled>Seleccione Curso</option>"+
								"<option value='80017'>Cátedra Unadista: 80017</option>"+
							 	"<option value='80022'>Cátedra Unadista: 80022</option>"+
							 	"<option value='434206'>Cátedra Unadista: 434206</option>"+
							 	"<option value='203033'>Cátedra Unadista: 203033</option>"+
							"</select>&nbsp;"+
							"<input type='checkbox' name='nota' id='nota' value='1'>¿Con nota?<br>";
			$('#modificadores').append(additonal);
			$('#nota').on('click', function() {
				$('#nota').val($('#nota').is(':checked')?'1':'0');
			});
		break;
		case('estudiantes_periodo_especifico_escuela_especifica_programa_especifico'):
			variablesAjax('periodos', 'escuelas');
			$(document).ajaxComplete(function() {
				if ($('#escuelas').length)
					$('#escuelas').off().on('change',function(){
						$('#programas_escuela_especifica').remove();
						$('#programas_escuela_especifica_hidden').remove();
						if ($(this).val() != 'T') {
							variablesAjax('programas_escuela_especifica,'+$(this).val());						
						}
					});
			});
		break;
		case('estudiantes_periodo_especifico_zona_especifica_centro_especifico'):
			variablesAjax('periodos', 'zonas');
			$(document).ajaxComplete(function() {
				if ($('#zonas').length)
					$('#zonas').off().on('change',function(){
						$('#centros_zona_especifica').remove();
						$('#centros_zona_especifica_hidden').remove();
						if ($(this).val() != 'T') {
							variablesAjax('centros_zona_especifica,'+$(this).val());						
						}
					});
			});
		break;
		case('estudiante_periodo_especifico_cedula'):
			variablesAjax('periodos');
			var additonal = "<input type='number' id='documento' name='documento' placeholder='Ingrese # de documento' required >";
			$('#modificadores').append(additonal);
		break;
                case('desde_archivo_JSON'):
                    var additonal = "<br><input type='file' id='json' name='json' accept='application/json'>"+
                                    "<input type='hidden' name='dummy' >"+
                                    "<input type='submit' value='Enviar fichero'><br><br>";
                    $('#modificadores').append(additonal);
                break;
	}
}



