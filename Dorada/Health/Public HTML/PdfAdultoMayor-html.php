<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_atencion_adulto_mayor where caso =  '$caso'";
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

	
	if (file_exists('datosxml/AdultoMayorXml.xml')) {
    $xml = simplexml_load_file('datosxml/AdultoMayorXml.xml');

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
		<label>Atencion: Adulto Mayor</label><br>	
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
		<label>Enfermedad actual: '.$psic['enfermedad_actual'].'</label>	<br>
		<label>Mmotivo consulta acompañante: '.$psic['txt_motivo_consulta_acom'].'</label><br>
		<label>Observaciones relevantes: '.$psic['txt_observaciones_necesarias'].'</label><br>
	</fieldset>
	<br>
	<fieldset>
		<legend>III. Antecedentes personales</legend>
		<label>Enfermedades cronicas: '.$xml->DRP_ENF_CRONICAS->es->option[intval($psic['drp_enf_cronicas'])].'</label><br>
		<label>Enfermedades infecto-contagiosas: '.$xml->DRP_ENF_INFECTO->es->option[intval($psic['drp_enf_infecto'])].'</label><br>
		<label>Alergias: '.$xml->DRP_ALERGIAS->es->option[intval($psic['drp_alergias'])].'</label><br>
		<label>Intoxicaciones: '.$xml->DRP_INTOXICACIONES->es->option[intval($psic['drp_intoxicaciones'])].'</label><br>
		<label>Traumas: '.$xml->DRP_ENF_TRAUMAS->es->option[intval($psic['drp_enf_traumas'])].'</label><br>
		<label>Medicamentos: '.$xml->DRP_MEDICAMENTOS->es->option[intval($psic['drp_medicamentos'])].'</label><br>
		<label>Cirugia/Hospitalizacion: '.$xml->DRP_CIRUGIA_HOSPI->es->option[intval($psic['drp_cirugia_hospi'])].'</label><br>
		<label>Observaciones relevantes: '.$psic['txt_obs_relevantes_per'].'</label><br>
	</fieldset>	
	<fieldset>
		<legend>IV. Antecedentes familiares</legend>
		<label>Enfermedades metabolicas: '.$xml->DRP_ENF_METABOLICAS->es->option[intval($psic['drp_enf_metabolicas'])].'</label><br>
		<label>Enfermedades cronicas: '.$xml->DRP_ENF_CRONICAS1->es->option[intval($psic['drp_enf_cronicas1'])].'</label><br>
		<label>Enfermedades infecto-contagiosas: '.$xml->DRP_ENF_INFECTO1->es->option[intval($psic['drp_enf_infecto1'])].'</label><br>
		<label>Cancer: '.$xml->DRP_CANCER->es->option[intval($psic['drp_cancer'])].'</label><br>
		<label>Enfermedades cardiovasculares: '.$xml->DRP_ENF_CARDIOVASCULARES->es->option[intval($psic['drp_enf_cardiovasculares'])].'</label><br>
		<label>Hiperlipidemias: '.$xml->DRP_HIPERLIPIDEMIAS->es->option[intval($psic['drp_hiperlipidemias'])].'</label> <br>
		<label>Mentales: '.$xml->DRP_MENTALES->es->option[intval($psic['drp_mentales'])].'</label><br>
		<label>Observaciones relevantes: '.$psic['txt_obs_relevantes_fam'].'</label><br>
	</fieldset>	

	<fieldset>
		<legend>V. Familia</legend>
		<label>Convive con: </label>
		<label>Padres: '.$xml->DRP_PADRES->es->option[intval($psic['drp_padres'])].'</label><br>
		<label>Hermanos: '.$xml->DRP_HERMANOS->es->option[intval($psic['drp_hermanos'])].'</label> <br>
		<label>Pareja: '.$xml->DRP_PAREJA->es->option[intval($psic['drp_pareja'])].'</label><br>
		<label>Nietos: '.$xml->DRP_NIETOS->es->option[intval($psic['drp_nietos'])].'</label><br>
		<label>Solo: '.$xml->DRP_SOLO->es->option[intval($psic['drp_solo'])].'</label><br>
		<label>Vive en: '.$xml->DRP_CASA->es->option[intval($psic['drp_casa'])].'</label><br>
		<label>Diagrama familiar: '.$psic['txt_diagrama_familiar'].'</label><br>
	</fieldset>	

	<fieldset>
		<legend>VI. Vivienda</legend>
		<label>Energia electrica: '.$xml->DRP_ENERGIA->es->option[intval($psic['drp_energia'])].'</label><br>
		<label>Agua: '.$xml->DRP_AGUA->es->option[intval($psic['drp_agua'])].'</label><br>
		<label>Excretas: '.$xml->DRP_EXCRETAS->es->option[intval($psic['drp_excretas'])].'</label><br>
		<label>Basuras: '.$xml->DRP_BASURAS->es->option[intval($psic['drp_basuras'])].'</label><br>
		<label># Cuartos: '.$psic['txt_numero_cuartos'].'</label><br>
		<label># Personas/casa: '.$psic['txt_numero_personas_casa'].'</label><br>
	</fieldset>	

	<fieldset>
		<legend>VII. Educacion y vida social</legend>
		<label>Estudio: '.$xml->DRP_ESTUDIO->es->option[intval($psic['drp_estudio'])].'</label><br>
		<label>Nivel: '.$xml->DRP_NIVEL->es->option[intval($psic['drp_nivel'])].'</label><br>
		<label>Educacion no formal: '.$xml->DRP_ED_NO_FORMAL->es->option[intval($psic['drp_ed_no_formal'])].'</label><br>
		<label>Aceptacion: '.$xml->DRP_ACEPTACION->es->option[intval($psic['drp_aceptacion'])].'</label><br>
		<label>Pareja: '.$xml->DRP_PAREJA1->es->option[intval($psic['drp_pareja1'])].'</label> <br>
		<label>Amigos: '.$xml->DRP_AMIGOS->es->option[intval($psic['drp_amigos'])].'</label><br>
		<label>Actividad grupal: '.$xml->DRP_ACTIVIDAD_GRUPAL->es->option[intval($psic['drp_actividad_grupal'])].'</label><br>
		<label>Deportes: '.$psic['txt_deporte'].' horas/sem</label><br>
		<label>Tv: '.$psic['txt_tv'].' horas/sem</label> <br>
		<label>Otras actividades: '.$xml->DRP_OTRAS_ACTIVIDADES->es->option[intval($psic['drp_otras_actividades'])].'</label><br>
		<label>Cual: '.$psic['txt_cual'].'</label><br>
	</fieldset>	
	<fieldset>
		<legend>VIII. Trabajo</legend>
		<label>Actividad: '.$xml->DRP_ACTIVIDAD->es->option[intval($psic['drp_actividad'])].'</label><br>
		<label>Edad inicio trabajo: '.$psic['txt_edad_inicio_trabajo'].'</label><br>
		<label>Horas trabajo'.$psic['txt_edad_inicio_trabajo1'].' horas/sem</label><br>
		<label>Horario trabajo: '.$xml->DRP_HORARIO_TRABAJO->es->option[intval($psic['drp_horario_trabajo'])].'</label><br>
		<label>Razon trabajo: '.$xml->DRP_RAZON_TRABAJO->es->option[intval($psic['drp_razon_trabajo'])].'</label><br>
		<label>Trabajo legalizado: '.$xml->DRP_TRABAJO_LEGALIZADO->es->option[intval($psic['drp_trabajo_legalizado'])].'</label><br>
		<label>Trabajo insalubre: '.$xml->DRP_TRABAJO_INSALUBRE->es->option[intval($psic['drp_trabajo_insalubre'])].'</label><br>
	</fieldset>	
	<fieldset>
		<legend>IX. Habitos</legend>
		<label>Sueño normal: '.$xml->DRP_SUENO_NORMAL->es->option[intval($psic['drp_sueno_normal'])].'</label><br>
		<label>Horas sueño:'.$psic['txt_horas_sueno'].'</label><br>
		<label>Alimentacion adecuada: '.$xml->DRP_ALIMENTACION_ADECUADA->es->option[intval($psic['drp_alimentacion_adecuada'])].'</label><br>
		<label>Comidas/dia: '.$psic['txt_comidas_dia'].'</label><br>
		<label>Vaso agua/dia: '.$psic['txt_agua_dia'].'</label><br>
		<label>Base de la dieta: '.$xml->DRP_BASE_DE_DIETA->es->option[intval($psic['drp_base_de_dieta'])].'</label><br>
		<label>Tabaco: '.$xml->DRP_TABACO->es->option[intval($psic['drp_tabaco'])].'</label> <br>
		<label>cuantos: '.$psic['txt_tabaco'].' Cig/dias</label><br>
		<label>Alcohol: '.$xml->DRP_ALCOHOL->es->option[intval($psic['drp_alcohol'])].'</label><br>
		<label>Cuanto: '.$psic['txt_alcohol'].' Lt/cerveza</label><br>
		<label>Otro toxico: '.$xml->DRP_TOXICO->es->option[intval($psic['drp_toxico'])].'</label> <br>
		<label>Cual: '.$psic['txt_toxico'].'</label><br>
		<label>Conduce?: '.$xml->DRP_CONDUCE->es->option[intval($psic['drp_conduce'])].'</label><br>
		<label>Vehiculo: '.$psic['txt_vehiculo'].'</label><br>
	</fieldset>	
    <fieldset>
		<legend>X. Sexualidad</legend>
		<label>Relaxiones sexuales: '.$xml->DRP_RELACIONES->es->option[intval($psic['drp_relaciones'])].'</label><br>
		<label>Pareja: '.$xml->DRP_PAREJA2->es->option[intval($psic['drp_pareja2'])].'</label><br>
		<label>Problemas en relacion:'.$xml->DRP_PROBLEMAS_RELACION->es->option[intval($psic['drp_problemas_relacion'])].'</label><br>
		<label>Cual: '.$psic['txt_sexualidad_cual'].'</label><br>
		<label>Anticoncepcion: '.$xml->DRP_ANTICONCEPCION->es->option[intval($psic['drp_anticoncepcion'])].'</label><br>
		<label>Cual: '.$psic['txt_anticoncepcion_cual'].'</label><br>
		<label>Condon: '.$xml->DRP_CONDON->es->option[intval($psic['drp_condon'])].'</label><br>
		<label>Abuso sexual: '.$xml->DRP_ABUSO_SEXUAL->es->option[intval($psic['drp_abuso_sexual'])].'</label><br>
		<label>ETS: '.$xml->DRP_ETS->es->option[intval($psic['drp_ets'])].'</label><br>
		<label>Cual: '.$psic['txt_cual_ets'].'</label><br>
	</fieldset>	
	<fieldset>
		<legend>XI. Gineco-Urologico</legend>';
		if ($psic['date_ult_mens']=='1000-01-01') {
			 $codigoHTML.='
			<label>Fecha ultima menstruacion: NO APLICA</label><br>';
		}
	 $codigoHTML.='
		<label>Fecha ultima menstruacion: '.$psic['date_ult_mens'].'</label><br>
		<label>Ciclos: '.$xml->DRP_CICLOS->es->option[intval($psic['drp_ciclos'])].'</label><br>
		<label>Fecha menopausea: '.$psic['date_menopausea'].'</label> <br>
		<label>Flujos/secrecion vaginal/peneana: '.$xml->DRP_FLUJOS->es->option[intval($psic['drp_flujos'])].'</label><br>
		<label>Descripcion flujos: '.$psic['txt_descripcion_flujos'].'</label><br>
		<label>Formula gestacional: '.$psic['txt_formula_gestacional'].'</label><br>
		<label>G: '.$psic['txt_formula_gestacionalg'].'</label> <br>
		<label>P: '.$psic['txt_formula_gestacionalp'].'</label><br>
		<label>A: '.$psic['txt_formula_gestacionala'].'</label><br>
		<label>C: '.$psic['txt_formula_gestacionalc'].'</label><br>
		<label>M: '.$psic['txt_formula_gestacionalm'].'</label><br>
		<label>Fecha ult. citologia: '.$psic['date_ult_cit'].'</label><br>
		<label>Resultado citologia: '.$psic['chk_ultima_cit'].'</label><br>
		<label>Observacion r/ citologia: '.$psic['txt_resultado_cit'].'</label><br>
		<label>Fecha ult. examen seno: '.$psic['date_ult_seno'].'</label><br>
		<label>Resultado ex. seno: '.$psic['txt_resultado_ult_seno'].'</label><br>
		<label>Fecha ult. psa: '.$psic['date_ult_psa'].'</label><br>
		<label>Resultado psa: '.$psic['txt_resultado_ult_psa'].'</label><br>
	</fieldset>	
	<fieldset>
		<legend>XII. Examen fisico</legend>
		<label>Peso: '.$psic['txt_peso'].'</label><br>
		<label>IMC: '.$psic['txt_imc'].'</label><br>
		<label>TA: '.$psic['txt_ta'].'</label><br>
		<label>FC: '.$psic['txt_fc'].'</label><br>
		<label>FR: '.$psic['txt_fr'].'</label> <br>
		<label>T: '.$psic['txt_temp'].' °C</label><br>
		<label>Aspecto general: '.$xml->DRP_ASPECTO_GENERAL->es->option[intval($psic['drp_aspecto_general'])].'</label><br>
		<label>Piel y faneras: '.$xml->DRP_PIEL_FANERAS->es->option[intval($psic['drp_piel_faneras'])].'</label><br>
		<label>Cabeza: '.$xml->DRP_CABEZA->es->option[intval($psic['drp_cabeza'])].'</label> <br>
		<label>Agudeza visual: '.$xml->DRP_AGUDEZA_VISUAL->es->option[intval($psic['drp_agudeza_visual'])].'</label><br>
		<label>Agudeza auditiva: '.$xml->DRP_AGUDEZA_AUDITIVA->es->option[intval($psic['drp_agudeza_auditiva'])].'</label><br>
		<label>Boca y dientes: '.$xml->DRP_BOCA_DIENTES->es->option[intval($psic['drp_boca_dientes'])].'</label><br>
		<label>Cuello y tiroides: '.$xml->DRP_CUELLO_TIROIDES->es->option[intval($psic['drp_cuello_tiroides'])].'</label><br>
		<label>Torax: '.$xml->DRP_TORAX->es->option[intval($psic['drp_torax'])].'</label> <br>
		<label>Mamas: '.$xml->DRP_MAMAS->es->option[intval($psic['drp_mamas'])].'</label><br>
		<label>Cardiopulmonar: '.$xml->DRP_CARDIO_PULMONAR->es->option[intval($psic['drp_cardio_pulmonar'])].'</label><br>
		<label>Abdomen: '.$xml->DRP_ABDOMEN->es->option[intval($psic['drp_abdomen'])].'</label><br>
		<label>Genito Urinario: '.$xml->DRP_GENITO_URINARIO1->es->option[intval($psic['drp_genito_urinario1'])].'</label> <br>
		<label>Tacto vaginal/rectal: '.$xml->DRP_TACTO_VR->es->option[intval($psic['drp_tacto_vr'])].'</label><br>
		<label>Especuloscopia: '.$xml->DRP_ESPECULOSCOPIA->es->option[intval($psic['drp_especuloscopia'])].'</label><br>
		<label>Columna: '.$xml->DRP_COLUMNA->es->option[intval($psic['drp_columna'])].'</label><br>
		<label>Extremidades: '.$xml->DRP_EXTREMIDADES->es->option[intval($psic['drp_extremidades'])].'</label><br>
		<label>Neurologico: '.$xml->DRP_NEUROLOGICO->es->option[intval($psic['drp_neurologico'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XIII. Otras observaciones</legend>
		<label>Observaciones: '.$psic['txt_observaciones_adulto'].'</label><br>
		<label>Impresion diagnostica: '.$psic['txt_impresion_diagnos'].'</label><br>
		<label>Indicaciones: '.$psic['txt_indicaciones'].'</label><br>
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