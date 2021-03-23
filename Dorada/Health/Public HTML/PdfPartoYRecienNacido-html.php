<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_atencion_parto_recien_nacido where caso =  '$caso'";
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

	
	if (file_exists('datosxml/PartoYRecienNacidoXml.xml')) {
    $xml = simplexml_load_file('datosxml/PartoYRecienNacidoXml.xml');

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
		<label>Atencion: Parto y Recien Nacido</label><br>	
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
		<legend>II. Consulta principal</legend>
		<label>Motivo de consulta: '.$psic['motivo_consulta'].'</label>	<br>
		<label>Enfermedad actual: '.$psic['enfermedad_actual'].'</label>	
	</fieldset>
	<br>
	<fieldset>
	    <legend>III. Informacion Madre</legend>
		<label>Peso: '.$psic['txt_peso_madre'].'</label>
		<label>Talla: '.$psic['txt_talla_madre'].'</label>
		<label>TA:'.$psic['txt_ta'].'</label><br>
		<label>FC:'.$psic['txt_fc'].'</label>
		<label>FR:'.$psic['txt_fr'].'</label><br>
		<label>T:'.$psic['txt_temp'].' °C</label>
		<label>Hemoclasificacion: '.$psic['txt_hemoclasif'].'</label><br>
		<label>Coombs'.$psic['txt_coombs'].'</label><br>
		<label>Fecha ultima menstruacion: '.$psic['date_ultima_me'].'</label><br>
		<label>Fecha probable de parto: '.$psic['date_probable_pa'].'</label><br>
		<label>Edad gestacional: '.$psic['txt_edad_gestacional'].'</label>
	</fieldset>
	<fieldset>
		<legend>IV. Antecedentes obstetricos </legend>
		<label># Gestaciones: '.$psic['txt_gestaciones'].'</label>
		<label># Partos: '.$psic['txt_partos'].'</label>
		<label># Cesareas: '.$psic['txt_cesareas'].'</label><br>
		<label># Abortos: '.$psic['txt_abortos'].'</label>
		<label># Espontaneos: '.$psic['txt_espontaneo'].'</label> <br>
		<label># Provocados: '.$psic['txt_provocado'].'</label>
		<label># Muerto en 1ra sem: '.$psic['txt_hijo_muerto'].'</label><br>
		<label># Hijos prematuros: '.$psic['txt_hijos_prematuros'].'</label>
		<label># Hijos <2500gr: '.$psic['txt_hijos_2500'].'</label> 
		<label># Hijos >4000gr: '.$psic['txt_hijos_4000'].'</label><br>
		<label># Malformados: '.$psic['txt_hijo_malformado'].'</label>
		<label># Hipertension: '.$xml->DRP_HIPERTENSION->es->option[intval($psic['drp_hipertension'])].'</label><br>
		<label># Preeclampsia: '.$xml->DRP_PREECLAMSIA->es->option[intval($psic['drp_preeclamsia'])].'</label><br>
		<label># Eclampsia: '.$xml->DRP_ECLAMPSIA->es->option[intval($psic['drp_eclampsia'])].'</label><br>
		<label># Fecha ultimo parto: '.$psic['date_ultimo_parto'].'</label><br>
		<label># Cirugia tracto reproductivo: '.$xml->DRP_CIR_TRACTO_REPRO->es->option[intval($psic['drp_cir_tracto_repro'])].'</label><br>
		<label># Otros antecedentes: '.$psic['area_otro_antecedente'].'</label>
	</fieldset>
	<fieldset>
		<legend>V. Verificacion de riesgo durante gestacion </legend>
		<label>Control prenatal?: '.$xml->DRP_ANTECE_CONTROLPRE->es->option[intval($psic['drp_antece_controlpre'])].'</label><br>
		<label>#: '.$psic['txt_controprena'].'</label><br>
		<label>Movimientos fetales?:'.$xml->DRP_MOVIMIENTO_FETAL->es->option[intval($psic['drp_movimiento_fetal'])].'</label><br>
		<label>Fiebre reciente?: '.$xml->DRP_FIEBRE_RECIEN->es->option[intval($psic['drp_fiebre_recien'])].'</label><br>
		<label>liquido vaginal?: '.$xml->DRP_SANGRE_VAGINA->es->option[intval($psic['drp_sangre_vagina'])].'</label><br>
		<label>Flujo vaginal?: '.$xml->DRP_FLUJO_VAGINAL->es->option[intval($psic['drp_flujo_vaginal'])].'</label><br>
		<label>Padece enfermedad?: '.$xml->DRP_PADECE_ENFERMEDAD->es->option[intval($psic['drp_padece_enfermedad'])].'</label><br>
		<label>cual?: '.$psic['txt_cual_enfermedad'].'</label> <br>
		<label>Recibe medicamento?: '.$xml->DRP_RECIBE_MEDICAMENTO->es->option[intval($psic['drp_recibe_medicamento'])].'</label><br>
		<label>Cual?: '.$psic['txt_cual_medicina'].'</label><br>
		<label>Cigarrilos?: '.$xml->DRP_CIGARRO->es->option[intval($psic['drp_cigarro'])].'</label><br>
		<label>Bebidas alcoholicas?: '.$xml->DRP_ALCOHOL->es->option[intval($psic['drp_alcohol'])].'</label> <br>
		<label>Cual?: '.$psic['txt_cual_alcohol'].'</label><br>
		<label>Drogas?: '.$xml->DRP_DROGAS->es->option[intval($psic['drp_drogas'])].'</label><br>
		<label>Cual?: '.$psic['txt_drogas'].'</label><br>
		<label>Ha sufrido violencia?: '.$xml->DRP_VIOLENCIA->es->option[intval($psic['drp_violencia'])].'</label><br>
		<label>Explique: '.$psic['area_explique_violencia'].'</label><br>
		<label>Inmunizacion toxoide tetanico?: '.$xml->DRP_INMUNIZACION_TETACINO->es->option[intval($psic['drp_inmunizacion_tetacino'])].'</label><br>
		<label>Dosis: '.$psic['txt_dosis_tetanico'].'</label><br>
		<label>Altura uterina'.$psic['txt_alt_uterina'].' Cm</label><br>
		<label>Presentacion anomala: '.$xml->DRP_PRESEN_ANOMALA->es->option[intval($psic['drp_presen_anomala'])].'</label><br>
		<label>No Correlacion con edad ges.: '.$psic['chk_corelacion_edad_gestacional'].'</label><br>
		<label>Embarazo multiple: '.$psic['chk_embara_mult'].'</label><br>
		<label>Palidez palmar: '.$xml->DRP_PALIDEZ_PAL->es->option[intval($psic['drp_palidez_pal'])].'</label><br>
		<label>Edema manos: '.$psic['chkg_manos_g'].'</label><br>
		<label>Edema cara: '.$psic['chkg_cara_g'].'</label><br>
		<label>Edema pies: '.$psic['chkg_pies_g'].'</label><br>
		<label>Convulsiones: '.$psic['chk_convulsiones'].'</label> <br>
		<label>Vision borrosa: '.$psic['chk_vis_borrosa'].'</label><br>
		<label>Perdida conciencia: '.$psic['chk_per_conciencia'].'</label><br>
		<label>Cefalea intensa: '.$psic['chk_cefalea'].'</label><br>
		<label>Signos ETS: '.$psic['chk_signo_ets'].'</label> 		<br>
		<label>Sangrado: '.$psic['chkg_sangrado'].'</label><br>
		<label>Inflamacion: '.$psic['chkg_inflamacion'].'</label><br>
		<label>Caries: '.$psic['chkg_caries'].'</label><br>
		<label>Halitosis: '.$psic['chkg_halitosis'].'</label><br>
		<label>Hto: '.$psic['txt_hto'].'</label><br>
		<label>Hb: '.$psic['txt_hb'].'</label><br>
		<label>Toxoplasma: '.$psic['txt_toxoplasma'].'</label><br>
		<label>VDRL 1: '.$psic['txt_vdrl1'].'</label><br>
		<label>VDRL 2: '.$psic['txt_vdrl2'].'</label>		<br>
		<label>VIH 1: '.$psic['txt_vih1'].'</label><br>
		<label>VIH 2: '.$psic['txt_vih2'].'</label><br>
		<label>Hepatitis B: '.$psic['txt_hepatitisb'].'</label>		<br>
		<label>Otro: '.$psic['txt_otro'].'</label> <br>
		<label>Ecografia: '.$psic['txt_ecografia'].'</label><br>
		<label>Tipo de embarazo:'.$xml->DRP_TIPO_EMBARAZO->es->option[intval($psic['drp_tipo_embarazo'])].'</label><br>
		<label>Observaciones: '.$psic['area_observaciones_gest'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VI. Verificacion de riesgo durante trabajo de parto </legend>
		<label>Contracciones?: '.$xml->DRP_CONTRACCIONES->es->option[intval($psic['drp_contracciones'])].'</label><br>
		<label>Hemorragia vaginal?: '.$xml->DRP_HEMORRAGIA_VAGINAL->es->option[intval($psic['drp_hemorragia_vaginal'])].'</label> <br>
		<label>Liquido vaginal?: '.$xml->DRP_LIQUIDO_VAGINA->es->option[intval($psic['drp_liquido_vagina'])].'</label><br>
		<label>Color: '.$psic['txt_liquido_vagcolo'].'</label><br>
		<label>Dolor cabeza severo: '.$xml->DRP_DOLOR_CABEZA_SEVERO->es->option[intval($psic['drp_dolor_cabeza_severo'])].'</label><br>
		<label>Vision borrosa?: '.$xml->DRP_VISION_BORROSA->es->option[intval($psic['drp_vision_borrosa'])].'</label><br>
		<label>Convulsiones?: '.$xml->DRP_CONVULSIONES_MADRE->es->option[intval($psic['drp_convulsiones_madre'])].'</label><br>
		<label>Contracciones en 10min: '.$psic['txt_contracciones'].'</label><br>
		<label>FC fetal: '.$psic['txt_fc_fetal'].' x minuto</label><br>
		<label>Dilatacion cervical: '.$psic['txt_dilatacion_cervical'].'</label><br>
		<label>Presentacion: '.$xml->DRP_PRESENTACION->es->option[intval($psic['drp_presentacion'])].'</label><br>
		<label>Otra cual: '.$psic['txt_otracual'].'</label><br>
		<label>Edema manos:'.$psic['chkg_manos'].'</label><br>
		<label>Edema cara: '.$psic['chkg_cara'].'</label><br>
		<label>Edema pies: '.$psic['chkg_pies'].'</label><br>
		<label>Hemorragia vaginal: '.$psic['chk_hemorragia_vaginal'].'</label><br>
		<label>Hto:'.$psic['txt_hto_parto'].'</label><br>
		<label>Hb:'.$psic['txt_hb_parto'].'</label><br>
		<label>Hepatitis B:'.$psic['txt_hepatitis_b'].'</label><br>
		<label>VDRL Antes parto: '.$psic['txt_vdrl_antesparto'].'</label> <br>
		<label>VIH: '.$psic['txt_vih_parto'].'</label><br>
		<label>Tipo de parto: '.$xml->DRP_PARTO_TIPO->es->option[intval($psic['drp_parto_tipo'])].'</label><br>
		<label>Observaciones: '.$psic['area_observaciones_parto'].'</label><br>		
	</fieldset>
	<fieldset>
		<legend>VII. Atencion recien nacido sala parto </legend>
		<label>Fecha nacimiento: '.$psic['fecha_nacimiento'].'</label> <br>
		<label>Hora nacimiento: '.$psic['txt_hora_nacimiento'].'</label><br>
		<label>Primer nombre: '.$psic['txt_name'].'</label><br>
		<label>Segundo nombre:'.$psic['txt_name2'].'</label><br>
		<label>Primer apellido:'.$psic['txt_apellido'].'</label><br>
		<label>Segundo apellido: '.$psic['txt_apellido2'].'</label> <br>
		<label>Sexo: '.$xml->DRP_SEXO_NACIDO->es->option[intval($psic['drp_sexo_nacido'])].'</label><br>
		<label>Peso: '.$psic['txt_peso_nacido'].'</label><br>
		<label>PC: '.$psic['txt_pc_nacido'].'</label><br>
		<label>FC: '.$psic['txt_fc_nacido'].'</label> <br>
		<label>T: '.$psic['txt_temp_nacido'].' °C</label><br>
		<label>Talla'.$psic['txt_talla_nacido'].'</label><br>
		<label>Edad gestacional'.$psic['txt_edad_gestacional1'].' Semanas</label><br>
		<label>Apgar 1min: '.$psic['txt_apgar_nacido'].'/10</label><br>
		<label>Apgar 5min: '.$psic['txt_apgar_nacido2'].'/10</label><br>
		<label>Apgar 10min: '.$psic['txt_apgar_nacido3'].'/10</label><br>
		<label>Apgar 20min: '.$psic['txt_apgar_nacido4'].'/10</label><br>
		<label>Estado recien nacido: '.$xml->DRP_ESTADO_NACIDO->es->option[intval($psic['drp_estado_nacido'])].'</label><br>
		<label>Observaciones: '.$psic['area_observaciones_nacido'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VIII. Verificacion de necesidad reanimacion </legend>
		<label>Prematuro: '.$psic['chkg_prematuro'].'</label><br>
		<label>Meconio: '.$psic['chkg_meconio'].'</label><br>
		<label>No respiracion/No Llanto: '.$psic['chkg_no_resp'].'</label><br>
		<label>Hipotonico: '.$psic['chkg_hipotonico'].'</label><br>
		<label>Apnea: '.$psic['chkg_apnea'].'</label><br>
		<label>Jadeo: '.$psic['chkg_jadeo'].'</label><br>
		<label>Respiracion dificultosa: '.$psic['chkg_resp_dificultosa'].'</label> <br>
		<label>Cianosis persistente: '.$psic['chkg_cianosis_persistente'].'</label><br>
		<label>Bradicardia: '.$psic['chkg_bradicardia'].'</label><br>
		<label>Palidez: '.$psic['chkg_palidez'].'</label><br>
		<label>Hipoxemia: '.$psic['chkg_hipoxemia'].'</label> <br>
		<legend> Reanimacion </legend><br>
		<label>Estimulacion: '.$psic['chkg_estimulacion'].'</label><br>
		<label>Ventilacion: '.$psic['chkg_ventilacion'].'</label><br>
		<label>Compresiones toraxicas: '.$psic['chkg_compresiones_toraxicas'].'</label><br>
		<label>Intubacion: '.$psic['chkg_intubacion'].'</label><br>
		<label>Medicamentos:'.$psic['chkg_medicamentos'].'</label><br>
		<label>Estado reanimacion: '.$xml->DRP_REANIMACION_CUIDADOSRUTI->es->option[intval($psic['drp_reanimacion_cuidadosruti'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>IX. Verificacion riesgo neonatal: primera valoracion RN </legend>
		<label>Ruptura prematura membranas: '.$xml->DRP_RUPTURA_MEMBRANAS_NACIDO->es->option[intval($psic['drp_ruptura_membranas_nacido'])].'</label><br>
		<label>Tiempo: '.$psic['txt_tiempo_nacido'].' horas</label><br>
		<label>Liquido: '.$psic['txt_liquido_nacido'].'</label><br>
		<label>Fiebre materna: '.$xml->DRP_FIEBRE_MATERNA->es->option[intval($psic['drp_fiebre_materna'])].'</label><br>
		<label>Tiempo: '.$psic['txt_tiempo_fiebre'].'</label><br>
		<label>Corioamnionitis: FC:'.$psic['txt_corioamnionitis'].' /min</label><br>
		<label>Infeccion Intrauterina: '.$xml->DRP_INFECCION_INTRAUTERINA->es->option[intval($psic['drp_infeccion_intrauterina'])].'</label><br>
		<label>Madre <20 años: '.$xml->DRP_MADRE_MENOR20->es->option[intval($psic['drp_madre_menor20'])].'</label><br>
		<legend>Historia de ingesta </legend><br>
		<label>Alcohol: '.$psic['chkg_alcohol'].'</label><br>
		<label>Cigarrillo: '.$psic['chkg_cigarrillo'].'</label> <br>
		<label>Drogas: '.$psic['chkg_drogas'].'</label><br>
		<label>Antecedente violencia/maltrato: '.$xml->DRP_ANTEC_VIOLENCIA->es->option[intval($psic['drp_antec_violencia'])].'</label><br>
		<label>Respiracion: '.$xml->DRP_RESPIRACION_NACIDO->es->option[intval($psic['drp_respiracion_nacido'])].'</label><br>
		<label>Llanto: '.$xml->DRP_LLANTO->es->option[intval($psic['drp_llanto'])].'</label> <br>
		<label>Vitalidad: '.$xml->DRP_VITALIDAD->es->option[intval($psic['drp_vitalidad'])].'</label><br>
		<label>Ritmo cardiaco:'.$xml->DRP_RITMO->es->option[intval($psic['drp_ritmo'])].'</label><br>
		<label>Palidez'.$psic['chkg_palidez1'].'</label><br>
		<label>Ictericia: '.$psic['chkg_ictericia'].'</label><br>
		<label>Pletora: '.$psic['chkg_pletora'].'</label><br>
		<label>Cianosis: '.$psic['chkg_cianosis'].'</label><br>
		<label>Ninguno: '.$psic['chkg_ninguno'].'</label><br>
		<label>Anomalias congenitas: '.$xml->DRP_ANOMALIAS_CONGEN->es->option[intval($psic['drp_anomalias_congen'])].'</label><br>
		<label>Cual: '.$psic['txt_anomalias_conge'].'</label><br>
		<label>Lesiones debidas al parto: '.$psic['txt_lesionespor_parto'].'</label><br>
		<label>Riesgo de parto: '.$xml->DRP_TIPO_PARTO->es->option[intval($psic['drp_tipo_parto'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>X. Observaciones complementarias </legend>
		<label>Completar examen fisico y evaluar otros problemas: '.$psic['area_completar_examen_nacido'].'</label><br>
		<label>Diagnostico: '.$psic['area_diagnostico_nacido'].'</label><br>
		<label>Cuando volver de inmediato al servicio(Signos alarma)'.$psic['area_volver_servicio'].'</label><br>
		<label>Cuando volver consulta de control: '.$psic['area_volver_control_nacido'].'</label><br>
		<label>Cuando volver consulta de niño sano: '.$psic['area_volver_consulta_sano'].'</label> <br>
		<label>Referido a consulta de: '.$psic['area_referido_consulta'].'</label><br>
		<label>Medidas preventivas especificas: '.$psic['area_medidas_especificas'].'</label><br>
		<label>Programa de crecimiento y desarrollo/vacunacion: '.$psic['area_crecimiento_desarrollo'].'</label><br>
		<label>Recomendaciones de buen trato: '.$psic['area_recomendaciones_buen_trato'].'</label> <br>
		<label>Otras recomendaciones: '.$psic['area_otras_recomendaciones'].'</label><br>
		<label>Tratar: '.$psic['area_tratar'].'</label><br> 
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