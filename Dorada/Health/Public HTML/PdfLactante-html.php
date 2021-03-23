<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_atencion_lactante where caso =  '$caso'";
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

	
	if (file_exists('datosxml/LactanteXml.xml')) {
    $xml = simplexml_load_file('datosxml/LactanteXml.xml');

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
		<label>Atencion: Lactante</label><br>	
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
		<label> Engermedad actual: '.$psic['enfermedad_actual'].'</label><br>
		<label>'.$xml->TXT_NOMBRE_ACOMPANANTE->es.': '.$psic['txt_nombre_acompanante'].'</label><br>
		<label>'.$xml->DRP_PARENTESCO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_parentesco'])].'</label><br>
		<label>'.$xml->TXT_ANTECEDENTES->es.': '.$psic['txt_antecedentes'].'</label><br>
	</fieldset>
	<br>
	<fieldset>
		<legend>III. Informacion de parto </legend>
		<label>'.$xml->TXT_PESO_NACER->es.': '.$psic['txt_peso_nacer'].'</label><br>
		<label>'.$xml->TXT_TALLA_NACER->es.': '.$psic['txt_talla_nacer'].'</label><br>
		<label>'.$xml->TXT_EDAD_GESTACIONAL->es.': '.$psic['txt_edad_gestacional'].'</label><br>
		<label>'.$xml->TXT_HEMOCLASIFICACION->es.': '.$psic['txt_hemoclasificacion'].'</label><br>
		<label>'.$xml->TXT_PESO_ACTUAL->es.': '.$psic['txt_peso_actual'].'</label><br>
		<label>'.$xml->TXT_TALLA_MENOR->es.': '.$psic['txt_talla_menor'].'</label><br>
		<label>'.$xml->TXT_PC_NACIDO->es.': '.$psic['txt_pc_nacido'].'</label><br>
		<label>'.$xml->TXT_FC_NACIDO->es.': '.$psic['txt_fc_nacido'].'</label><br>
		<label>'.$xml->TXT_FR_NACIDO->es.': '.$psic['txt_fr_nacido'].'</label><br>
		<label>'.$xml->TXT_TEMP->es.': '.$psic['txt_temp'].'</label><br>
		<label>'.$xml->TXT_PROBLEMA_NEONATAL->es.': '.$psic['txt_problema_neonatal'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>IV. Verificar si tiene una enfermedad muy grave o infección local </legend>
		<label>'.$xml->DRP_BEBER_PECHO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_beber_pecho'])].'</label><br>
		<label>'.$xml->DRP_VOMITO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_vomito'])].'</label><br>
		<label>'.$xml->TXT_VOMITA_TODO->es.': '.$psic['txt_vomita_todo'].'</label><br>
		<label>'.$xml->DRP_DIFICULTAD_RESPIRAR->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_dificultad_respirar'])].'</label><br>
		<label>'.$xml->AREA_EXPLIQUE->es.': '.$psic['area_explique'].'</label><br>
		<label>'.$xml->DRP_TENIDO_FIEBRE->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_tenido_fiebre'])].'</label><br>
		<label>'.$xml->DRP_TENIDO_HIPOTERMIA->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_tenido_hipotermia'])].'</label><br>
		<label>'.$xml->DRP_TENIDO_CONVULSIONES->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_tenido_convulsiones'])].'</label><br>
		<label>'.$xml->TXT_PANALES_ORINADOS->es.': '.$psic['txt_panales_orinados'].'</label><br>
		<label>'.$xml->DRP_DIARREA_NINO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_diarrea_nino'])].'</label><br>
		<label>'.$xml->TXT_DIARREA_DIAS->es.': '.$psic['txt_diarrea_dias'].'</label><br>
		<label>'.$xml->DRP_SANGRE_HECES->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_sangre_heces'])].'</label><br>
		<label>'.$xml->DRP_PUSTULAS_PIEL->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_pustulas_piel'])].'</label><br>
		<label>'.$xml->DRP_ESTADO_GENERAL->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_estado_general'])].'</label><br>
		<label>'.$xml->DRP_PLIEGUE_CUTANEO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_pliegue_cutaneo'])].'</label><br>
		<label>'.$xml->DRP_VERIFICAR_GRAVEDAD->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_verificar_gravedad'])].'</label><br>
		<label>'.$xml->CHK_ESTIMULO->es.': '.$psic['chk_estimulo'].'</label><br>
		<label>'.$xml->CHK_LETARGIO->es.': '.$psic['chk_letargio'].'</label><br>
		<label>'.$xml->CHK_SE_VE_MAL->es.': '.$psic['chk_se_ve_mal'].'</label><br>
		<label>'.$xml->CHK_IRRITABLE->es.': '.$psic['chk_irritable'].'</label><br>
		<label>'.$xml->CHK_PALIDEZ->es.': '.$psic['chk_palidez'].'</label><br>
		<label>'.$xml->CHK_CIANOSIS->es.': '.$psic['chk_cianosis'].'</label><br>
		<label>'.$xml->CHK_ICTERIA_PRECOZ->es.': '.$psic['chk_icteria_precoz'].'</label><br>
		<label>'.$xml->CHK_FR_60_30->es.': '.$psic['chk_fr_60_30'].'</label><br>
		<label>'.$xml->CHK_FC_180_100->es.': '.$psic['chk_fc_180_100'].'</label><br>
		<label>'.$xml->CHK_APNEAS->es.': '.$psic['chk_apneas'].'</label><br>
		<label>'.$xml->CHK_ALETEO_NASAL->es.': '.$psic['chk_aleteo_nasal'].'</label><br>
		<label>'.$xml->CHK_QUEJIDO->es.': '.$psic['chk_quejido'].'</label><br>
		<label>'.$xml->CHK_ESTRIDOR->es.': '.$psic['chk_estridor'].'</label><br>
		<label>'.$xml->CHK_SIBILANCIA->es.': '.$psic['chk_sibilancia'].'</label><br>
		<label>'.$xml->CHK_TIRAJE_SUBCOSTAL->es.': '.$psic['chk_tiraje_subcostal'].'</label><br>
		<label>'.$xml->CHK_SUPURACION_OIDO->es.': '.$psic['chk_supuracion_oido'].'</label><br>
		<label>'.$xml->CHK_SECRECION_PURULENTA_CONJUNTIVA->es.': '.$psic['chk_secrecion_purulenta_conjuntiva'].'</label><br>
		<label>'.$xml->CHK_EDEMA_PALPEBRAL->es.': '.$psic['chk_edema_palpebral'].'</label><br>
		<label>'.$xml->CHK_SECRECION_PURULENTA->es.': '.$psic['chk_secrecion_purulenta'].'</label><br>
		<label>'.$xml->CHK_ERITEMA->es.': '.$psic['chk_eritema'].'</label><br>
		<label>'.$xml->CHK_PLACAS_BOCA->es.': '.$psic['chk_placas_boca'].'</label><br>
		<label>'.$xml->CHK_EQUIMOSIS->es.': '.$psic['chk_equimosis'].'</label><br>
		<label>'.$xml->CHK_PETEQUIAS->es.': '.$psic['chk_petequias'].'</label><br>
		<label>'.$xml->CHK_HEMORRAGIA->es.': '.$psic['chk_hemorragia'].'</label><br>
		<label>'.$xml->CHK_DISTENSION_ABDOMINAL->es.': '.$psic['chk_distension_abdominal'].'</label><br>
		<label>'.$xml->CHK_LLENADO_CAPILAR->es.': '.$psic['chk_llenado_capilar'].'</label><br>
		<label>'.$xml->CHK_FONTANELA_ABOMBADA->es.': '.$psic['chk_fontanela_abombada'].'</label><br>
		<label>'.$xml->CHK_OJOS_HUNDIDOS->es.': '.$psic['chk_ojos_hundidos'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>V. Verificar el crecimiento y las prácticas de alimentación: </legend>
		<label>'.$xml->DRP_DIFICULTAD_ALIMENTARSE->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_dificultad_alimentarse'])].'</label><br>
		<label>'.$xml->TXT_DIFICULTAD_ALIMENTARSE->es.': '.$psic['txt_dificultad_alimentarse'].'</label><br>
		<label>'.$xml->DRP_DEJAR_COMER->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_dejar_comer'])].'</label><br>
		<label>'.$xml->TXT_DESDE_CUANDO->es.': '.$psic['txt_desde_cuando'].'</label><br>
		<label>'.$xml->DRP_ALIMENTA_LECHE_MAT->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_alimenta_leche_mat'])].'</label><br>
		<label>'.$xml->DRP_LACTANCIA_ESCLUSIVA->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_lactancia_esclusiva'])].'</label><br>
		<label>'.$xml->TXT_CUANTAS_VECES_LACTA->es.': '.$psic['txt_cuantas_veces_lacta'].'</label><br>
		<label>'.$xml->DRP_OTRO_ALIMENTO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_otro_alimento'])].'</label><br>
		<label>'.$xml->TXT_FRECUENCIA_OTROS_ALIMENTOS->es.': '.$psic['txt_frecuencia_otros_alimentos'].'</label><br>
		<label>'.$xml->TXT_PREPARACION_LECHE_EXT->es.': '.$psic['txt_preparacion_leche_ext'].'</label><br>
		<label>'.$xml->TXT_QUE_UTILIZA->es.': '.$psic['txt_que_utiliza'].'</label><br>
		<label>'.$xml->DRP_USO_CHUPO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_uso_chupo'])].'</label><br>
		<label>'.$xml->TXT_PESO_EDAD->es.': '.$psic['txt_peso_edad'].'</label><br>
		<label>'.$xml->TXT_PESO_TALLA->es.': '.$psic['txt_peso_talla'].'</label><br>
		<label>'.$xml->TXT_PERDIDA_PESO->es.': '.$psic['txt_perdida_peso'].'</label><br>
		<label>'.$xml->DRP_TENDENCIA_PESO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_tendencia_peso'])].'</label><br>
		<label>'.$xml->AREA_EVALUAR_SUCCION->es.': '.$psic['area_evaluar_succion'].'</label><br>
		<label>'.$xml->DRP_DIAGNOSTICO_LACTANTE->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_diagnostico_lactante'])].'</label><br>
		<label>'.$xml->CHK_EVALUAR_AGARRE->es.': '.$psic['chk_evaluar_agarre'].'</label><br>
	    <label>'.$xml->CHK_EVALUAR_POSICION->es.': '.$psic['chk_evaluar_posicion'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VI. Escribir las recomendaciones y orientaciones dadas sobre: </legend>
		<label>'.$xml->DRP_INCESTO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_incesto'])].'</label><br>
		<label>'.$xml->DRP_FAMILIAR_ENFERMO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_familiar_enfermo'])].'</label><br>
		<label>'.$xml->DRP_CUIDADO_NINO->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_cuidado_nino'])].'</label><br>
		<label>'.$xml->TXT_DESARROLLO_NINO->es.': '.$psic['txt_desarrollo_nino'].'</label><br>
		<label>'.$xml->TXT_ANTECEDENTE_PARTO->es.': '.$psic['txt_antecedente_parto'].'</label><br>
		<label>'.$xml->TXT_PC->es.': '.$psic['txt_pc'].'</label><br>
		<label>'.$xml->TXT_PCE->es.': '.$psic['txt_pce'].'</label><br>
		<label>'.$xml->CHK_UN_MES->es.': '.$psic['chk_un_mes'].'</label><br>
	    <label>'.$xml->CHK_DOS_MESES->es.': '.$psic['chk_dos_meses'].'</label><br>
		<label>'.$xml->DRP_DIAGNOSTICO_MESES->es.': '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_diagnostico_meses'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VII. Escribir las recomendaciones y orientaciones dadas sobre: </legend>
		<label>'.$xml->AREA_VOLVER_SERVICIO->es.': '.$psic['area_volver_servicio'].'</label><br>
		<label>'.$xml->AREA_VOLVER_CONTROL_NACIDO->es.': '.$psic['area_volver_control_nacido'].'</label><br>
		<label>'.$xml->AREA_VOLVER_CONSULTA_SANO->es.': '.$psic['area_volver_consulta_sano'].'</label><br>
		<label>'.$xml->AREA_REFERIDO_CONSULTA->es.': '.$psic['area_referido_consulta'].'</label><br>
		<label>'.$xml->AREA_CRECIMIENTO_DESARROLLO->es.': '.$psic['area_crecimiento_desarrollo'].'</label><br>
		<label>'.$xml->AREA_RECOMENDACIONES_BUEN_TRATO->es.': '.$psic['area_recomendaciones_buen_trato'].'</label><br>
		<label>'.$xml->AREA_OTRAS_RECOMENDACIONES->es.': '.$psic['area_otras_recomendaciones'].'</label><br>
		
		<label>'.$xml->AREA_VOLVER_TRATAR->es.': '.$psic['area_volver_tratar'].'</label><br>
	</fieldset>

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