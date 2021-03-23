<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_consulta_urgencia where caso =  '$caso'";
	$campos = pg_query($strConsulta);
	$psic = pg_fetch_array($campos);

	//--------------------------------------------------------------------------
	$strConsulta = "SELECT * from hlt_antecedentes where caso =  '$caso'";
	$campos = pg_query($strConsulta);
	$ant = pg_fetch_array($campos);

	$strConsulta = "SELECT * from hlt_factores_riesgo where caso =  '$caso'";
	$campos = pg_query($strConsulta);
	$frie = pg_fetch_array($campos);
	
	//--------------------------------------------------------------------------
	
	$strConsulta2 = "SELECT * from hlt_citas where caso =  '$caso'";
	$campos2 = pg_query($strConsulta2);
	$cita = pg_fetch_array($campos2);

	$ced=$cita['no_historia'];
	
	$strConsulta3 = "SELECT * from hlt_pacientes where no_historia =  '$ced'";
	$campos3 = pg_query($strConsulta3);
	$personal = pg_fetch_array($campos3);

	$tipod=$personal['cod_documento'];
	$strConsulta4 = "SELECT * from hlt_documento where cod_documento =  '$tipod'";
	$campos4 = pg_query($strConsulta4);
	$codtipo = pg_fetch_array($campos4);

	$estc=$personal['cod_estado_civil'];
	$strConsulta5 = "SELECT * from hlt_estado_civil where cod_estado_civil =  '$estc'";
	$campos5 = pg_query($strConsulta5);
	$codest = pg_fetch_array($campos5);
	
	$mun=$personal['cod_div_mun'];
	$strConsulta6 = "SELECT * from hlt_divipola where consecutivo_divipola =  '$mun'";
	$campos6 = pg_query($strConsulta6);
	$codmun = pg_fetch_array($campos6);
	
	$par=$personal['cod_parentezco'];
	$strConsulta6 = "SELECT * from hlt_parentezco where cod_parentezco =  '$par'";
	$campos6 = pg_query($strConsulta6);
	$codpar = pg_fetch_array($campos6);

	$pro=$personal['cod_ciuo'];
	$strConsulta6 = "SELECT * from hlt_ciuo where cod_ciuo =  '$pro'";
	$campos6 = pg_query($strConsulta6);
	$codpro = pg_fetch_array($campos6);

	$emp=$personal['cod_empresa'];
	$strConsulta6 = "SELECT * from hlt_empresa where cod_empresa =  '$emp'";
	$campos6 = pg_query($strConsulta6);
	$codemp = pg_fetch_array($campos6);

	$estra=$personal['cod_estrato'];
	$strConsulta6 = "SELECT * from hlt_estrato where cod_estrato =  '$estra'";
	$campos6 = pg_query($strConsulta6);
	$codestra = pg_fetch_array($campos6);

	$etn=$personal['cod_etnia'];
	$strConsulta6 = "SELECT * from hlt_etnia where cod_etnia =  '$etn'";
	$campos6 = pg_query($strConsulta6);
	$codetn = pg_fetch_array($campos6);
	
	$dis=$personal['cod_discapacidad'];
	$strConsulta6 = "SELECT * from hlt_discapacidad where cod_discapacidad =  '$dis'";
	$campos6 = pg_query($strConsulta6);
	$coddis = pg_fetch_array($campos6);

	$esc=$personal['cod_escolaridad'];
	$strConsulta6 = "SELECT * from hlt_escolaridad where cod_escolaridad =  '$esc'";
	$campos6 = pg_query($strConsulta6);
	$codesc = pg_fetch_array($campos6);

	$ins=$personal['cod_ins_educativa'];
	$strConsulta6 = "SELECT * from hlt_institucion_educativa where cod_institucion =  '$ins'";
	$campos6 = pg_query($strConsulta6);
	$codins = pg_fetch_array($campos6);
	
	//echo '<script language="javascript">alert("Aqui voy");</script>'; 

	$fenac=$personal['fecha_nac'];
	$fecha = time() - strtotime($fenac);
	$edad = floor((($fecha / 3600) / 24) / 360);

	
	if (file_exists('datosxml/UrgenciasXml.xml')) {
    $xml = simplexml_load_file('datosxml/UrgenciasXml.xml');

    $codigoHTML='
	<html>	
	<style type="text/css">
		label {
	    	display: inline;
	    	padding-right: 30px;
	    }
	    #cab{
		    width: 720px; 
		    height: 100px; 
		    border: 2px solid #555;
		    background: #FFF;
		}
	</style>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Historia</title>
	</head>
	<body>
	<fieldset>
		<legend>I. Datos Personales </legend>
		<label>No. Historia: '.$ced.'</label>
		<label>Fecha Cita: '.$cita['fecha_cita'].'</label>	
		<label>Atencion: Urgencias</label><br>	
		<label>Nombres: '.$personal['nom_1'].' '.$personal['nom_2'].'</label>
		<label>Apellidos: '.$personal['apel_1'].' '.$personal['apel_2'].'</label><br>
		<label>Documento de identidad: '.$codtipo['descripcion'].'</label>
		<label>Numero Documento: '.$ced.'</label><br>
		<label>Empresa: '.$codemp['nombre'].'</label><br>
		<label>Edad: '.$edad.'</label>
		<label>Sexo: '.$personal['cod_sexo'].'</label>
		<label>Estado Civil: '.$codest['descripcion'].'</label><br>
	    <label>Lugar de Nacimiento: '.$codmun['nom_departamento'].'-'.$codmun['nom_municipio'].'-'.$codmun['nom_poblacion'].'</label><br>
		<label>Fecha de Nacimiento: '.$personal['fecha_nac'].'</label><br>
		<label>Direccion: '.$personal['direccion'].'-'.$personal['barrio'].'</label>
		<label>Telefono: '.$personal['telefono'].'</label><br>
		<label>Celular: '.$personal['celular'].'</label>
		<label>Email: '.$personal['email'].'</label><br>
		<label>Etnia: '.$codetn['descripcion'].'</label>
		<label>Profesion: '.$codpro['descripcion'].'</label><br>
		<label>'.$codestra['descripcion'].'</label>
		<label>Discapacidad: '.$coddis['descripcion'].'</label>
		<label>Escolaridad: '.$codesc['descripcion'].'</label><br>
		<label>institucion Educativa: '.$codins['descripcion'].'</label><br>
		<label>Nombre contacto: '.$personal['contacto'].'</label><br>
		<label>Parentezco: '.$codpar['descripcion'].'</label>
		<label>Direccion de contacto: '.$personal['dir_contacto'].'</label><br>
		<label>Telefono de contacto: '.$personal['tel_contacto'].'</label>
	</fieldset>
	<br>
	<fieldset>
		<legend>II. Consulta Principal</legend>
		<label> Motivo de consulta: '.$psic['motivo_consulta'].'</label><br>	
		<label> Engermedad actual: '.$psic['enfermedad_actual'].'</label>	
	</fieldset>
	<br>
	<fieldset>
		<legend>II. Antecedentes personales</legend>
		<label>Patologicos: '.$ant['ant_patologicos'])].'</label>
		<label>Obs: '.$ant['obs_patologicos'].'</label><br>

		<label>Quirurgicos: '.$ant['ant_quirurgios'])].'</label>
		<label>Obs: '.$ant['obs_quirurgicos'].'</label><br>
		
		<label>Alergicos: '.$ant['ant_alergicos'])].'</label>
		<label>Obs: '.$ant['obs_alergicos'].'</label><br>
		
		<label>Hospitalarios: '.$ant['ant_hospitalarios'])].'</label>
		<label>Obs: '.$ant['obs_hospitalarios'].'</label><br>
		
		<label>Farmaceuticos: '.$ant['ant_farmaceuticos'])].'</label>
		<label>Obs: '.$ant['obs_farmaceuticos'].'</label><br>
		
		<label>Perinatales: '.$ant['ant_perinatales'])].'</label>
		<label>Obs: '.$ant['obs_perinatales'].'</label><br>
		
		<label>Traumaticos: '.$ant['ant_traumaticos'])].'</label>
		<label>Obs: '.$ant['obs_traumaticos'].'</label><br>
				
		<label>Familiares: '.$ant['ant_familiares'].'</label><br>
		<label>ggo: '.$ant['ant_ggo'].'</label> <br>
		<label>Fumador: '.$ant['ant_fum'].'</label><br>
		<label>Ciclos: '.$ant['ant_ciclos'].'</label><br>
		<label>Planificacion: '.$ant['ant_planificacion'].'</label><br>
		<label>Obs: '.$ant['obs_planificacion'].'</label> <br>
		<label>Examen de mama: '.$ant['ant_examen_mama'].'</label><br>
		<label>Ultima citologia: '.$ant['ant_ultima_citlogia'].'</label><br>
		<label>Climaterio: '.$ant['ant_climaterio'].'</label><br>
		<label>gg: '.$ant['ant_gg'].'</label><br>
		<label>pp: '.$ant['ant_pp'].'</label><br>
		<label>aa: '.$ant['ant_aa'].'</label><br>
		<label>cc: '.$ant['ant_cc'].'</label><br>
		<label>mm: '.$ant['ant_mm'].'</label><br>
		<label>vv: '.$ant['ant_vv'].'</label><br>
		<label>Obervaciones: '.$ant['ant_observaciones'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Factores de riesgo</legend>
		<label>Tabaco: '.$frie['ries_tabaco'].'</label>
		<label>Obs: '.$frie['obs_tabaco'].'</label><br>

		<label>Alcohol: '.$frie['ries_alcochol'].'</label>
		<label>Obs: '.$frie['obs_alcochol'].'</label><br>

		<label>Drogas: '.$frie['ries_drogas'].'</label>
		<label>Obs: '.$frie['obs_drogas'].'</label><br>

		<label>Desnutricion: '.$frie['ries_desnutricion'].'</label>
		<label>Obs: '.$frie['obs_desnutricion'].'</label><br>

		<label>Sobrepeso: '.$frie['ries_sobrepeso'].'</label>
		<label>Obs: '.$frie['obs_sobrepeso'].'</label><br>

		<label>Obesidad: '.$frie['ries_obesidad'].'</label>
		<label>Obs: '.$frie['obs_obesidad'].'</label><br>

		<label>Respiratorio: '.$frie['ries_respiratorio'].'</label>
		<label>Obs: '.$frie['obs_respiratrio'].'</label><br>

		<label>Piel: '.$frie['ries_piel'].'</label>
		<label>Obs: '.$frie['obs_piel'].'</label><br>

		<label>Observaciones: '.$frie['ries_observaciones'].'</label>
	</fieldset>
	<fieldset>
		<legend>III. Examen fisico</legend>
		<label>PA: '.$psic['exa_pa'].'</label>
		<label>FC: '.$psic['exa_fc'].'</label>
		<label>P: '.$psic['exa_p'].'</label><br>
		<label>FR: '.$psic['exa_fr'].'</label>
		<label>T: '.$psic['exa_temp'].' °C</label>
		<label>SAT: '.$psic['exa_sat'].'</label><br>
		<label>EG: '.$psic['exa_eg'].'</label>
		<label>Peso: '.$psic['exa_peso'].'</label>
		<label>Talla: '.$psic['exa_talla'].'</label><br>
		<label>Cabeza: '.$psic['exa_cabeza'].'</label><br>
		<label>Cuello: '.$psic['exa_cuello'].'</label><br>
		<label>Abdomen: '.$psic['exa_abdomen'].'</label><br>
		<label>Cardiopulmonar: '.$psic['exa_cardiopulmonar'].'</label><br>
		<label>Genital: '.$psic['exa_genital'].'</label><br>
		<label>Extremidades: '.$psic['exa_extremidad'].'</label><br>
		<label>Neuorologico: '.$psic['exa_neurologico'].'</label><br>
		<label>Piel y faneras: '.$psic['exa_piel'].'</label><br>
		<label>Tratamiento: '.$psic['tratamiento'].'</label><br>
		<label>Finalidad: '.$psic['finalidad'].'</label><br>
		<label>Complicacion: '.$psic['complicacion'].'</label><br>
		<label>Tipo diagnostico: '.$psic['tipo_diagnostico'].'</label><br>
		<label>Fecha salidad: '.$psic['fecha_salida'].'</label><br>
		<label>Causa: '.$psic['causa_externa'].'</label><br>
		<label>Destino de salida: '.$xml->DRP_DESTINO_SALIDA->es->option[intval($psic['destino_salida'])].'</label><br>
		<label>Estado salidad: '.$xml->DRP_EST_SALIDA->es->option[intval($psic['estado_salida'])].'</label><br>
		<label>Causa muerte: '.$psic['causa_muerte'].'</label><br>
		<label>Sintomas: '.$psic['sintomas'].'</label><br>
		<label>Clasificacion: '.$psic['clasificacion'].'</label><br>
	</fieldset>		
	<br>
	</body>
	</html>';

	$codigoHTML=utf8_decode($codigoHTML);
    //echo '<script language="javascript">alert("'.$codigoHTML.'");</script>';    
    
	$dompdf=new DOMPDF();
	$dompdf->load_html($codigoHTML);
	//ini_set("memory_limit","128M");
	$dompdf->render();	
	//$dompdf->stream("Reporte_tabla_usuarios.pdf");
	//$dompdf->output(); //Y con ésto se manda a imprimir el contenido del pdf
	header('Content-type: application/pdf'); //Ésta es simplemente la cabecera para que el navegador interprete todo como un PDF
	echo $dompdf->output(); //Y con ésto se manda a imprimir el contenido del pdf
 
    //print_r($xml);
	} else {
	    exit('Error abriendo test.xml.');
	    echo "ERRRRRRRRRRRRRRRRRRRROR";
	}
	
	

?>