<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_enfermedad_cronica where caso =  '$caso'";
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

	
	if (file_exists('datosxml/EnfermedadCronicaXml.xml')) {
    $xml = simplexml_load_file('datosxml/EnfermedadCronicaXml.xml');

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
		<label>Atencion: Enfermedad Cronica</label><br>	
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
		<label> Motivo de consulta: '.$psic['area_motivo_consulta'].'</label><br>	
		<label> Engermedad actual: '.$psic['txt_enf_actual'].'</label>	
	</fieldset>
	<br>
	<fieldset>
		<legend>III. Antecedentes Familiares</legend>
		<label>'.$xml->DRP_HTA->es.': '.$xml->DRP_HTA->es->option[intval($psic['drp_hta'])].'</label>	<br>
		<label>'.$xml->DRP_DIABETES->es.': '.$xml->DRP_DIABETES->es->option[intval($psic['drp_diabetes'])].'</label>	<br>
		<label>'.$xml->DRP_DISLIPIDEMIA->es.': '.$xml->DRP_DISLIPIDEMIA->es->option[intval($psic['drp_dislipidemia'])].'</label>	<br>
		<label>'.$xml->DRP_ENF_CORONARIA->es.': '.$xml->DRP_ENF_CORONARIA->es->option[intval($psic['drp_enf_coronaria'])].'</label>	<br>
		<label>'.$xml->DRP_IAM->es.': '.$xml->DRP_IAM->es->option[intval($psic['drp_iam'])].'</label>	<br>
		<label>'.$xml->DRP_ENF_ENDOCRINA->es.': '.$xml->DRP_ENF_ENDOCRINA->es->option[intval($psic['drp_enf_endocrina'])].'</label>	<br>
		<label>'.$xml->DRP_ENF_RENAL->es.': '.$xml->DRP_ENF_RENAL->es->option[intval($psic['drp_enf_renal'])].'</label>	<br>
		<label>'.$xml->DRP_OBESIDAD->es.': '.$xml->DRP_OBESIDAD->es->option[intval($psic['drp_obesidad'])].'</label>	<br>
		<label>'.$xml->DRP_ENF_VASCULAR->es.': '.$xml->DRP_ENF_VASCULAR->es->option[intval($psic['drp_enf_vascular'])].'</label>	<br>
		<label>'.$xml->DRP_CA_CERVIX->es.': '.$xml->DRP_CA_CERVIX->es->option[intval($psic['drp_ca_cervix'])].'</label>	<br>
		<label>'.$xml->DRP_CA_COLON->es.': '.$xml->DRP_CA_COLON->es->option[intval($psic['drp_ca_colon'])].'</label>	<br>
		<label>'.$xml->DRP_CA_PROSTATA->es.': '.$xml->DRP_CA_PROSTATA->es->option[intval($psic['drp_ca_prostata'])].'</label>	<br>
		<label>'.$xml->DRP_CA_GASTRICO->es.': '.$xml->DRP_CA_GASTRICO->es->option[intval($psic['drp_ca_gastrico'])].'</label>	<br>
		<label>'.$xml->DRP_CA_MAMA->es.': '.$xml->DRP_CA_MAMA->es->option[intval($psic['drp_ca_mama'])].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_ANTE_FAMILIARES->es.': '.$psic['area_observaciones_ante_familiares'].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>IV. Antecedentes personales</legend>
		<label>'.$xml->DRP_HTA1->es.': '.$xml->DRP_HTA1->es->option[intval($psic['drp_hta1'])].'</label>	<br>
		<label>'.$xml->DRP_DIABETES1->es.': '.$xml->DRP_DIABETES1->es->option[intval($psic['drp_diabetes1'])].'</label>	<br>
		<label>'.$xml->DRP_DISLIPIDEMIA1->es.': '.$xml->DRP_DISLIPIDEMIA1->es->option[intval($psic['drp_dislipidemia1'])].'</label>	<br>
		<label>'.$xml->DRP_ENF_CORONARIA1->es.': '.$xml->DRP_ENF_CORONARIA1->es->option[intval($psic['drp_enf_coronaria1'])].'</label>	<br>
		<label>'.$xml->DRP_IAM1->es.': '.$xml->DRP_IAM1->es->option[intval($psic['drp_iam1'])].'</label>	<br>
		<label>'.$xml->DRP_ENF_ENDOCRINA1->es.': '.$xml->DRP_ENF_ENDOCRINA1->es->option[intval($psic['drp_enf_endocrina1'])].'</label>	<br>
		<label>'.$xml->DRP_ENF_RENAL1->es.': '.$xml->DRP_ENF_RENAL1->es->option[intval($psic['drp_enf_renal1'])].'</label>	<br>
		<label>'.$xml->DRP_OBESIDAD1->es.': '.$xml->DRP_OBESIDAD1->es->option[intval($psic['drp_obesidad1'])].'</label>	<br>
		<label>'.$xml->DRP_ENF_VASCULAR1->es.': '.$xml->DRP_ENF_VASCULAR1->es->option[intval($psic['drp_enf_vascular1'])].'</label>	<br>
		<label>'.$xml->DRP_CA_CERVIX1->es.': '.$xml->DRP_CA_CERVIX1->es->option[intval($psic['drp_ca_cervix1'])].'</label>	<br>
		<label>'.$xml->DRP_ACV->es.': '.$xml->DRP_ACV->es->option[intval($psic['drp_acv'])].'</label>	<br>
		<label>'.$xml->DRP_EPOC->es.': '.$xml->DRP_EPOC->es->option[intval($psic['drp_epoc'])].'</label>	<br>
		<label>'.$xml->DRP_ASMA->es.': '.$xml->DRP_ASMA->es->option[intval($psic['drp_asma'])].'</label>	<br>
		<label>'.$xml->DRP_TBC->es.': '.$xml->DRP_TBC->es->option[intval($psic['drp_tbc'])].'</label>	<br>
		<label>'.$xml->DRP_TRAUMAS->es.': '.$xml->DRP_TRAUMAS->es->option[intval($psic['drp_traumas'])].'</label>	<br>
		<label>'.$xml->DRP_CA_PROSTATA1->es.': '.$xml->DRP_CA_PROSTATA1->es->option[intval($psic['drp_ca_prostata1'])].'</label>	<br>
		<label>'.$xml->DRP_CA_GASTRICO1->es.': '.$xml->DRP_CA_GASTRICO1->es->option[intval($psic['drp_ca_gastrico1'])].'</label>	<br>
		<label>'.$xml->DRP_CA_MAMA1->es.': '.$xml->DRP_CA_MAMA1->es->option[intval($psic['drp_ca_mama1'])].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_ANTE_PERSONALES->es.': '.$psic['area_observaciones_ante_personales'].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>V. A.G.O </legend>
		<label>'.$xml->TXT_MENARQUIA->es.': '.$psic['txt_menarquia'].'</label>	<br>
		<label>'.$xml->TXT_FUM->es.': '.$psic['txt_fum'].'</label>	<br>
		<label>'.$xml->DRP_MENOPAUSIA->es.': '.$xml->DRP_MENOPAUSIA->es->option[intval($psic['drp_menopausia'])].'</label>	<br>
		<label>'.$xml->TXT_G->es.': '.$psic['txt_g'].'</label>	<br>
		<label>'.$xml->TXT_P->es.': '.$psic['txt_p'].'</label>	<br>
		<label>'.$xml->TXT_A->es.': '.$psic['txt_a'].'</label>	<br>
		<label>'.$xml->TXT_C->es.': '.$psic['txt_c'].'</label>	<br>
		<label>'.$xml->DRP_PLANIFICACION_FAMILIAR->es.': '.$xml->DRP_PLANIFICACION_FAMILIAR->es->option[intval($psic['drp_planificacion_familiar'])].'</label>	<br>
		<label>'.$xml->TXT_METODO->es.': '.$psic['txt_metodo'].'</label>	<br>
		<label>'.$xml->TXT_TIEMPO->es.': '.$psic['txt_tiempo'].'</label>	<br>
		<label>'.$xml->TXT_TIEMPO1->es.': '.$psic['txt_tiempo1'].'</label>	<br>
		<label>'.$xml->DATE_ULT_CIT->es.': '.$psic['date_ult_cit'].'</label>	<br>
		<label>'.$xml->DRP_CUMPLE_CICLO->es.': '.$xml->DRP_CUMPLE_CICLO->es->option[intval($psic['drp_cumple_ciclo'])].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>VI. Antecedentes farmacológicos </legend>
		<label>'.$xml->AREA_MEDICACION_PREVIA->es.': '.$psic['area_medicacion_previa'].'</label>	<br>
		<label>'.$xml->AREA_QUIEN_ADMINISTRA_MEDICAMENTO->es.': '.$psic['area_quien_administra_medicamento'].'</label>	<br>
		<label>'.$xml->TXT_ADHERENCIA_TRATAMIENTO->es.': '.$psic['txt_adherencia_tratamiento'].'</label>	<br>
		<label>'.$xml->TXT_MORISKY->es.': '.$psic['txt_morisky'].'</label>	<br>
		<label>'.$xml->DRP_DESCUIDADO_HORARIO->es.': '.$xml->DRP_DESCUIDADO_HORARIO->es->option[intval($psic['drp_descuidado_horario'])].'</label>	<br>
		<label>'.$xml->DRP_CAENMAL_DEJA->es.': '.$xml->DRP_CAENMAL_DEJA->es->option[intval($psic['drp_caenmal_deja'])].'</label>	<br>
		<label>'.$xml->DRP_ALERGICO_MEDICINA->es.': '.$xml->DRP_ALERGICO_MEDICINA->es->option[intval($psic['drp_alergico_medicina'])].'</label>	<br>
		<label>'.$xml->AREA_CUALES_ALERGICOS_MEDICINA->es.': '.$psic['area_cuales_alergicos_medicina'].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>VII. Nutrición </legend>
		<label>'.$xml->DRP_CONSUMO_GRASA->es.': '.$xml->DRP_CONSUMO_GRASA->es->option[intval($psic['drp_consumo_grasa'])].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>VIII. Actividad física </legend>
		<label>'.$xml->DRP_TIPO_ACTIVIDAD->es.': '.$xml->DRP_TIPO_ACTIVIDAD->es->option[intval($psic['drp_tipo_actividad'])].'</label>	<br>
		<label>'.$xml->DRP_FRECUENCIA_ACTIVIDAD->es.': '.$xml->DRP_FRECUENCIA_ACTIVIDAD->es->option[intval($psic['drp_frecuencia_actividad'])].'</label>	<br>
		<label>'.$xml->DRP_DURACION_ACTIVIDAD->es.': '.$xml->DRP_DURACION_ACTIVIDAD->es->option[intval($psic['drp_duracion_actividad'])].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>IX. Exposición a tóxicos. </legend>
		<label>'.$xml->DRP_CONSUMO_PSICOACTIVOS->es.': '.$xml->DRP_CONSUMO_PSICOACTIVOS->es->option[intval($psic['drp_consumo_psicoactivos'])].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>X. Hábito de fumar. </legend>
		<label>'.$xml->TXT_INCIO_FUMAR->es.': '.$psic['txt_incio_fumar'].'</label>	<br>
		<label>'.$xml->DRP_EFECTOS_NOCIVOS->es.': '.$xml->DRP_EFECTOS_NOCIVOS->es->option[intval($psic['drp_efectos_nocivos'])].'</label>	<br>
		<label>'.$xml->DRP_FRECUENCIA_FUMAR->es.': '.$xml->DRP_FRECUENCIA_FUMAR->es->option[intval($psic['drp_frecuencia_fumar'])].'</label>	<br>
		<label>'.$xml->DRP_NO_CIGARRILLOS->es.': '.$xml->DRP_NO_CIGARRILLOS->es->option[intval($psic['drp_no_cigarrillos'])].'</label>	<br>
		<label>'.$xml->DRP_LENA->es.': '.$xml->DRP_LENA->es->option[intval($psic['drp_lena'])].'</label>	<br>
		<label>'.$xml->TXT_NO_ANO_LENA->es.': '.$psic['txt_no_ano_lena'].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XI. Violencia intrafamiliar </legend>
		<label>'.$xml->DRP_BIEN_FAMILIA->es.': '.$xml->DRP_BIEN_FAMILIA->es->option[intval($psic['drp_bien_familia'])].'</label>	<br>
		<label>'.$xml->DRP_APOYO_FAMILIA->es.': '.$xml->DRP_APOYO_FAMILIA->es->option[intval($psic['drp_apoyo_familia'])].'</label>	<br>
		<label>'.$xml->DRP_FAMILIA_CARINO->es.': '.$xml->DRP_FAMILIA_CARINO->es->option[intval($psic['drp_familia_carino'])].'</label>	<br>
		<label>'.$xml->DRP_RECHAZO_FAMILIA->es.': '.$xml->DRP_RECHAZO_FAMILIA->es->option[intval($psic['drp_rechazo_familia'])].'</label>	<br>
		<label>'.$xml->DRP_AGRESION_FAMILIA->es.': '.$xml->DRP_AGRESION_FAMILIA->es->option[intval($psic['drp_agresion_familia'])].'</label>	<br>
		<label>'.$xml->DRP_SUICIDA->es.': '.$xml->DRP_SUICIDA->es->option[intval($psic['drp_suicida'])].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XII. Revisión por sistemas.</legend>
		<label>'.$xml->DRP_CEFALEA->es.': '.$xml->DRP_CEFALEA->es->option[intval($psic['drp_cefalea'])].'</label>	<br>
		<label>'.$xml->DRP_LIPOTIMIA->es.': '.$xml->DRP_LIPOTIMIA->es->option[intval($psic['drp_lipotimia'])].'</label>	<br>
		<label>'.$xml->DRP_SINCOPE->es.': '.$xml->DRP_SINCOPE->es->option[intval($psic['drp_sincope'])].'</label>	<br>
		<label>'.$xml->DRP_VERTIGO->es.': '.$xml->DRP_VERTIGO->es->option[intval($psic['drp_vertigo'])].'</label>	<br>
		<label>'.$xml->DRP_TINITUS->es.': '.$xml->DRP_TINITUS->es->option[intval($psic['drp_tinitus'])].'</label>	<br>
		<label>'.$xml->DRP_FOSFENOS->es.': '.$xml->DRP_FOSFENOS->es->option[intval($psic['drp_fosfenos'])].'</label>	<br>
		<label>'.$xml->DRP_PERDIDA_VISION->es.': '.$xml->DRP_PERDIDA_VISION->es->option[intval($psic['drp_perdida_vision'])].'</label>	<br>
		<label>'.$xml->DRP_FOTOFOBIA->es.': '.$xml->DRP_FOTOFOBIA->es->option[intval($psic['drp_fotofobia'])].'</label>	<br>
		<label>'.$xml->DRP_SUDORACION->es.': '.$xml->DRP_SUDORACION->es->option[intval($psic['drp_sudoracion'])].'</label>	<br>
		<label>'.$xml->DRP_EPISTAXIS->es.': '.$xml->DRP_EPISTAXIS->es->option[intval($psic['drp_epistaxis'])].'</label>	<br>
		<label>'.$xml->DRP_HIPOACUSIA->es.': '.$xml->DRP_HIPOACUSIA->es->option[intval($psic['drp_hipoacusia'])].'</label>	<br>
		<label>'.$xml->DRP_PALPITACIONES->es.': '.$xml->DRP_PALPITACIONES->es->option[intval($psic['drp_palpitaciones'])].'</label>	<br>
		<label>'.$xml->DRP_DOLOR_PRECORDIAL->es.': '.$xml->DRP_DOLOR_PRECORDIAL->es->option[intval($psic['drp_dolor_precordial'])].'</label>	<br>
		<label>'.$xml->DRP_EDEMAS->es.': '.$xml->DRP_EDEMAS->es->option[intval($psic['drp_edemas'])].'</label>	<br>
		<label>'.$xml->DRP_TOS->es.': '.$xml->DRP_TOS->es->option[intval($psic['drp_tos'])].'</label>	<br>
		<label>'.$xml->DRP_DISNEA->es.': '.$xml->DRP_DISNEA->es->option[intval($psic['drp_disnea'])].'</label>	<br>
		<label>'.$xml->DRP_HEMOPTISIS->es.': '.$xml->DRP_HEMOPTISIS->es->option[intval($psic['drp_hemoptisis'])].'</label>	<br>
		<label>'.$xml->DRP_ORTOPNEA->es.': '.$xml->DRP_ORTOPNEA->es->option[intval($psic['drp_ortopnea'])].'</label>	<br>
		<label>'.$xml->DRP_POLIDIPSIA->es.': '.$xml->DRP_POLIDIPSIA->es->option[intval($psic['drp_polidipsia'])].'</label>	<br>
		<label>'.$xml->DRP_POLIURIA->es.': '.$xml->DRP_POLIURIA->es->option[intval($psic['drp_poliuria'])].'</label>	<br>
		<label>'.$xml->DRP_POLAQUIURIA->es.': '.$xml->DRP_POLAQUIURIA->es->option[intval($psic['drp_polaquiuria'])].'</label>	<br>
		<label>'.$xml->DRP_NICTURIA->es.': '.$xml->DRP_NICTURIA->es->option[intval($psic['drp_nicturia'])].'</label>	<br>
		<label>'.$xml->DRP_HEMATURIA->es.': '.$xml->DRP_HEMATURIA->es->option[intval($psic['drp_hematuria'])].'</label>	<br>
		<label>'.$xml->DRP_DISURIA->es.': '.$xml->DRP_DISURIA->es->option[intval($psic['drp_disuria'])].'</label>	<br>
		<label>'.$xml->DRP_INCONTINENCIA->es.': '.$xml->DRP_INCONTINENCIA->es->option[intval($psic['drp_incontinencia'])].'</label>	<br>
		<label>'.$xml->DRP_DOLOR_NEURITICO->es.': '.$xml->DRP_DOLOR_NEURITICO->es->option[intval($psic['drp_dolor_neuritico'])].'</label>	<br>
		<label>'.$xml->DRP_CLAUDICACION->es.': '.$xml->DRP_CLAUDICACION->es->option[intval($psic['drp_claudicacion'])].'</label>	<br>
		<label>'.$xml->DRP_ULCERAS_PIES->es.': '.$xml->DRP_ULCERAS_PIES->es->option[intval($psic['drp_ulceras_pies'])].'</label>	<br>
		<label>'.$xml->DRP_IMPOTENCIA_SEXUAL->es.': '.$xml->DRP_IMPOTENCIA_SEXUAL->es->option[intval($psic['drp_impotencia_sexual'])].'</label>	<br>
		<label>'.$xml->DRP_PERDIDA_PESO->es.': '.$xml->DRP_PERDIDA_PESO->es->option[intval($psic['drp_perdida_peso'])].'</label>	<br>
		<label>'.$xml->DRP_ALTERACION_MARCHA->es.': '.$xml->DRP_ALTERACION_MARCHA->es->option[intval($psic['drp_alteracion_marcha'])].'</label>	<br>
		<label>'.$xml->DRP_ALTERACION_EQUILIBRIO->es.': '.$xml->DRP_ALTERACION_EQUILIBRIO->es->option[intval($psic['drp_alteracion_equilibrio'])].'</label>	<br>
		<label>'.$xml->DRP_ASINTOMATICO->es.': '.$xml->DRP_ASINTOMATICO->es->option[intval($psic['drp_asintomatico'])].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_REVISION_SISTEMAS->es.': '.$psic['area_observaciones_revision_sistemas'].'</label>	<br>
		<label>'.$xml->DRP_SINTOMATICO_RESPIRATORIO->es.': '.$xml->DRP_SINTOMATICO_RESPIRATORIO->es->option[intval($psic['drp_sintomatico_respiratorio'])].'</label>	<br>
		<label>'.$xml->DRP_SINTOMATICO_PIEL->es.': '.$xml->DRP_SINTOMATICO_PIEL->es->option[intval($psic['drp_sintomatico_piel'])].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XIII. Signos vitales.</legend>
		<label>'.$xml->TXT_FC_CARDIACA->es.': '.$psic['txt_fc_cardiaca'].'</label>	<br>
		<label>'.$xml->TXT_FC_RESPIRATORIA->es.': '.$psic['txt_fc_respiratoria'].'</label>	<br>
		<label>'.$xml->TXT_TEMPERATURA->es.': '.$psic['txt_temperatura'].'</label>	<br>
		<label>'.$xml->TXT_TA_SENTADO->es.': '.$psic['txt_ta_sentado'].'</label>	<br>
		<label>'.$xml->TXT_TA_ACOSTADO->es.': '.$psic['txt_ta_acostado'].'</label>	<br>
		<label>'.$xml->TXT_TA_PIE->es.': '.$psic['txt_ta_pie'].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XIV. Medidas antropometricas.</legend>
		<label>'.$xml->TXT_PESO->es.': '.$psic['txt_peso'].'</label>	<br>
		<label>'.$xml->TXT_TALLA->es.': '.$psic['txt_talla'].'</label>	<br>
		<label>'.$xml->TXT_IMC->es.': '.$psic['txt_imc'].'</label>	<br>
		<label>'.$xml->TXT_PESO_ANTERIOR->es.': '.$psic['txt_peso_anterior'].'</label>	<br>
		<label>'.$xml->DRP_PERIMETRO_ABDOMINALH->es.': '.$xml->DRP_PERIMETRO_ABDOMINALH->es->option[intval($psic['drp_perimetro_abdominalh'])].'</label>	<br>
		<label>'.$xml->DRP_PERIMETRO_ABDOMINALM->es.': '.$xml->DRP_PERIMETRO_ABDOMINALM->es->option[intval($psic['drp_perimetro_abdominalm'])].'</label>	<br>
		<label>'.$xml->TXT_PERIMETRO_ABDOMINALH->es.': '.$psic['txt_perimetro_abdominalh'].'</label>	<br>
		<label>'.$xml->TXT_PERIMETRO_ABDOMINALM->es.': '.$psic['txt_perimetro_abdominalm'].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XV. Examen Físico </legend>
		<label>'.$xml->DRP_CABEZA->es.': '.$xml->DRP_CABEZA->es->option[intval($psic['drp_cabeza'])].'</label>	<br>
		<label>'.$xml->DRP_ORL->es.': '.$xml->DRP_ORL->es->option[intval($psic['drp_orl'])].'</label>	<br>
		<label>'.$xml->DRP_ORL_ORAL->es.': '.$xml->DRP_ORL_ORAL->es->option[intval($psic['drp_orl_oral'])].'</label>	<br>
		<label>'.$xml->DRP_CUELLO_YUGULAR->es.': '.$xml->DRP_CUELLO_YUGULAR->es->option[intval($psic['drp_cuello_yugular'])].'</label>	<br>
		<label>'.$xml->DRP_TORAX_MAMAS->es.': '.$xml->DRP_TORAX_MAMAS->es->option[intval($psic['drp_torax_mamas'])].'</label>	<br>
		<label>'.$xml->DRP_CORAZON_SOPLO->es.': '.$xml->DRP_CORAZON_SOPLO->es->option[intval($psic['drp_corazon_soplo'])].'</label>	<br>
		<label>'.$xml->DRP_PULMONES->es.': '.$xml->DRP_PULMONES->es->option[intval($psic['drp_pulmones'])].'</label>	<br>
		<label>'.$xml->DRP_ABDOMEN->es.': '.$xml->DRP_ABDOMEN->es->option[intval($psic['drp_abdomen'])].'</label>	<br>
		<label>'.$xml->DRP_GENITOURINARIO->es.': '.$xml->DRP_GENITOURINARIO->es->option[intval($psic['drp_genitourinario'])].'</label>	<br>
		<label>'.$xml->DRP_EXTREMIDADES->es.': '.$xml->DRP_EXTREMIDADES->es->option[intval($psic['drp_extremidades'])].'</label>	<br>
		<label>'.$xml->DRP_NEUROLOGICO->es.': '.$xml->DRP_NEUROLOGICO->es->option[intval($psic['drp_neurologico'])].'</label>	<br>
		<label>'.$xml->DRP_MUSCULOESQUELETICO->es.': '.$xml->DRP_MUSCULOESQUELETICO->es->option[intval($psic['drp_musculoesqueletico'])].'</label>	<br>
		<label>'.$xml->DRP_PIEL->es.': '.$xml->DRP_PIEL->es->option[intval($psic['drp_piel'])].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_CABEZA->es.': '.$psic['area_observaciones_cabeza'].'</label>	<br>
		<label>'.$xml->AREA_ORL->es.': '.$psic['area_orl'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_ORL_ORAL->es.': '.$psic['area_observaciones_orl_oral'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_CUELLO_YUGULAR->es.': '.$psic['area_observaciones_cuello_yugular'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_TORAX_MAMAS->es.': '.$psic['area_observaciones_torax_mamas'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_CORAZON_SOPLO->es.': '.$psic['area_observaciones_corazon_soplo'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_PULMONES->es.': '.$psic['area_observaciones_pulmones'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_ABDOMEN->es.': '.$psic['area_observaciones_abdomen'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_GENITOURINARIO->es.': '.$psic['area_observaciones_genitourinario'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_EXTREMIDADES->es.': '.$psic['area_observaciones_extremidades'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_NEUROLOGICO->es.': '.$psic['area_observaciones_neurologico'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_MUSCULOESQUELETICO->es.': '.$psic['area_observaciones_musculoesqueletico'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_PIEL->es.': '.$psic['area_observaciones_piel'].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XVI. Diagnósticos </legend>
		<label>'.$xml->DRP_HIPERTENSION_ARTERIAL->es.': '.$xml->DRP_HIPERTENSION_ARTERIAL->es->option[intval($psic['drp_hipertension_arterial'])].'</label>	<br>
		<label>'.$xml->DRP_CONTROL_HIPER->es.': '.$xml->DRP_CONTROL_HIPER->es->option[intval($psic['drp_control_hiper'])].'</label>	<br>
		<label>'.$xml->DRP_DIABETES_MELLITUS->es.': '.$xml->DRP_DIABETES_MELLITUS->es->option[intval($psic['drp_diabetes_mellitus'])].'</label>	<br>
		<label>'.$xml->DRP_CONTROL_DIAB->es.': '.$xml->DRP_CONTROL_DIAB->es->option[intval($psic['drp_control_diab'])].'</label>	<br>
		<label>'.$xml->DRP_PESOPESO->es.': '.$xml->DRP_PESOPESO->es->option[intval($psic['drp_pesopeso'])].'</label>	<br>
		<label>'.$xml->DRP_CLASIFICACION->es.': '.$xml->DRP_CLASIFICACION->es->option[intval($psic['drp_clasificacion'])].'</label>	<br>
		<label>'.$xml->DRP_ENFERMEDAD_RENAL->es.': '.$xml->DRP_ENFERMEDAD_RENAL->es->option[intval($psic['drp_enfermedad_renal'])].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XVII. BÚSQUEDA </legend>
		<label>'.$xml->DRP_CLASIFICACION_CARDIOVASCULAR->es.': '.$xml->DRP_CLASIFICACION_CARDIOVASCULAR->es->option[intval($psic['drp_clasificacion_cardiovascular'])].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XVIII. Paraclinicos</legend>
		<label>'.$xml->DRP_HEMOGRAMA->es.': '.$xml->DRP_HEMOGRAMA->es->option[intval($psic['drp_hemograma'])].'</label>	<br>
		<label>'.$xml->DRP_GLICEMIA_BASAL->es.': '.$xml->DRP_GLICEMIA_BASAL->es->option[intval($psic['drp_glicemia_basal'])].'</label>	<br>
		<label>'.$xml->DRP_HEMOGLOBINA_GLICOSADA->es.': '.$xml->DRP_HEMOGLOBINA_GLICOSADA->es->option[intval($psic['drp_hemoglobina_glicosada'])].'</label>	<br>
		<label>'.$xml->DRP_COLESTEROL_TOTAL->es.': '.$xml->DRP_COLESTEROL_TOTAL->es->option[intval($psic['drp_colesterol_total'])].'</label>	<br>
		<label>'.$xml->DRP_TRIGLICERIDOS->es.': '.$xml->DRP_TRIGLICERIDOS->es->option[intval($psic['drp_trigliceridos'])].'</label>	<br>
		<label>'.$xml->DRP_HDL->es.': '.$xml->DRP_HDL->es->option[intval($psic['drp_hdl'])].'</label>	<br>
		<label>'.$xml->DRP_LDL->es.': '.$xml->DRP_LDL->es->option[intval($psic['drp_ldl'])].'</label>	<br>
		<label>'.$xml->DRP_PARCIAL_ORINA->es.': '.$xml->DRP_PARCIAL_ORINA->es->option[intval($psic['drp_parcial_orina'])].'</label>	<br>
		<label>'.$xml->DRP_CREATININA_SERICA->es.': '.$xml->DRP_CREATININA_SERICA->es->option[intval($psic['drp_creatinina_serica'])].'</label>	<br>
		<label>'.$xml->DRP_MICROALBUMINURIA->es.': '.$xml->DRP_MICROALBUMINURIA->es->option[intval($psic['drp_microalbuminuria'])].'</label>	<br>
		<label>'.$xml->DRP_ELECTROCARDIOGRAMA->es.': '.$xml->DRP_ELECTROCARDIOGRAMA->es->option[intval($psic['drp_electrocardiograma'])].'</label>	<br>
		<label>'.$xml->DRP_OTROS->es.': '.$xml->DRP_OTROS->es->option[intval($psic['drp_otros'])].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION->es.': '.$psic['date_realizacion'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO->es.': '.$psic['date_resultado'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION1->es.': '.$psic['date_realizacion1'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO1->es.': '.$psic['date_resultado1'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION2->es.': '.$psic['date_realizacion2'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO2->es.': '.$psic['date_resultado2'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION13->es.': '.$psic['date_realizacion13'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO13->es.': '.$psic['date_resultado13'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION3->es.': '.$psic['date_realizacion3'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO3->es.': '.$psic['date_resultado3'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION4->es.': '.$psic['date_realizacion4'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO4->es.': '.$psic['date_resultado4'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION5->es.': '.$psic['date_realizacion5'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO5->es.': '.$psic['date_resultado5'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION6->es.': '.$psic['date_realizacion6'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO6->es.': '.$psic['date_resultado6'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION7->es.': '.$psic['date_realizacion7'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO7->es.': '.$psic['date_resultado7'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION8->es.': '.$psic['date_realizacion8'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO8->es.': '.$psic['date_resultado8'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION9->es.': '.$psic['date_realizacion9'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO9->es.': '.$psic['date_resultado9'].'</label>	<br>
		<label>'.$xml->DATE_REALIZACION10->es.': '.$psic['date_realizacion10'].'</label>	<br>
		<label>'.$xml->DATE_RESULTADO10->es.': '.$psic['date_resultado10'].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XIX. Tratamiento No farmacológico </legend>
		<label>'.$xml->AREA_EXPLICACION_ASPECTOS->es.': '.$psic['area_explicacion_aspectos'].'</label>	<br>
		<label>'.$xml->AREA_IDENTIFICACION_SIGNOS->es.': '.$psic['area_identificacion_signos'].'</label>	<br>
		<label>'.$xml->CHKG_PROMOCION_FACTORES->es.': '.$psic['chkg_promocion_factores'].'</label>	<br>
	</fieldset>
	<fieldset>
		<legend>XX. Valoración de otros servicios </legend>
		<label>'.$xml->TXT_CITA_CONTROL->es.': '.$psic['txt_cita_control'].'</label>	<br>
		<label>'.$xml->AREA_OBSERVACIONES_ENF_CRONICAS->es.': '.$psic['area_observaciones_enf_cronicas'].'</label>	<br>
		<label>'.$xml->CHKG_VALORACION_OTROS->es.': '.$psic['chkg_valoracion_otros'].'</label>	<br>
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