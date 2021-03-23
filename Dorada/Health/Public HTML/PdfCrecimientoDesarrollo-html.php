<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_crecimiento_desarrollo where caso =  '$caso'";
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

	
	if (file_exists('datosxml/CrecimientoDesarrolloXml.xml')) {
    $xml = simplexml_load_file('datosxml/CrecimientoDesarrolloXml.xml');

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
		<label>Atencion: Crecimiento y Desarrollo</label><br>	
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
		<legend>III. Antecedentes</legend>
		<label>'.($xml->AREA_ANTECEDENTES->es).': '.$psic['area_antecedentes'].'</label><br>
		<label>'.($xml->AREA_ANTECEDENTE_EMBARAZO->es).': '.$psic['area_antecedente_embarazo'].'</label><br>
		<label>'.($xml->AREA_COMO_FUE_PARTO->es).': '.$psic['area_como_fue_parto'].'</label><br>
		<label>'.($xml->AREA_PROBLEMA_NEONATAL->es).': '.$psic['area_problema_neonatal'].'</label><br>
		<label>'.($xml->AREA_ENFERMEDADES_HOSPI->es).': '.$psic['area_enfermedades_hospi'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>IV. Signos vitales</legend>
		<label>'.($xml->TXT_TEMP->es).': '.$psic['txt_temp'].'</label><br>
		<label>'.($xml->TXT_FC->es).': '.$psic['txt_fc'].'</label><br>
		<label>'.($xml->TXT_FR->es).': '.$psic['txt_fr'].'</label><br>
		<label>'.($xml->TXT_TALLA->es).': '.$psic['txt_talla'].'</label><br>
		<label>'.($xml->TXT_PESO->es).': '.$psic['txt_peso'].'</label><br>
		<label>'.($xml->TXT_PC->es).': '.$psic['txt_pc'].'</label><br>
		<label>'.($xml->TXT_IMC->es).': '.$psic['txt_imc'].'</label><br>
		<label>'.($xml->TXT_PESO_NACER->es).': '.$psic['txt_peso_nacer'].'</label><br>
	    <label>'.($xml->TXT_TALLA_NACER->es).': '.$psic['txt_talla_nacer'].'</label><br>	
	</fieldset>
	<fieldset>
		<legend>V. Signos de peligro general</legend>
		<label>'.($xml->CHK_BEBER_PECHO->es).': '.$psic['chk_beber_pecho'].'</label><br>
		<label>'.($xml->CHK_VOMITO->es).': '.$psic['chk_vomito'].'</label><br>
		<label>'.($xml->CHK_CONVULSIONES->es).': '.$psic['chk_convulsiones'].'</label><br>
		<label>'.($xml->CHK_LETARGICO->es).': '.$psic['chk_letargico'].'</label><br>
		<label>'.($xml->AREA_OBSERVACIONES_SIGNOS_PELIGRO->es).': '.$psic['area_observaciones_signos_peligro'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VI. Respiracion</legend>
		<label>'.($xml->TXT_TIRAJESUBCOSTAL->es).': '.$psic['txt_tirajesubcostal'].'</label><br>
		<label>'.($xml->TXT_TIRAJE_SUPRACLAVICUAR->es).': '.$psic['txt_tiraje_supraclavicuar'].'</label><br>
		<label>'.($xml->TXT_ESTRIDOR->es).': '.$psic['txt_estridor'].'</label><br>
		<label>'.($xml->TXT_SILIBANCIAS->es).': '.$psic['txt_silibancias'].'</label><br>
		<label>'.($xml->TXT_APNEA->es).': '.$psic['txt_apnea'].'</label><br>
		<label>'.($xml->TXT_INCAPACIDAD_BEBER->es).': '.$psic['txt_incapacidad_beber'].'</label><br>
		<label>'.($xml->TXT_SOMNOLIENTO->es).': '.$psic['txt_somnoliento'].'</label><br>
		<label>'.($xml->TXT_CONFUSO->es).': '.$psic['txt_confuso'].'</label><br>
		<label>'.($xml->TXT_AGITADO->es).': '.$psic['txt_agitado'].'</label><br>
		<label>'.($xml->CHKG_TIPO_RESPIRACION->es).': '.$psic['chkg_tipo_respiracion'].'</label><br>
		<label>'.($xml->AREA_CAMPO->es).': '.$psic['area_campo'].'</label><br>
		<label>'.($xml->DRP_TOS->es).': '.$xml->DRP_TOS->es->option[intval($psic['drp_tos'])].'</label><br>
	    <label>'.($xml->TXT_TOS_TIEMPO->es).': '.$psic['txt_tos_tiempo'].'</label><br>
        <label>'.($xml->DRP_SILIBANCIAS->es).': '.$xml->DRP_SILIBANCIAS->es->option[intval($psic['drp_silibancias'])].'</label><br>
	    <label>'.($xml->TXT_SILIBANCIAS_RE->es).': '.$psic['txt_silibancias_re'].'</label><br>
	    <label>'.($xml->TXT_RESPIRACION_MINUTO->es).': '.$psic['txt_respiracion_minuto'].'</label><br>	
	    <label>'.($xml->TXT_CUADRO_GRIPAL->es).': '.$psic['txt_cuadro_gripal'].'</label><br>
	    <label>'.($xml->TXT_ANTECEDEMTE_PREMA->es).': '.$psic['txt_antecedemte_prema'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VII. Estado de digestion</legend>
		<label>'.($xml->ANADIR_DIARREA->es).': '.$psic['anadir_diarrea'].'</label><br>
		<label>'.($xml->TXT_TIEMPO_DIARREA->es).': '.$psic['txt_tiempo_diarrea'].'</label><br>
		<label>'.($xml->DRP_SANGRE_HECES->es).': '.$xml->DRP_SANGRE_HECES->es->option[intval($psic['drp_sangre_heces'])].'</label><br>
		<label>'.($xml->DRP_VOMITO->es).': '.$xml->DRP_VOMITO->es->option[intval($psic['drp_vomito'])].'</label><br>
		<label>'.($xml->TXT_VOMITO->es).': '.$psic['txt_vomito'].'</label><br>
		<label>'.($xml->TXT_DIARREA24H->es).': '.$psic['txt_diarrea24h'].'</label><br>
		<label>'.($xml->TXT_DIARREA4H->es).': '.$psic['txt_diarrea4h'].'</label><br>
		<label>'.($xml->DRP_PLIEGUE_CUTANEO->es).': '.$xml->DRP_PLIEGUE_CUTANEO->es->option[intval($psic['drp_pliegue_cutaneo'])].'</label><br>
		<label>'.($xml->AREA_OBSERVACIONES_DIARREA->es).': '.$psic['area_observaciones_diarrea'].'</label><br>
		<label>'.($xml->CHK_DIAGNOSTICO_DIARREA->es).': '.$psic['chk_diagnostico_diarrea'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VIII. Fiebres</legend>
		<label>'.($xml->ANADIR_FIEBRE->es).': '.$psic['anadir_fiebre'].'</label><br>
		<label>'.($xml->TXT_TIEMPO_FIEBRE->es).': '.$psic['txt_tiempo_fiebre'].'</label><br>
		<label>'.($xml->ANADIR_FIEBRE_DIAS->es).': '.$psic['anadir_fiebre_dias'].'</label><br>
		<label>'.($xml->ANADIR_FIEBRE_38->es).': '.$psic['anadir_fiebre_38'].'</label><br>
		<label>'.($xml->ANADIR_FIEBRE_39->es).': '.$psic['anadir_fiebre_39'].'</label><br>
		<label>'.($xml->CHG_FIEBRE->es).': '.$psic['chg_fiebre'].'</label><br>
		<label>'.($xml->TXT_OBSERVACIONES->es).': '.$psic['txt_observaciones'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>IX. Vive o visito en los ultimos dias</legend>
		<label>'.($xml->ANADIR_DENGUE->es).': '.$psic['anadir_dengue'].'</label><br>
	    <label>'.($xml->DRP_MALARIA->es).': '.$xml->DRP_MALARIA->es->option[intval($psic['drp_malaria'])].'</label><br>
	    <label>'.($xml->TXT_DIURESIS->es).': '.$psic['txt_diuresis'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>X. Oido</legend>
		<label>'.($xml->ANADIR_OIDO->es).': '.$psic['anadir_oido'].'</label><br>
		<label>'.($xml->DRP_DOLOR_OIDO->es).': '.$xml->DRP_DOLOR_OIDO->es->option[intval($psic['drp_dolor_oido'])].'</label><br>
		<label>'.($xml->TXT_EPISODIOS_PREVIOS_OIDOS->es).': '.$psic['txt_episodios_previos_oidos'].'</label><br>
		<label>'.($xml->TXT_EPI_MESES->es).': '.$psic['txt_epi_meses'].'</label><br>
		<label>'.($xml->AREA_OIDO->es).': '.$psic['area_oido'].'</label><br>
		<label>'.($xml->DRP_TIPO->es).': '.$xml->DRP_TIPO->es->option[intval($psic['drp_tipo'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XI. Garganta</legend>
		<label>'.($xml->DRP_PROBLEMA_GARGANTA->es).': '.$xml->DRP_PROBLEMA_GARGANTA->es->option[intval($psic['drp_problema_garganta'])].'</label><br>
		<label>'.($xml->DRP_DOLORGARGANTA->es).': '.$xml->DRP_DOLORGARGANTA->es->option[intval($psic['drp_dolorgarganta'])].'</label><br>
		<label>'.($xml->DRP_TIPOGARGANTA->es).': '.$xml->DRP_TIPOGARGANTA->es->option[intval($psic['drp_tipogarganta'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XII. Evaluar desarrollo</legend>
		<label>'.($xml->AREA_ANTECEDENTE_DESARROLLO->es).': '.$psic['area_antecedente_desarrollo'].'</label><br>
		<label>'.($xml->AREA_FACTOR_RIESGO->es).': '.$psic['area_factor_riesgo'].'</label><br>
		<label>'.($xml->DRP_REALIZA_CONDICIONES->es).': '.$xml->DRP_REALIZA_CONDICIONES->es->option[intval($psic['drp_realiza_condiciones'])].'</label><br>
		<label>'.($xml->DRP_AUSENCIACONDICIONES->es).': '.$xml->DRP_AUSENCIACONDICIONES->es->option[intval($psic['drp_ausenciacondiciones'])].'</label><br>
		<label>'.($xml->DRP_AUSENCIA_CONDICIONESANT->es).': '.$xml->DRP_AUSENCIA_CONDICIONESANT->es->option[intval($psic['drp_ausencia_condicionesant'])].'</label><br>
		<label>'.($xml->AREA_PERI_CEFALICO->es).': '.$psic['area_peri_cefalico'].'</label><br>
		<label>'.($xml->TXT_ALTERACIONES_FENOTIPI->es).': '.$psic['txt_alteraciones_fenotipi'].'</label><br>
		<label>'.($xml->DRP_DIAGNOSTICO_MENTAL->es).': '.$xml->DRP_DIAGNOSTICO_MENTAL->es->option[intval($psic['drp_diagnostico_mental'])].'</label><br>
		<label>'.($xml->AREA_OBSERVACIONES_VACUNACION->es).': '.$psic['area_observaciones_vacunacion'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XIII. Verificar los antecedentes de vacunacion</legend>
		<label>'.($xml->CHK_BCG->es).': '.$psic['chk_bcg'].'</label><br>
		<label>'.($xml->CHKG_HEPATITISB->es).': '.$psic['chkg_hepatitisb'].'</label><br>
		<label>'.($xml->CHKG_VOP->es).': '.$psic['chkg_vop'].'</label><br>
		<label>'.($xml->CHKG_DPT->es).': '.$psic['chkg_dpt'].'</label><br>
		<label>'.($xml->CHKG_INFLUENZA->es).': '.$psic['chkg_influenza'].'</label><br>
		<label>'.($xml->CHHG_ROTAVIRUS->es).': '.$psic['chhg_rotavirus'].'</label><br>
		<label>'.($xml->CHKG_STREPTOCOCO->es).': '.$psic['chkg_streptococo'].'</label><br>
		<label>'.($xml->CHK_INFLUENZAU->es).': '.$psic['chk_influenzau'].'</label><br>
		<label>'.($xml->CHKG_SRP->es).': '.$psic['chkg_srp'].'</label><br>
		<label>'.($xml->TXT_FIEBRE_AMARILLA->es).': '.$psic['txt_fiebre_amarilla'].'</label><br>
		<label>'.($xml->AREA_VACUNAS_PEND->es).': '.$psic['area_vacunas_pend'].'</label><br>
		<label>'.($xml->AREA_PROXIMAS_VACU->es).': '.$psic['area_proximas_vacu'].'</label><br>
		<label>'.($xml->TXT_PROX_VACU->es).': '.$psic['txt_prox_vacu'].'</label><br>
		<label>'.($xml->AREA_OTRAS_VACUNAS->es).': '.$psic['area_otras_vacunas'].'</label><br>
		<label>'.($xml->AREA_COMPLETAR_EXFIS->es).': '.$psic['area_completar_exfis'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XIV. Evaluar la alimentacion de todos los niños <2 años y los clasificados como anemia y/o cualquiera de las alteraciones de crecimiento</legend>
		<label>'.($xml->TXT_RECIBE_LECHE->es).': '.$psic['txt_recibe_leche'].'</label><br>
		<label>'.($xml->TXT_LECH_MAT_24->es).': '.$psic['txt_lech_mat_24'].'</label><br>
		<label>'.($xml->TXT_PECHO_NOCHE->es).': '.$psic['txt_pecho_noche'].'</label><br>
		<label>'.($xml->TXT_EXTRAE_LECH->es).': '.$psic['txt_extrae_lech'].'</label><br>
		<label>'.($xml->TXT_ADMIN_LECHE->es).': '.$psic['txt_admin_leche'].'</label><br>
		<label>'.($xml->TXT_RECIBE_LECHE_AJENA->es).': '.$psic['txt_recibe_leche_ajena'].'</label><br>
		<label>'.($xml->TXT_CUALES_ALIMENTOS->es).': '.$psic['txt_cuales_alimentos'].'</label><br>
		<label>'.($xml->TXT_CUANTAS_VECES->es).': '.$psic['txt_cuantas_veces'].'</label><br>
		<label>'.($xml->TXT_CON_QUE->es).': '.$psic['txt_con_que'].'</label><br>
		<label>'.($xml->TXT_QUIEN_LE_DA->es).': '.$psic['txt_quien_le_da'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XV. El niño mayor de 6 meses recibe</legend>
		<label>'.($xml->TXT_COMIDAS_AYER->es).': '.$psic['txt_comidas_ayer'].'</label><br>
		<label>'.($xml->TXT_TAMANO_COMIDA_AYER->es).': '.$psic['txt_tamano_comida_ayer'].'</label><br>
		<label>'.($xml->TXT_COMIDA_ESPESA->es).': '.$psic['txt_comida_espesa'].'</label><br>
		<label>'.($xml->CHKG_ORIGEN_ANIMAL->es).': '.$psic['chkg_origen_animal'].'</label><br>
		<label>'.($xml->TXT_LACTEOS_AYER->es).': '.$psic['txt_lacteos_ayer'].'</label><br>
		<label>'.($xml->TXT_LEGUMBRES->es).': '.$psic['txt_legumbres'].'</label><br>
		<label>'.($xml->TXT_VEGETALES_ROJOS->es).': '.$psic['txt_vegetales_rojos'].'</label><br>
		<label>'.($xml->TXT_ACEITE->es).': '.$psic['txt_aceite'].'</label><br>
		<label>'.($xml->TXT_QUIEN_COMIDA_NINO->es).': '.$psic['txt_quien_comida_nino'].'</label><br>
		<label>'.($xml->TXT_PLATO_NINO->es).': '.$psic['txt_plato_nino'].'</label><br>
		<label>'.($xml->TXT_SUPLEMENTO_NINO->es).': '.$psic['txt_suplemento_nino'].'</label><br>
		<label>'.($xml->TXT_SI_ESTA_ENFERMO->es).': '.$psic['txt_si_esta_enfermo'].'</label><br>
		<label>'.($xml->TXT_FAMILIA_OBESA->es).': '.$psic['txt_familia_obesa'].'</label><br>
		<label>'.($xml->TXT_NINO_EJERCICIO->es).': '.$psic['txt_nino_ejercicio'].'</label><br>
		<label>'.($xml->TXT_PROGRAMA_NUTRICIONAL->es).': '.$psic['txt_programa_nutricional'].'</label><br>
		<label>'.($xml->AREA_PROBLEMA_DETECTADO->es).': '.$psic['area_problema_detectado'].'</label><br>
		<label>'.($xml->AREA_RECOMENDACIONES->es).': '.$psic['area_recomendaciones'].'</label><br>
		<label>'.($xml->AREA_OBSERVACIONES_ENFERMEDADES->es).': '.$psic['area_observaciones_enfermedades'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XVI. Salud bucal </legend>
		<label>'.($xml->DRP_DOLOR_MASTICAR->es).': '.$xml->DRP_DOLOR_MASTICAR->es->option[intval($psic['drp_dolor_masticar'])].'</label><br>
		<label>'.($xml->DRP_DOLOR_DIENTE->es).': '.$xml->DRP_DOLOR_DIENTE->es->option[intval($psic['drp_dolor_diente'])].'</label><br>
		<label>'.($xml->DRP_TRAUMA_BOCARA->es).': '.$xml->DRP_TRAUMA_BOCARA->es->option[intval($psic['drp_trauma_bocara'])].'</label><br>
		<label>'.($xml->DRP_FAMILIA_CARIES->es).': '.$xml->DRP_FAMILIA_CARIES->es->option[intval($psic['drp_familia_caries'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XVII. Limpieza boca</legend>
		<label>'.($xml->DRP_LIMPIA_BOCAAM->es).': '.$xml->DRP_LIMPIA_BOCAAM->es->option[intval($psic['drp_limpia_bocaam'])].'</label><br>
		<label>'.($xml->DRP_LIMPIA_BOCAM->es).': '.$xml->DRP_LIMPIA_BOCAM->es->option[intval($psic['drp_limpia_bocam'])].'</label><br>
		<label>'.($xml->DRP_LIMPIABOCAAP->es).': '.$xml->DRP_LIMPIABOCAAP->es->option[intval($psic['drp_limpiabocaap'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XVIII. Como supervisa la limpieza?</legend>
		<label>'.($xml->DRP_LIMPIA_DIENTES->es).': '.$xml->DRP_LIMPIA_DIENTES->es->option[intval($psic['drp_limpia_dientes'])].'</label><br>
	    <label>'.($xml->DRP_LIMPIA_SOLO->es).': '.$xml->DRP_LIMPIA_SOLO->es->option[intval($psic['drp_limpia_solo'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XIX. Que utiliza?</legend>
		<label>'.($xml->DRP_CEPILLO->es).': '.$xml->DRP_CEPILLO->es->option[intval($psic['drp_cepillo'])].'</label><br>
		<label>'.($xml->DRP_CREMA->es).': '.$xml->DRP_CREMA->es->option[intval($psic['drp_crema'])].'</label><br>
		<label>'.($xml->DRP_SEDA_DENTAL->es).': '.$xml->DRP_SEDA_DENTAL->es->option[intval($psic['drp_seda_dental'])].'</label><br>
		<label>'.($xml->DRP_CHUPON->es).': '.$xml->DRP_CHUPON->es->option[intval($psic['drp_chupon'])].'</label><br>
		<label>'.($xml->DRP_CONSUL_ODONTOLOGIA->es).': '.$xml->DRP_CONSUL_ODONTOLOGIA->es->option[intval($psic['drp_consul_odontologia'])].'</label><br>
		<label>'.($xml->TXT_INFLAMACION_LABIO->es).': '.$psic['txt_inflamacion_labio'].'</label><br>
		<label>'.($xml->TXT_SURCO->es).': '.$psic['txt_surco'].'</label><br>
		<label>'.($xml->TXT_ENROJECIMIENTO->es).': '.$psic['txt_enrojecimiento'].'</label><br>
		<label>'.($xml->TXT_INFLAMACION_ENCIA->es).': '.$psic['txt_inflamacion_encia'].'</label><br>
		<label>'.($xml->TXT_LOCALIZADO->es).': '.$psic['txt_localizado'].'</label><br>
		<label>'.($xml->TXT_GENERALIZADO->es).': '.$psic['txt_generalizado'].'</label><br>
		<label>'.($xml->TXT_DEFORMACION_ENCIA->es).': '.$psic['txt_deformacion_encia'].'</label><br>
		<label>'.($xml->TXT_EXUDADO->es).': '.$psic['txt_exudado'].'</label><br>
		<label>'.($xml->TXT_VESICULAS->es).': '.$psic['txt_vesiculas'].'</label><br>
		<label>'.($xml->DRP_PLACAS->es).': '.$xml->DRP_PLACAS->es->option[intval($psic['drp_placas'])].'</label><br>
		<label>'.($xml->TXT_FRACTURA_BUCAL->es).': '.$psic['txt_fractura_bucal'].'</label><br>
		<label>'.($xml->TXT_MOVILIDAD_BUCAL->es).': '.$psic['txt_movilidad_bucal'].'</label><br>
		<label>'.($xml->TXT_DESPLAZAMIENTO_BUCAL->es).': '.$psic['txt_desplazamiento_bucal'].'</label><br>
		<label>'.($xml->TXT_EXTRUSION->es).': '.$psic['txt_extrusion'].'</label><br>
		<label>'.($xml->DRP_HERIDA_BUCAL->es).': '.$xml->DRP_HERIDA_BUCAL->es->option[intval($psic['drp_herida_bucal'])].'</label><br>
		<label>'.($xml->DRP_TIPO_BUCAL->es).': '.$xml->DRP_TIPO_BUCAL->es->option[intval($psic['drp_tipo_bucal'])].'</label><br>
		<label>'.($xml->AREA_OBSERVACIONES_ODONTOLOGIA->es).': '.$psic['area_observaciones_odontologia'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XX. Verificacion de peso</legend>
		<label>'.($xml->DRP_EMACIACION->es).': '.$xml->DRP_EMACIACION->es->option[intval($psic['drp_emaciacion'])].'</label><br>
		<label>'.($xml->DRP_EDEMA_PIES->es).': '.$xml->DRP_EDEMA_PIES->es->option[intval($psic['drp_edema_pies'])].'</label><br>
		<label>'.($xml->TXT_APARIENCIA->es).': '.$psic['txt_apariencia'].'</label><br>
		<label>'.($xml->TXT_IMCEDAD->es).': '.$psic['txt_imcedad'].'</label><br>
		<label>'.($xml->TXT_DE->es).': '.$psic['txt_de'].'</label><br>
		<label>'.($xml->TXT_PESO_EDAD->es).': '.$psic['txt_peso_edad'].'</label><br>
		<label>'.($xml->TXT_TALLA_EDAD->es).': '.$psic['txt_talla_edad'].'</label><br>
		<label>'.($xml->TXT_PES_TALLA->es).': '.$psic['txt_pes_talla'].'</label><br>
		<label>'.($xml->DRP_CRECIMIENTO_PESO->es).': '.$xml->DRP_CRECIMIENTO_PESO->es->option[intval($psic['drp_crecimiento_peso'])].'</label><br>
		<label>'.($xml->AREA_OBSERVACIONES_CRECIMIENTO->es).': '.$psic['area_observaciones_crecimiento'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XXI. Verificar si tiene anemia?</legend>
		<label>'.($xml->TXT_HIERRO->es).': '.$psic['txt_hierro'].'</label><br>
		<label>'.($xml->TXT_HIERROCUANDO->es).': '.$psic['txt_hierrocuando'].'</label><br>
		<label>'.($xml->TXT_HIERROCUANTO->es).': '.$psic['txt_hierrocuanto'].'</label><br>
		<label>'.($xml->DRP_ANEMIATIPO->es).': '.$xml->DRP_ANEMIATIPO->es->option[intval($psic['drp_anemiatipo'])].'</label><br>
		<label>'.($xml->AREA_OBSERVACIONES_ANEMIA->es).': '.$psic['area_observaciones_anemia'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XXII. Verificacion de maltrato</legend>
		<label>'.($xml->TXT_COMO_LESIONES->es).': '.$psic['txt_como_lesiones'].'</label><br>
		<label>'.($xml->DRP_MALTRATO_RELATO->es).': '.$xml->DRP_MALTRATO_RELATO->es->option[intval($psic['drp_maltrato_relato'])].'</label><br>
		<label>'.($xml->DRP_MALTRATO->es).': '.$xml->DRP_MALTRATO->es->option[intval($psic['drp_maltrato'])].'</label><br>
		<label>'.($xml->TXT_QUIEN_MALTRATO->es).': '.$psic['txt_quien_maltrato'].'</label><br>
		<label>'.($xml->DRP_INCONGRUENCIA->es).': '.$xml->DRP_INCONGRUENCIA->es->option[intval($psic['drp_incongruencia'])].'</label><br>
		<label>'.($xml->DRP_DIF_VERSIONES->es).': '.$xml->DRP_DIF_VERSIONES->es->option[intval($psic['drp_dif_versiones'])].'</label><br>
		<label>'.($xml->DRP_TARDIA_CONSULTA->es).': '.$xml->DRP_TARDIA_CONSULTA->es->option[intval($psic['drp_tardia_consulta'])].'</label><br>
		<label>'.($xml->TXT_FRECUENCIA_PEGAR->es).': '.$psic['txt_frecuencia_pegar'].'</label><br>
		<label>'.($xml->TXT_DESOBEDIENTE_PEGAR->es).': '.$psic['txt_desobediente_pegar'].'</label><br>
		<label>'.($xml->CHKG_COMPORT_ANORMAL->es).': '.$psic['chkg_comport_anormal'].'</label><br>
		<label>'.($xml->DRP_DESCUIDO_NINO->es).': '.$xml->DRP_DESCUIDO_NINO->es->option[intval($psic['drp_descuido_nino'])].'</label><br>
		<label>'.($xml->AREA_DESCUIDADO_NINO->es).': '.$psic['area_descuidado_nino'].'</label><br>
		<label>'.($xml->CHG_HIGIENE_NINO->es).': '.$psic['chg_higiene_nino'].'</label><br>
		<label>'.($xml->DRP_ACTITUD_ANORMAL->es).': '.$xml->DRP_ACTITUD_ANORMAL->es->option[intval($psic['drp_actitud_anormal'])].'</label><br>
		<label>'.($xml->CHKG_ACTITUD_ANORMAL->es).': '.$psic['chkg_actitud_anormal'].'</label><br>
		<label>'.($xml->DRP_LESIONES_CRANEO->es).': '.$xml->DRP_LESIONES_CRANEO->es->option[intval($psic['drp_lesiones_craneo'])].'</label><br>
		<label>'.($xml->DRP_QUEMADURA_MALTRATO->es).': '.$xml->DRP_QUEMADURA_MALTRATO->es->option[intval($psic['drp_quemadura_maltrato'])].'</label><br>
		<label>'.($xml->DRP_DAOSNINO->es).': '.$xml->DRP_DAOSNINO->es->option[intval($psic['drp_daosnino'])].'</label><br>
		<label>'.($xml->DRP_FRACTURAS->es).': '.$xml->DRP_FRACTURAS->es->option[intval($psic['drp_fracturas'])].'</label><br>
		<label>'.($xml->TXT_LESION_SUGESTIVA->es).': '.$psic['txt_lesion_sugestiva'].'</label><br>
		<label>'.($xml->CHKG_TRAUMA_GENITAL->es).': '.$psic['chkg_trauma_genital'].'</label><br>
		<label>'.($xml->AREA_ENFERMEDADESTRANSMISION->es).': '.$psic['area_enfermedadestransmision'].'</label><br>
		<label>'.($xml->DRP_MALTRATO_DIAGNOSTICO->es).': '.$xml->DRP_MALTRATO_DIAGNOSTICO->es->option[intval($psic['drp_maltrato_diagnostico'])].'</label><br>
		<label>'.($xml->AREA_OBSERVACIONES_MALTRATO->es).': '.$psic['area_observaciones_maltrato'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XXIII. Diagnostico</legend>
		<label>'.($xml->AREA_SIGNOS_ALARMA->es).': '.$psic['area_signos_alarma'].'</label><br>
		<label>'.($xml->AREA_VOLVER_CONSULTA->es).': '.$psic['area_volver_consulta'].'</label><br>
		<label>'.($xml->AREA_CONSULTA_NINO->es).': '.$psic['area_consulta_nino'].'</label><br>
		<label>'.($xml->AREA_REFERIDO_CONSULTA->es).': '.$psic['area_referido_consulta'].'</label><br>
		<label>'.($xml->AREA_RECOMENDACION_DESARR->es).': '.$psic['area_recomendacion_desarr'].'</label><br>
		<label>'.($xml->AREA_RECO_BUEN_TRATO->es).': '.$psic['area_reco_buen_trato'].'</label><br>
		<label>'.($xml->DRP_VITAMINA->es).': '.$xml->DRP_VITAMINA->es->option[intval($psic['drp_vitamina'])].'</label><br>
		<label>'.($xml->TXT_PROXIMA_DOSIS->es).': '.$psic['txt_proxima_dosis'].'</label><br>
		<label>'.($xml->DRP_ALBENDAZOL->es).': '.$xml->DRP_ALBENDAZOL->es->option[intval($psic['drp_albendazol'])].'</label><br>
		<label>'.($xml->TXT_PROXIMA_DOSIS1->es).': '.$psic['txt_proxima_dosis1'].'</label><br>
		<label>'.($xml->DRP_HIERRO->es).': '.$xml->DRP_HIERRO->es->option[intval($psic['drp_hierro'])].'</label><br>
		<label>'.($xml->TXT_CUANDO_HIERRO->es).': '.$psic['txt_cuando_hierro'].'</label><br>
		<label>'.($xml->TXT_PROXIMA_DOSIS2->es).': '.$psic['txt_proxima_dosis2'].'</label><br>
		<label>'.($xml->DRP_ZINC->es).': '.$xml->DRP_ZINC->es->option[intval($psic['drp_zinc'])].'</label><br>
		<label>'.($xml->TXT_TIEMPO_DOSIS_ZINC->es).': '.$psic['txt_tiempo_dosis_zinc'].'</label><br>
		<label>'.($xml->TXT_INICIA_ZINC->es).': '.$psic['txt_inicia_zinc'].'</label><br>
		<label>'.($xml->AREA_TRATAMIENTO->es).': '.$psic['area_tratamiento'].'</label><br>
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