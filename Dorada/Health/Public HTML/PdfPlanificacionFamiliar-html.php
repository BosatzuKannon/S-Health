<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_atencion_planificacion_familiar where caso =  '$caso'";
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

	
	if (file_exists('datosxml/PlanificacionFamiliarXml.xml')) {
    $xml = simplexml_load_file('datosxml/PlanificacionFamiliarXml.xml');

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
		<label>Atencion: Planificacion familiar</label><br>	
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
		<legend>II. Consulta Principal - Formulario complementario de salud reproductiva</legend>
		<label> Motivo de consulta: '.$psic['motivo_consulta'].'</label><br>	
		<label> Engermedad actual: '.$psic['enfermedad_actual'].'</label><br>	
		<label>'.$xml->DRP_ACTIVIDAD->es.': '.$xml->DRP_ACTIVIDAD->es->option[intval($psic['drp_actividad'])].'</label><br>
		<label>'.$xml->TXT_TRABAJO->es.': '.$psic['txt_trabajo'].'</label><br>
		<label>'.$xml->DRP_ESTADO_CIVIL->es.': '.$xml->DRP_ESTADO_CIVIL->es->option[intval($psic['drp_estado_civil'])].'</label><br>
		<label>'.$xml->FECHA_ULTIMA_MENSTRUACION->es.': '.$psic['fecha_ultima_menstruacion'].'</label><br>
	</fieldset>
	<br>
	<fieldset>
		<legend>III. Hombre </legend>
		<label>'.$xml->TXT_PUBARQUIA->es.': '.$psic['txt_pubarquia'].'</label><br>
		<label>'.$xml->CHK_PUBARQUIA->es.': '.$psic['chk_pubarquia'].'</label><br>
		<label>'.$xml->TXT_VELLO_AXILAR->es.': '.$psic['txt_vello_axilar'].'</label><br>
		<label>'.$xml->CHK_VELLO_AXILAR->es.': '.$psic['chk_vello_axilar'].'</label><br>
		<label>'.$xml->TXT_POLUCION->es.': '.$psic['txt_polucion'].'</label><br>
		<label>'.$xml->CHK_POLUCION->es.': '.$psic['chk_polucion'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Mujer </legend>
		<label>'.$xml->TXT_TELARQUIA->es.': '.$psic['txt_telarquia'].'</label><br>
		<label>'.$xml->CHK_TELARQUIA->es.': '.$psic['chk_telarquia'].'</label><br>
		<label>'.$xml->TXT_PUBARQUIA_MU->es.': '.$psic['txt_pubarquia_mu'].'</label><br>
		<label>'.$xml->CHK_PUBARQUIA_MU->es.': '.$psic['chk_pubarquia_mu'].'</label><br>
		<label>'.$xml->TXT_VELLO_AXILAR_MU->es.': '.$psic['txt_vello_axilar_mu'].'</label><br>
		<label>'.$xml->CHK_VELLO_AXILAR_MU->es.': '.$psic['chk_vello_axilar_mu'].'</label><br>
		<label>'.$xml->TXT_POLUCION_MU->es.': '.$psic['txt_polucion_mu'].'</label><br>
		<label>'.$xml->CHK_POLUCION_MU->es.': '.$psic['chk_polucion_mu'].'</label><br>
		<label>'.$xml->TXT_RITMO_MESTRUAL->es.': '.$psic['txt_ritmo_mestrual'].'</label><br>
		<label>'.$xml->TXT_RITMO_MESTRUAL2->es.': '.$psic['txt_ritmo_mestrual2'].'</label><br>
		<label>'.$xml->DRP_CANTIDAD->es.': '.$xml->DRP_CANTIDAD->es->option[intval($psic['drp_cantidad'])].'</label><br>
		<label>'.$xml->YN_CUAGULOS->es.': '.$psic['yn_cuagulos'].'</label><br>
		<label>'.$xml->YN_DOLOR_MESTRUAL->es.': '.$psic['yn_dolor_mestrual'].'</label><br>
		<label>'.$xml->DRP_SI_TIENE_DOLOR->es.': '.$xml->DRP_SI_TIENE_DOLOR->es->option[intval($psic['drp_si_tiene_dolor'])].'</label><br>
		<label>'.$xml->YN_MASTODINIA->es.': '.$psic['yn_mastodinia'].'</label><br>
		<label>'.$xml->TXT_OBSERVACIONES->es.': '.$psic['txt_observaciones'].'</label><br>
		<label>'.$xml->TXT_OTRAS_MOLESTIAS->es.': '.$psic['txt_otras_molestias'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Sexualidad </legend>
		<label>'.$xml->AREA_FUENTE_INFORMACION->es.': '.$psic['area_fuente_informacion'].'</label><br>
	    <label>'.$xml->DRP_CALIDAD_INFORMACION->es.': '.$xml->DRP_CALIDAD_INFORMACION->es->option[intval($psic['drp_calidad_informacion'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Tiempo de Relacion </legend>
		<label>'.$xml->YN_PAREJA_ACTUAL->es.': '.$psic['yn_pareja_actual'].'</label><br>
		<label>'.$xml->TXT_RELACION_ANOS->es.': '.$psic['txt_relacion_anos'].'</label><br>
		<label>'.$xml->TXT_RELACION_MESES->es.': '.$psic['txt_relacion_meses'].'</label><br>
		<label>'.$xml->TXT_EDAD_PAREJA->es.': '.$psic['txt_edad_pareja'].'</label><br>
		<label>'.$xml->DRP_ACTIVIDAD_PAREJA->es.': '.$xml->DRP_ACTIVIDAD_PAREJA->es->option[intval($psic['drp_actividad_pareja'])].'</label><br>
		<label>'.$xml->TXT_TRABAJO_PAREJA->es.': '.$psic['txt_trabajo_pareja'].'</label><br>
		<label>'.$xml->DRP_ESTADO_CIVIL_PAREJA->es.': '.$xml->DRP_ESTADO_CIVIL_PAREJA->es->option[intval($psic['drp_estado_civil_pareja'])].'</label><br>
		<label>'.$xml->DRP_EDUCACION_PAREJA->es.': '.$xml->DRP_EDUCACION_PAREJA->es->option[intval($psic['drp_educacion_pareja'])].'</label><br>
		<label>'.$xml->TXT_EDAD_INICIO->es.': '.$psic['txt_edad_inicio'].'</label><br>
		<label>'.$xml->TXT_PAREJA_NO_SEXUAL->es.': '.$psic['txt_pareja_no_sexual'].'</label><br>
		<label>'.$xml->TXT_PAREJA_SEXUAL->es.': '.$psic['txt_pareja_sexual'].'</label><br>
		<label>'.$xml->DRP_EXP_SEXUAL->es.': '.$xml->DRP_EXP_SEXUAL->es->option[intval($psic['drp_exp_sexual'])].'</label><br>
		<label>'.$xml->DRP_ACTIVIDAD_SEXUAL->es.': '.$xml->DRP_ACTIVIDAD_SEXUAL->es->option[intval($psic['drp_actividad_sexual'])].'</label><br>
		<label>'.$xml->DRP_FRECUENCIA_COITAL->es.': '.$xml->DRP_FRECUENCIA_COITAL->es->option[intval($psic['drp_frecuencia_coital'])].'</label><br>
		<label>'.$xml->TXT_FRECUENCIA_COITAL->es.': '.$psic['txt_frecuencia_coital'].'</label><br>
		<label>'.$xml->DRP_NIVEL_ACTIVIDAD_SEXUAL->es.': '.$xml->DRP_NIVEL_ACTIVIDAD_SEXUAL->es->option[intval($psic['drp_nivel_actividad_sexual'])].'</label><br>
		<label>'.$xml->TXT_TOTAL_PAREJAS_SEXUALES->es.': '.$psic['txt_total_parejas_sexuales'].'</label><br>
		<label>'.$xml->YN_MASTURBACION->es.': '.$psic['yn_masturbacion'].'</label><br>
		<label>'.$xml->TXT_MASTURBACION_INICIO->es.': '.$psic['txt_masturbacion_inicio'].'</label><br>
		<label>'.$xml->TXT_CUANTAS_MASTURBACIONES->es.': '.$psic['txt_cuantas_masturbaciones'].'</label><br>
		<label>'.$xml->DRP_CUANTAS_MASTURBACIONES->es.': '.$xml->DRP_CUANTAS_MASTURBACIONES->es->option[intval($psic['drp_cuantas_masturbaciones'])].'</label><br>
		<label>'.$xml->AREA_OBSERVACIONES_SEXUALIDAD->es.': '.$psic['area_observaciones_sexualidad'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Abuso Sexual </legend>
		<label>'.$xml->DRP_ABUSO_SEXUAL->es.': '.$xml->DRP_ABUSO_SEXUAL->es->option[intval($psic['drp_abuso_sexual'])].'</label><br>
		<label>'.$xml->ARE_TIPO_ABUSO->es.': '.$psic['are_tipo_abuso'].'</label><br>
		<label>'.$xml->DRP_DENUNCIA_ABUSO->es.': '.$xml->DRP_DENUNCIA_ABUSO->es->option[intval($psic['drp_denuncia_abuso'])].'</label><br>
		<label>'.$xml->TXT_DONDE_DENUNCIA->es.': '.$psic['txt_donde_denuncia'].'</label><br>
		<label>'.$xml->TXT_EDAD_AGRESOR->es.': '.$psic['txt_edad_agresor'].'</label><br>
		<label>'.$xml->TXT_CANTIDAD_AGRESORES->es.': '.$psic['txt_cantidad_agresores'].'</label><br>
		<label>'.$xml->TXT_EDAD_INICIO_ABUSO->es.': '.$psic['txt_edad_inicio_abuso'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Tiempo de Abuso </legend>
		<label>'.$xml->TXT_ANOS_ABUSO->es.': '.$psic['txt_anos_abuso'].'</label><br>
		<label>'.$xml->TXT_MESES_ABUSO->es.': '.$psic['txt_meses_abuso'].'</label><br>
		<label>'.$xml->TXT_SEMANAS_ABUSO->es.': '.$psic['txt_semanas_abuso'].'</label><br>
		<label>'.$xml->DRP_TRATAMIENTO_ABUSO->es.': '.$xml->DRP_TRATAMIENTO_ABUSO->es->option[intval($psic['drp_tratamiento_abuso'])].'</label><br>
		<label>'.$xml->AREA_OBSERVACIONES_ABUSO->es.': '.$psic['area_observaciones_abuso'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. EMBARAZO CON USO DE METODOS ANTICONCEPTIVOS </legend>
		<label>'.$xml->DRP_EMBARAZO_ANTICONCEPTIVO->es.': '.$xml->DRP_EMBARAZO_ANTICONCEPTIVO->es->option[intval($psic['drp_embarazo_anticonceptivo'])].'</label><br>
		<label>'.$xml->TXT_EMBARAZO_ANTICONCEPTIVO->es.': '.$psic['txt_embarazo_anticonceptivo'].'</label><br>
		<label>'.$xml->TXT_RAZON_NO_USO->es.': '.$psic['txt_razon_no_uso'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. E.T.S. </legend>
		<label>'.$xml->DRP_CONOCE_ETS->es.': '.$xml->DRP_CONOCE_ETS->es->option[intval($psic['drp_conoce_ets'])].'</label><br>
		<label>'.$xml->AREA_CONOCE_ETS->es.': '.$psic['area_conoce_ets'].'</label><br>
		<label>'.$xml->DRP_TIENE_ETS->es.': '.$xml->DRP_TIENE_ETS->es->option[intval($psic['drp_tiene_ets'])].'</label><br>
		<label>'.$xml->AREA_CUAL_ETS->es.': '.$psic['area_cual_ets'].'</label><br>
		<label>'.$xml->DRP_TENIDO_ALGUNA_ETS->es.': '.$xml->DRP_TENIDO_ALGUNA_ETS->es->option[intval($psic['drp_tenido_alguna_ets'])].'</label><br>
		<label>'.$xml->DRP_TRATAMIENTO_ETS->es.': '.$xml->DRP_TRATAMIENTO_ETS->es->option[intval($psic['drp_tratamiento_ets'])].'</label><br>
		<label>'.$xml->AREA_CUAL_TRATAMIENTO_ETS->es.': '.$psic['area_cual_tratamiento_ets'].'</label><br>
		<label>'.$xml->AREA_TENIDO_ETS_PAREJA_CUAL->es.': '.$psic['area_tenido_ets_pareja_cual'].'</label><br>
		<label>'.$xml->DRP_PAREJA_ACTUAL_ETS->es.': '.$xml->DRP_PAREJA_ACTUAL_ETS->es->option[intval($psic['drp_pareja_actual_ets'])].'</label><br>
		<label>'.$xml->AREA_CUAL_ETS_PAREJA->es.': '.$psic['area_cual_ets_pareja'].'</label><br>
		<label>'.$xml->DRP_TRATAMIENTO_ETS_PAREJA->es.': '.$xml->DRP_TRATAMIENTO_ETS_PAREJA->es->option[intval($psic['drp_tratamiento_ets_pareja'])].'</label><br>
		<label>'.$xml->AREA_CUAL_TRATAMIENTO_ETS_PAREJA->es.': '.$psic['area_cual_tratamiento_ets_pareja'].'</label><br>
		<label>'.$xml->AREA_OBSERVACIONES_ETS->es.': '.$psic['area_observaciones_ets'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Fecundidad </legend>
		<label>'.$xml->TXT_EMBARAZOS->es.': '.$psic['txt_embarazos'].'</label><br>
		<label>'.$xml->TXT_ABORTO_ESPONTANEO->es.': '.$psic['txt_aborto_espontaneo'].'</label><br>
		<label>'.$xml->TXT_ABORTO_PROVOCADO->es.': '.$psic['txt_aborto_provocado'].'</label><br>
		<label>'.$xml->TXT_ABORTO_ECTOPICO->es.': '.$psic['txt_aborto_ectopico'].'</label><br>
		<label>'.$xml->TXT_ABORTOS_TOTAL->es.': '.$psic['txt_abortos_total'].'</label><br>
		<label>'.$xml->TXT_EMBARAZOS_VIVO->es.': '.$psic['txt_embarazos_vivo'].'</label><br>
		<label>'.$xml->TXT_EMBARAZOS_MUERTOS->es.': '.$psic['txt_embarazos_muertos'].'</label><br>
		<label>'.$xml->TXT_NACIMIENTOS->es.': '.$psic['txt_nacimientos'].'</label><br>
		<label>'.$xml->TXT_PRIMER_EMBARAZO->es.': '.$psic['txt_primer_embarazo'].'</label><br>
		<label>'.$xml->DRP_PATOLOGIA_EMBARAZO->es.': '.$xml->DRP_PATOLOGIA_EMBARAZO->es->option[intval($psic['drp_patologia_embarazo'])].'</label><br>
		<label>'.$xml->TXT_CUAL_PATOLOGIA->es.': '.$psic['txt_cual_patologia'].'</label><br>
		<label>'.$xml->TXT_PRIMER_PARTO->es.': '.$psic['txt_primer_parto'].'</label><br>
		<label>'.$xml->DRP_HOPITALIZACIONES->es.': '.$xml->DRP_HOPITALIZACIONES->es->option[intval($psic['drp_hopitalizaciones'])].'</label><br>
		<label>'.$xml->DRP_INFECCIONES->es.': '.$xml->DRP_INFECCIONES->es->option[intval($psic['drp_infecciones'])].'</label><br>
		<label>'.$xml->DRP_EMBARAZO_ACTUAL->es.': '.$xml->DRP_EMBARAZO_ACTUAL->es->option[intval($psic['drp_embarazo_actual'])].'</label><br>
		<label>'.$xml->TXT_RN_1->es.': '.$psic['txt_rn_1'].'</label><br>
		<label>'.$xml->TXT_RN_2->es.': '.$psic['txt_rn_2'].'</label><br>
		<label>'.$xml->TXT_RN_3->es.': '.$psic['txt_rn_3'].'</label><br>
		<label>'.$xml->TXT_RN_4->es.': '.$psic['txt_rn_4'].'</label><br>
		<label>'.$xml->DRP_LACTANCIA_ACTUAL->es.': '.$xml->DRP_LACTANCIA_ACTUAL->es->option[intval($psic['drp_lactancia_actual'])].'</label><br>
		<label>'.$xml->DRP_LACTANCIA_PASADA->es.': '.$xml->DRP_LACTANCIA_PASADA->es->option[intval($psic['drp_lactancia_pasada'])].'</label><br>
		<label>'.$xml->TXT_MAXIMA_LACTANCIA_MESES->es.': '.$psic['txt_maxima_lactancia_meses'].'</label><br>
		<label>'.$xml->TXT_MINIMO_LACTANCIA_MESES->es.': '.$psic['txt_minimo_lactancia_meses'].'</label><br>
		<label>'.$xml->DRP_REGULACION_MENSTRUAL->es.': '.$xml->DRP_REGULACION_MENSTRUAL->es->option[intval($psic['drp_regulacion_menstrual'])].'</label><br>
		<label>'.$xml->AREA_OBERVACIONES_FECUNDIDAD->es.': '.$psic['area_obervaciones_fecundidad'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Examen físico. </legend>
		<label>'.$xml->DRP_BELLO_CORPORAL->es.': '.$xml->DRP_BELLO_CORPORAL->es->option[intval($psic['drp_bello_corporal'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Genito urinario </legend>
		<label>'.$xml->TXT_FLUJO_VAGINAL->es.': '.$psic['txt_flujo_vaginal'].'</label><br>
		<label>'.$xml->DRP_ANTES->es.': '.$xml->DRP_ANTES->es->option[intval($psic['drp_antes'])].'</label><br>
		<label>'.$xml->DRP_OLOR->es.': '.$xml->DRP_OLOR->es->option[intval($psic['drp_olor'])].'</label><br>
		<label>'.$xml->TXT_COLOR->es.': '.$psic['txt_color'].'</label><br>
		<label>'.$xml->DRP_ACTUAL_FLUJO->es.': '.$xml->DRP_ACTUAL_FLUJO->es->option[intval($psic['drp_actual_flujo'])].'</label><br>
		<label>'.$xml->TXT_DURACION_FLUJO->es.': '.$psic['txt_duracion_flujo'].'</label><br>
		<label>'.$xml->DRP_MOLESTIAS->es.': '.$xml->DRP_MOLESTIAS->es->option[intval($psic['drp_molestias'])].'</label><br>
		<label>'.$xml->DRP_FLUJO_TRATAMIENTO->es.': '.$xml->DRP_FLUJO_TRATAMIENTO->es->option[intval($psic['drp_flujo_tratamiento'])].'</label><br>
		<label>'.$xml->TXT_SECRECION_URETRAL->es.': '.$psic['txt_secrecion_uretral'].'</label><br>
		<label>'.$xml->DRP_ANTES_SU->es.': '.$xml->DRP_ANTES_SU->es->option[intval($psic['drp_antes_su'])].'</label><br>
		<label>'.$xml->DRP_OLOR_SU->es.': '.$xml->DRP_OLOR_SU->es->option[intval($psic['drp_olor_su'])].'</label><br>
		<label>'.$xml->TXT_COLOR_SU->es.': '.$psic['txt_color_su'].'</label><br>
		<label>'.$xml->DRP_ACTUAL_FLUJO_SU->es.': '.$xml->DRP_ACTUAL_FLUJO_SU->es->option[intval($psic['drp_actual_flujo_su'])].'</label><br>
		<label>'.$xml->TXT_DURACION_FLUJO_SU->es.': '.$psic['txt_duracion_flujo_su'].'</label><br>
		<label>'.$xml->DRP_MOLESTIAS_SU->es.': '.$xml->DRP_MOLESTIAS_SU->es->option[intval($psic['drp_molestias_su'])].'</label><br>
		<label>'.$xml->DRP_FLUJO_TRATAMIENTO_SU->es.': '.$xml->DRP_FLUJO_TRATAMIENTO_SU->es->option[intval($psic['drp_flujo_tratamiento_su'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Examen ginecológico </legend>
		<label>'.$xml->TXT_TANNER->es.': '.$psic['txt_tanner'].'</label><br>
		<label>'.$xml->TXT_MAMAS->es.': '.$psic['txt_mamas'].'</label><br>
		<label>'.$xml->TXT_VELLO->es.': '.$psic['txt_vello'].'</label><br>
		<label>'.$xml->DRP_VULVA->es.': '.$xml->DRP_VULVA->es->option[intval($psic['drp_vulva'])].'</label><br>
		<label>'.$xml->DRP_CLITORIS->es.': '.$xml->DRP_CLITORIS->es->option[intval($psic['drp_clitoris'])].'</label><br>
		<label>'.$xml->DRP_HIMEN->es.': '.$xml->DRP_HIMEN->es->option[intval($psic['drp_himen'])].'</label><br>
		<label>'.$xml->DRP_VAGINA->es.': '.$xml->DRP_VAGINA->es->option[intval($psic['drp_vagina'])].'</label><br>
		<label>'.$xml->DRP_CUELLO_UTERINO->es.': '.$xml->DRP_CUELLO_UTERINO->es->option[intval($psic['drp_cuello_uterino'])].'</label><br>
		<label>'.$xml->DRP_CUERPO_UTERINO->es.': '.$xml->DRP_CUERPO_UTERINO->es->option[intval($psic['drp_cuerpo_uterino'])].'</label><br>
		<label>'.$xml->DRP_TACTO_VAGINAL->es.': '.$xml->DRP_TACTO_VAGINAL->es->option[intval($psic['drp_tacto_vaginal'])].'</label><br>
		<label>'.$xml->DRP_TACTO_RECTAL->es.': '.$xml->DRP_TACTO_RECTAL->es->option[intval($psic['drp_tacto_rectal'])].'</label><br>
		<label>'.$xml->DRP_ANEXO_IZQUIERDO->es.': '.$xml->DRP_ANEXO_IZQUIERDO->es->option[intval($psic['drp_anexo_izquierdo'])].'</label><br>
		<label>'.$xml->DRP_ANEXO_DERECHO->es.': '.$xml->DRP_ANEXO_DERECHO->es->option[intval($psic['drp_anexo_derecho'])].'</label><br>
		<label>'.$xml->DRP_EXAMEN_MAMARIO->es.': '.$xml->DRP_EXAMEN_MAMARIO->es->option[intval($psic['drp_examen_mamario'])].'</label><br>
		<label>'.$xml->TXT_TOMA_MUESTRAS->es.': '.$psic['txt_toma_muestras'].'</label><br>
		<label>'.$xml->AREA_OBSERVACIONES_EX_GINECOLOGICO->es.': '.$psic['area_observaciones_ex_ginecologico'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Examen genital masculino. </legend>
		<label>'.$xml->TXT_TANNER_HOMBRE->es.': '.$psic['txt_tanner_hombre'].'</label><br>
		<label>'.$xml->TXT_GENITALES->es.': '.$psic['txt_genitales'].'</label><br>
		<label>'.$xml->TXT_VELLO_HOMBRE->es.': '.$psic['txt_vello_hombre'].'</label><br>
		<label>'.$xml->DRP_PENE_CUERPO->es.': '.$xml->DRP_PENE_CUERPO->es->option[intval($psic['drp_pene_cuerpo'])].'</label><br>
		<label>'.$xml->DRP_GLANDE->es.': '.$xml->DRP_GLANDE->es->option[intval($psic['drp_glande'])].'</label><br>
		<label>'.$xml->DRP_PREPUCIO->es.': '.$xml->DRP_PREPUCIO->es->option[intval($psic['drp_prepucio'])].'</label><br>
		<label>'.$xml->YN_SECRECION->es.': '.$psic['yn_secrecion'].'</label><br>
		<label>'.$xml->DRP_ESCROTO->es.': '.$xml->DRP_ESCROTO->es->option[intval($psic['drp_escroto'])].'</label><br>
		<label>'.$xml->DRP_TESTICULO_DERECHO->es.': '.$xml->DRP_TESTICULO_DERECHO->es->option[intval($psic['drp_testiculo_derecho'])].'</label><br>
		<label>'.$xml->DRP_TESTICULO_IZQUIERDO->es.': '.$xml->DRP_TESTICULO_IZQUIERDO->es->option[intval($psic['drp_testiculo_izquierdo'])].'</label><br>
		<label>'.$xml->DRP_EXAMEN_MAMARIO_HOMBRE->es.': '.$xml->DRP_EXAMEN_MAMARIO_HOMBRE->es->option[intval($psic['drp_examen_mamario_hombre'])].'</label><br>
		<label>'.$xml->AREA_OBSERVACIONES_GENITAL_MASCULINO->es.': '.$psic['area_observaciones_genital_masculino'].'</label><br>
	    <label>'.$xml->AREA_PALPACION_GENITAL_HOMBRES->es.': '.$psic['area_palpacion_genital_hombres'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>III. Exámenes complementarios </legend>
		<label>'.$xml->DRP_HEMOGRAMA->es.': '.$xml->DRP_HEMOGRAMA->es->option[intval($psic['drp_hemograma'])].'</label><br>
		<label>'.$xml->DRP_SEDIMENTO_URINARIO->es.': '.$xml->DRP_SEDIMENTO_URINARIO->es->option[intval($psic['drp_sedimento_urinario'])].'</label><br>
		<label>'.$xml->DRP_QUIMICO_DE_ORINA->es.': '.$xml->DRP_QUIMICO_DE_ORINA->es->option[intval($psic['drp_quimico_de_orina'])].'</label><br>
		<label>'.$xml->DRP_UROCUL_ANTIBIOG->es.': '.$xml->DRP_UROCUL_ANTIBIOG->es->option[intval($psic['drp_urocul_antibiog'])].'</label><br>
		<label>'.$xml->DRP_UREMIA->es.': '.$xml->DRP_UREMIA->es->option[intval($psic['drp_uremia'])].'</label><br>
		<label>'.$xml->DRP_GLICEMIA->es.': '.$xml->DRP_GLICEMIA->es->option[intval($psic['drp_glicemia'])].'</label><br>
		<label>'.$xml->DRP_NITROGENO_UREICO->es.': '.$xml->DRP_NITROGENO_UREICO->es->option[intval($psic['drp_nitrogeno_ureico'])].'</label><br>
		<label>'.$xml->DRP_PERFIL_LIPIDICO->es.': '.$xml->DRP_PERFIL_LIPIDICO->es->option[intval($psic['drp_perfil_lipidico'])].'</label><br>
		<label>'.$xml->DRP_VDRL_OTRO->es.': '.$xml->DRP_VDRL_OTRO->es->option[intval($psic['drp_vdrl_otro'])].'</label><br>
		<label>'.$xml->DRP_HIV->es.': '.$xml->DRP_HIV->es->option[intval($psic['drp_hiv'])].'</label><br>
		<label>'.$xml->DRP_PAPANICOLAU->es.': '.$xml->DRP_PAPANICOLAU->es->option[intval($psic['drp_papanicolau'])].'</label><br>
		<label>'.$xml->DRP_TEST_SCHILLER->es.': '.$xml->DRP_TEST_SCHILLER->es->option[intval($psic['drp_test_schiller'])].'</label><br>
		<label>'.$xml->DRP_EXAMEN_FLUJO_VAGINAL->es.': '.$xml->DRP_EXAMEN_FLUJO_VAGINAL->es->option[intval($psic['drp_examen_flujo_vaginal'])].'</label><br>
		<label>'.$xml->DRP_CULTIVO_FLUJO_VAGINAL->es.': '.$xml->DRP_CULTIVO_FLUJO_VAGINAL->es->option[intval($psic['drp_cultivo_flujo_vaginal'])].'</label><br>
		<label>'.$xml->DRP_PERFIL_HORMONAL->es.': '.$xml->DRP_PERFIL_HORMONAL->es->option[intval($psic['drp_perfil_hormonal'])].'</label><br>
		<label>'.$xml->DRP_RADIOGRAFIA->es.': '.$xml->DRP_RADIOGRAFIA->es->option[intval($psic['drp_radiografia'])].'</label><br>
		<label>'.$xml->DRP_ECOGRAFIA->es.': '.$xml->DRP_ECOGRAFIA->es->option[intval($psic['drp_ecografia'])].'</label><br>
		<label>'.$xml->DRP_COLPOSCOPIA->es.': '.$xml->DRP_COLPOSCOPIA->es->option[intval($psic['drp_colposcopia'])].'</label><br>
		<label>'.$xml->TXT_RESPONSABLE->es.': '.$psic['txt_responsable'].'</label><br>
		<label>'.$xml->FECHA_PROXIMA_CITA->es.': '.$psic['fecha_proxima_cita'].'</label><br>
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