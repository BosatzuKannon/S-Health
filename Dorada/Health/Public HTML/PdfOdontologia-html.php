<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_atencion_odontologia where caso =  '$caso'";
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

	
	if (file_exists('datosxml/OdontologiaXml.xml')) {
    $xml = simplexml_load_file('datosxml/OdontologiaXml.xml');

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
		<label>Atencion: Odontologia</label><br>	
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
		<label>Motivo de consulta: '.$psic['motivo_consulta'].'</label><br>	
		<label>Enfermedad actual: '.$psic['enfermedad_actual'].'</label>	
	</fieldset>
	<br>
	<fieldset>
		<legend>III. Antecedentes medicos y odontologicos </legend>
		<label>Tratamiento medico actual: '.$psic['amo_tma'].'</label><br>
		<label>Alergias: '.$psic['amo_ale'].'</label><br>
		<label>Alteracion presion arterial: '.$psic['amo_apa'].'</label><br>
		<label>Diabetes: '.$psic['amo_dia'].'</label><br>
		<label>Irradiaciones: '.$psic['amo_irr'].'</label><br>
		<label>Fiebre reumatica'.$psic['amo_fre'].'</label><br>
		<label>Inmunosuspencion: '.$psic['amo_inm'].'</label><br>
		<label>Patologia respiratoria: '.$psic['amo_pre'].'</label><br>
		<label>Epilepsia: '.$psic['amo_epi'].'</label><br>
		<label>Enfermedades orales: '.$psic['amo_eor'].'</label><br>
		<label>Toma medicamentos: '.$psic['amo_tme'].'</label><br>
		<label>Cardiopatias: '.$psic['amo_car'].'</label><br>
		<label>Embarazo: '.$psic['amo_emb'].'</label><br>
		<label>Hepatitis'.$psic['amo_hep'].'</label><br>
		<label>Discracias sanguineas: '.$psic['amo_dsa'].'</label><br>
		<label>Enfermedades renales: '.$psic['amo_ere'].'</label><br>
		<label>Trastornos emocionales: '.$psic['amo_tem'].'</label><br>
		<label>Trastornos gastricos: '.$psic['amo_tga'].'</label><br>
		<label>Cirugias(incluso orales)'.$psic['amo_cio'].'</label><br>
		<label>Otras alteraciones: '.$psic['amo_oat'].'</label><br>		
	</fieldset>
	<fieldset>
		<legend>IV. Antecedentes familiares </legend>
		<label>'.$psic['amo_afa'].'</label>
	</fieldset>
	<fieldset>
		<legend>V. Observaciones </legend>
		<label>'.$psic['amo_obs'].'</label>
	</fieldset>
	<fieldset>
		<legend>VI. Tejidos blandos </legend>
		<label>Labio superior: '.$xml->YN_LAB_SUP->es->option[intval($psic['tbl_lsu'])].'</label>
		<label>Obs: '.$psic['tbl_text_lsu'].'</label><br>

		<label>Labio inferior: '.$xml->YN_LAB_INF->es->option[intval($psic['tbl_lin'])].'</label>
		<label>Obs: '.$psic['tbl_text_lin'].'</label><br>

		<label>Comisuras: '.$xml->YN_COM->es->option[intval($psic['tbl_com'])].'</label>
		<label>Obs: '.$psic['tbl_text_com'].'</label><br>

		<label>Mucosa oral: '.$xml->YN_MUC_ORAL->es->option[intval($psic['tbl_mor'])].'</label>
		<label>Obs: '.$psic['tbl_text_mor'].'</label><br>

		<label>Sucros yugales: '.$xml->YN_SUC_YUG->es->option[intval($psic['tbl_syu'])].'</label>
		<label>Obs: '.$psic['tbl_text_syu'].'</label><br>

		<label>Frenillos'.$xml->YN_FREN->es->option[intval($psic['tbl_fre'])].'</label>
		<label>Obs: '.$psic['tbl_text_fre'].'</label><br>

		<label>Paladar: '.$xml->YN_PAL->es->option[intval($psic['tbl_pal'])].'</label>
		<label>Obs: '.$psic['tbl_text_pal'].'</label><br>

		<label>Orofaringe: '.$xml->YN_OROFA->es->option[intval($psic['tbl_oro'])].'</label>
		<label>Obs: '.$psic['tbl_text_oro'].'</label><br>

		<label>Lengua: '.$xml->YN_LENGUA->es->option[intval($psic['tbl_len'])].'</label>
		<label>Obs: '.$psic['tbl_text_len'].'</label><br>

		<label>Piso de bosa: '.$xml->YN_PISO_BOCA->es->option[intval($psic['tbl_pdb'])].'</label>
		<label>Obs: '.$psic['tbl_text_pdb'].'</label><br>

		<label>Rebordes: '.$xml->YN_REBORDE->es->option[intval($psic['tbl_reb'])].'</label>
		<label>Obs: '.$psic['tbl_text_reb'].'</label><br>

		<label>Glandulas salivales: '.$xml->YN_SALIVALES->es->option[intval($psic['tbl_gsa'])].'</label>
		<label>Obs: '.$psic['tbl_text_gsa'].'</label>	
	</fieldset>
	<fieldset>
		<legend>VII. ATM-oclusion </legend>
		<label>Dolor muscular: '.$psic['aoc_dmu'].'</label><br>
		<label>Dolor articular: '.$psic['aoc_dar'].'</label><br>
		<label>Ruido articular: '.$psic['aoc_rar'].'</label><br>
		<label>Alteracion movimiento: '.$psic['aoc_adm'].'</label><br>
		<label>Maloclusiones: '.$psic['aoc_mal'].'</label><br>
		<label>Crecimiento y desarrollo: '.$psic['aoc_cyd'].'</label>
	</fieldset>
	<fieldset>
		<legend>VIII. Tejidos dentales </legend>
		<label>Cambio forma: '.$xml->YN_CAM_FOR->es->option[intval($psic['tden_cfo'])].'</label>
		<label>Obs: '.$psic['tden_text_cfo'].'</label><br>

		<label>Cambio tamaño: '.$xml->YN_CAM_TAM->es->option[intval($psic['tden_cta'])].'</label>
		<label>Obs: '.$psic['tden_text_cta'].'</label><br>

		<label>Cambio numero: '.$xml->YN_CAM_NUM->es->option[intval($psic['tden_cnu'])].'</label>
		<label>Obs: '.$psic['tden_text_cnu'].'</label><br>
		
		<label>Cambio color: '.$xml->YN_CAM_COL->es->option[intval($psic['tden_cco'])].'</label>
		<label>Obs: '.$psic['tden_text_cco'].'</label><br>
		
		<label>Cambio posicion: '.$xml->YN_CAM_POS->es->option[intval($psic['tden_cpo'])].'</label>
		<label>Obs: '.$psic['tden_text_cpo'].'</label><br>
		
		<label>Impactados: '.$xml->YN_IMPAC->es->option[intval($psic['tden_imp'])].'</label>
		<label>Obs: '.$psic['tden_text_imp'].'</label>		
	</fieldset>
	<fieldset>
		<legend>VIX. Examen periododental </legend>
		<label>Sangrado: '.$psic['epe_san'].'</label><br>
		<label>Movilidad: '.$psic['epe_mov'].'</label><br>
		<label>Recesiones'.$psic['epe_rec'].'</label><br>
		<label>Bolsa periododental: '.$psic['epe_bpa'].'</label><br>
		<label>Calculos: '.$psic['epe_cal'].'</label><br>
		<label>Abcesos: '.$psic['epe_abc'].'</label><br>
		<label>Planca blanca: '.$psic['epe_pbl'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>X. Examen pulpar </legend>
		<label>Alteracion vitalidad:'.$psic['epu_avi'].'</label><br>
		<label>Dolor percusion: '.$psic['epu_dpe'].'</label><br>
		<label>Movilidad dental: '.$psic['epu_mde'].'</label><br>
		<label>Sensibilidad: '.$psic['epu_sen'].'</label><br>
		<label>Fistula: '.$psic['epu_fis'].'</label><br>
		<label>Diente tratado:'.$psic['epu_dtr'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XI. Habitos orales </legend>
		<label>Respirador oral: '.$psic['hor_ror'].'</label><br>
		<label>Succion digital: '.$psic['hor_sdi'].'</label><br>
		<label>Lengua proctatil: '.$psic['hor_lpr'].'</label><br>
		<label>Queislosfagia: '.$psic['hor_que'].'</label><br>
		<label>Fumador: '.$psic['hor_fum'].'</label><br>
		<label>Onicofagia: '.$psic['hor_oni'].'</label><br>
		<label>Otros hallazgos: '.$psic['hor_oha'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XII. Historia de accion preventiva </legend>
		<label>Charlas higiene oral?: '.$psic['hda_hrc'].'</label>
		<label>Obs: '.$psic['hda_text_hrc'].'</label><br>

		<label>Cepillado diario?: '.$psic['hda_pdc'].'</label>
		<label>Obs: '.$psic['hda_text_pdc'].'</label><br>

		<label>Seda dental?: '.$psic['hda_uls'].'</label>
		<label>Obs: '.$psic['hda_text_uls'].'</label><br>
		
		<label>Enjuague bucal?: '.$psic['hda_uee'].'</label>
		<label>Obs: '.$psic['hda_text_uee'].'</label><br>
		
		<label>Fluor?: '.$psic['hda_lhaf'].'</label>
		<label>Obs: '.$psic['hda_text_lhaf'].'</label><br>
		
		<label>Sellantes?: '.$psic['hda_lhas'].'</label>
		<label>Obs: '.$psic['hda_text_lhas'].'</label>	
	</fieldset>
	<fieldset>
		<legend>XIII. Observaciones </legend>
		<label>'.$psic['obs_obs'].'</label>
	</fieldset>
	<fieldset>
		<legend>XIV. Odontograma </legend>		
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