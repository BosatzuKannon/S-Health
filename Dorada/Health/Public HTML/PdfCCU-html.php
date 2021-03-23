<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_ccu where caso =  '$caso'";
	$campos = pg_query($strConsulta);
	$psic = pg_fetch_array($campos);
	
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

	
	if (file_exists('datosxml/CCUXml.xml')) {
    $xml = simplexml_load_file('datosxml/CCUXml.xml');

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
		<label>Atencion: C. Cuello Uterino</label><br>	
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
		<label> Motivo de consulta: '.$psic['txt_mot_consulta'].'</label><br>	
		<label> Engermedad actual: '.$psic['txt_enf_actual'].'</label>	
	</fieldset>
	<br>
	<fieldset>
		<legend>III. Historia clinica</legend>
		<label>'.$xml->TXT_AGO->es.': '.$psic['txt_ago'].'</label><br>
		<label>'.$xml->TXT_G->es.': '.$psic['txt_g'].'</label><br>
		<label>'.$xml->TXT_P->es.': '.$psic['txt_p'].'</label><br>
		<label>'.$xml->TXT_A->es.': '.$psic['txt_a'].'</label><br>
		<label>'.$xml->TXT_C->es.': '.$psic['txt_c'].'</label><br>
		<label>'.$xml->DRP_PLANIFICA->es.': '.$xml->DRP_PLANIFICA->es->option[intval($psic['drp_planifica'])].'</label><br>
		<label>'.$xml->TXT_OTRO_PLANIFICA->es.': '.$psic['txt_otro_planifica'].'</label><br>
		<label>'.$xml->TXT_FUM->es.': '.$psic['txt_fum'].'</label><br>
		<label>'.$xml->DRP_CITOLOGIA->es.': '.$xml->DRP_CITOLOGIA->es->option[intval($psic['drp_citologia'])].'</label><br>
		<label>'.$xml->DATE_FCITOLOGIA->es.': '.$psic['date_fcitologia'].'</label><br>
		<label>'.$xml->AREA_RESULTADO_CIT->es.': '.$psic['area_resultado_cit'].'</label><br>
		<label>'.$xml->AREA_ESPECIFIQUE->es.': '.$psic['area_especifique'].'</label><br>
		<label>'.$xml->CHKG_PROCEDIMIENTOS_GINECOLOGICOS_PREVIOS->es.': '.$psic['chkg_procedimientos_ginecologicos_previos'].'</label><br>
		<label>'.$xml->TXT_OTROS_CUAL->es.': '.$psic['txt_otros_cual'].'</label><br>
		<label>'.$xml->DRP_ASPECTO_CUELLO->es.': '.$xml->DRP_ASPECTO_CUELLO->es->option[intval($psic['drp_aspecto_cuello'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>IV. Protocolo Bethesda</legend>
		<label>'.$xml->DATE_ING_MUESTRA_LAB->es.': '.$psic['date_ing_muestra_lab'].'</label>
	</fieldset>
	<fieldset>
		<legend>V. Calidad de la muestra</legend>
		<label>'.$xml->CHK_SATISFACCION_MUESTRA->es.': '.$psic['chk_satisfaccion_muestra'].'</label><br>
		<label>'.$xml->DRP_ZONA_TRANS->es.': '.$xml->DRP_ZONA_TRANS->es->option[intval($psic['drp_zona_trans'])].'</label><br>
		<label>'.$xml->CHK_INSATISFACCION_MUESTRA->es.': '.$psic['chk_insatisfaccion_muestra'].'</label><br>
		<label>'.$xml->AREA_MUESTRA_INSATISFACTORIA->es.': '.$psic['area_muestra_insatisfactoria'].'</label><br>
		<label>'.$xml->AREA_MUESTRA_RECHAZADA->es.': '.$psic['area_muestra_rechazada'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VI. Clasificacion general</legend>
		<label>'.$xml->DRP_CLASIFICACION_GENERAL->es.': '.$xml->DRP_CLASIFICACION_GENERAL->es->option[intval($psic['drp_clasificacion_general'])].'</label>
	</fieldset>
	<fieldset>
		<legend>VII. Interpretcion/resultados</legend>
		<label>'.$xml->CHKG_ORGANISMOS->es.': '.$psic['chkg_organismos'].'</label><br>
		<label>'.$xml->TXT_OTROS_RESULTADOS->es.': '.$psic['txt_otros_resultados'].'</label><br>
		<label>'.$xml->DRP_CAMBIOS_CELULARES->es.': '.$xml->DRP_CAMBIOS_CELULARES->es->option[intval($psic['drp_cambios_celulares'])].'</label><br>
		<label>'.$xml->CHK_DIU->es.': '.$psic['chk_diu'].'</label><br>
		<label>'.$xml->CHK_CELULAS_GLAN->es.': '.$psic['chk_celulas_glan'].'</label><br>
		<label>'.$xml->CHK_ATROFIA->es.': '.$psic['chk_atrofia'].'</label><br>
		<label>'.$xml->TXT_OTRAS->es.': '.$psic['txt_otras'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VIII. Anormalidades en celulas epitaliales</legend>
		<label>'.$xml->CHK_PRESENCIA_CELULAS->es.': '.$psic['chk_presencia_celulas'].'</label><br>
		<label>'.$xml->TXT_CEL_ESCAMOSAS->es.': '.$psic['txt_cel_escamosas'].'</label><br>
		<label>'.$xml->CHKG_CELULAS_ESCAMOSAS->es.': '.$psic['chkg_celulas_escamosas'].'</label><br>
		<label>'.$xml->CHK_LESION_ESCAMOSA->es.': '.$psic['chk_lesion_escamosa'].'</label><br>
		<label>'.$xml->DRP_CARACTERISTICAS_INVASION->es.': '.$xml->DRP_CARACTERISTICAS_INVASION->es->option[intval($psic['drp_caracteristicas_invasion'])].'</label><br>
		<label>'.$xml->CHK_CARCINOMA->es.': '.$psic['chk_carcinoma'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>IX. Celulas glandulares</legend>
		<label>'.$xml->DRP_CELULAS_GLANDULARES->es.': '.$xml->DRP_CELULAS_GLANDULARES->es->option[intval($psic['drp_celulas_glandulares'])].'</label><br>
		<label>'.$xml->DRP_CELULAS_GLANDULARES_ATIPICAS->es.': '.$xml->DRP_CELULAS_GLANDULARES_ATIPICAS->es->option[intval($psic['drp_celulas_glandulares_atipicas'])].'</label><br>
		<label>'.$xml->CHK_ADENOCARCINOMA_ENDOCERVICAL->es.': '.$psic['chk_adenocarcinoma_endocervical'].'</label><br>
		<label>'.$xml->DRP_ADENOCARCINOMA->es.': '.$xml->DRP_ADENOCARCINOMA->es->option[intval($psic['drp_adenocarcinoma'])].'</label><br>
		<label>'.$xml->AREA_NEOPLASIA_MALIGNA->es.': '.$psic['area_neoplasia_maligna'].'</label><br>
		<label>'.$xml->AREA_OBSERVACIONES->es.': '.$psic['area_observaciones'].'</label><br>
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
	    echo "Error abriendo test.xml";
	}
	
	

?>