<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_atencion_adulto_joven where caso =  '$caso'";
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

	
	if (file_exists('datosxml/AdultoJovenXml.xml')) {
    $xml = simplexml_load_file('datosxml/AdultoJovenXml.xml');

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
	<div id="cab"></div><br>
	<fieldset>
		<legend>I. Datos Personales </legend>
		<label>No. Historia: '.$ced.'</label>
		<label>Fecha Cita: '.$cita['fecha_cita'].'</label>	
		<label>Atencion: Adulto Joven</label><br>	
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
		<label>Enfermedad actual: '.$psic['enfermedad_actual'].'</label><br>
		<label>Acompañante: '.$xml->DRP_ACOMPANANTE->es->option[intval($psic['drp_acompanante'])].'</label><br>
		<label>Estado civil Acomp: '.$xml->DRP_ESTADO_CIVIL->es->option[intval($psic['drp_estado_civil'])].'</label><br>
		<label>Motivo de consulta segun acomp: '.$psic['txt_area_motivo_consulta_acom'].'</label><br>
		<label>Observaciones necesarias: '.$psic['txt_area_observaciones_necesarias'].'</label>	<br>
	</fieldset>
	<br>
	<fieldset>
		<legend>III. Antecedentes personales</legend>
	    <label>Perinatales normales: '.$xml->DRP_PERINATALES_NORMALES->es->option[intval($psic['drp_perinatales_normales'])].'</label><br>
		<label>Crecimiento normal: '.$xml->DRP_CRECIMIENTO_NORMAL->es->option[intval($psic['drp_crecimiento_normal'])].'</label><br>
		<label>Desarrollo normal: '.$xml->DRP_DESARROLLO_NORMAL->es->option[intval($psic['drp_desarrollo_normal'])].'</label><br>
		<label>Vacunas completas: '.$xml->DRP_VACUNAS_COMPLETAS->es->option[intval($psic['drp_vacunas_completas'])].'</label><br>
		<label>Enfermedades cronicas: '.$xml->DRP_ENFERMEDADES_CRONICAS->es->option[intval($psic['drp_enfermedades_cronicas'])].'</label><br>
		<label>Enfermedades infecto-contagiosas: '.$xml->DRP_ENFERMEDADES_INFECTOCONTAGIOSAS->es->option[intval($psic['drp_enfermedades_infectocontagiosas'])].'</label><br>
		<label>Accidentes/intoxicacion: '.$xml->DRP_ACCIDENTES->es->option[intval($psic['drp_accidentes'])].'</label><br>
		<label>Cirugia/hospitalizacion: '.$xml->DRP_CIRUGIA_HOSPITALIZACION->es->option[intval($psic['drp_cirugia_hospitalizacion'])].'</label><br>
		<label>Uso medicina/sustancias: '.$xml->DRP_USO_MEDICINAS->es->option[intval($psic['drp_uso_medicinas'])].'</label><br>
		<label>Transtornos psicologicos: '.$xml->DRP_TRASTORNO_PSICOLOGICOS->es->option[intval($psic['drp_trastorno_psicologicos'])].'</label><br>
		<label>Maltrato: '.$xml->DRP_MALTRATO->es->option[intval($psic['drp_maltrato'])].'</label><br>
		<label>Judiciales: '.$xml->DRP_JUDICIALES->es->option[intval($psic['drp_judiciales'])].'</label> <br>
		<label>Otro: '.$xml->DRP_OTROS->es->option[intval($psic['drp_otros'])].'</label><br>
		<label>Observaciones: '.$psic['txt_area_observaciones_10a29'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>IV. Antecedentes familiares</legend>
		<label>Diabetes: '.$xml->DRP_DIABETES->es->option[intval($psic['drp_diabetes'])].'</label><br>
		<label>Obesidad: '.$xml->DRP_OBESIDAD->es->option[intval($psic['drp_obesidad'])].'</label> <br>
		<label>Cardiovascular: '.$xml->DRP_CARDIOVASCULAR->es->option[intval($psic['drp_cardiovascular'])].'</label><br>
		<label>Alergias: '.$xml->DRP_ALERGIAS->es->option[intval($psic['drp_alergias'])].'</label><br>
		<label>Infecciones(TBC/VIH)'.$xml->DRP_INFECCIONES_VARIAS->es->option[intval($psic['drp_infecciones_varias'])].'</label><br>
		<label>Transtornos psicologicos: '.$xml->DRO_TRASTORNOS_PSICOLOGICOS->es->option[intval($psic['dro_trastornos_psicologicos'])].'</label><br>
		<label>Alcohol/drogas: '.$xml->DRP_ALCOHOL_DROGAS->es->option[intval($psic['drp_alcohol_drogas'])].'</label><br>
		<label>Violencia intrafamiliar: '.$xml->DRP_VIOLENCIA_INTRAFAMILIAR->es->option[intval($psic['drp_violencia_intrafamiliar'])].'</label><br>
		<label>Madre adolescente: '.$xml->DRP_MADRE_ADOLESCENTE->es->option[intval($psic['drp_madre_adolescente'])].'</label><br>
		<label>Judiciales: '.$xml->DRP_JUDICIALES_FAMILIARES->es->option[intval($psic['drp_judiciales_familiares'])].'</label><br>
		<label>Otros: '.$xml->DRP_OTROS_FAMILIARES->es->option[intval($psic['drp_otros_familiares'])].'</label><br>
		<label>Observaciones: '.$psic['txt_area_observaciones_familiares'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>V. Familia: convive con</legend>
		<label>Madre: '.$xml->DRP_MADRE_CONVIVE->es->option[intval($psic['drp_madre_convive'])].'</label><br>
		<label>Padre: '.$xml->DRP_PADRE_CONVIVE->es->option[intval($psic['drp_padre_convive'])].'</label><br>
		<label>Madrastra: '.$xml->DRP_MADRASTRA_CONVIVE->es->option[intval($psic['drp_madrastra_convive'])].'</label><br>
		<label>Padrastro: '.$xml->DRP_PADRASTRO_CONVIVE->es->option[intval($psic['drp_padrastro_convive'])].'</label><br>
		<label>Hermanos: '.$xml->DRP_HERMANOS->es->option[intval($psic['drp_hermanos'])].'</label><br>
		<label>Pareja: '.$xml->DRP_PAREJA->es->option[intval($psic['drp_pareja'])].'</label> <br>
		<label>Hijo: '.$xml->DRP_HIJO->es->option[intval($psic['drp_hijo'])].'</label><br>
		<label>Otros: '.$xml->DRP_OTROS_CONVIVEN->es->option[intval($psic['drp_otros_conviven'])].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VI. Familia: nivel de instruccion</legend>
		<label>Padre o sustituto: '.$xml->DRP_INSTRUCCION_PADRE->es->option[intval($psic['drp_instruccion_padre'])].'</label><br>
		<label>Madre o sustituta: '.$xml->DRP_MADRE_INSTRUCCION->es->option[intval($psic['drp_madre_instruccion'])].'</label> <br>
		<label>Tipo trabajo padre/sustituto'.$xml->DRP_TRABAJO_PADRE->es->option[intval($psic['drp_trabajo_padre'])].'</label><br>
		<label>Tipo trabajo madre/sustituta: '.$xml->DRP_TRABAJO_MADRE->es->option[intval($psic['drp_trabajo_madre'])].'</label><br>
		<label>Paciente vive: '.$xml->DRP_JOVEN_VIVE->es->option[intval($psic['drp_joven_vive'])].'</label><br>
		<label>Percepcion familiar por el joven: '.$xml->DRP_PERCEPCION_FAMILIAR->es->option[intval($psic['drp_percepcion_familiar'])].'</label><br>
		<label>Diagrama familiar: '.$psic['txt_diagrama_familiar'].'</label><br>
		<label>Observaciones: '.$psic['txt_area_observaciones_diagrama'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VII. Vivienda</legend>
		<label>Energia: '.$xml->DRP_ENERGIA->es->option[intval($psic['drp_energia'])].'</label><br>
		<label>Agua: '.$xml->DRP_AGUA->es->option[intval($psic['drp_agua'])].'</label><br>
		<label>Excretas: '.$xml->DRP_EXCRETAS->es->option[intval($psic['drp_excretas'])].'</label><br>
		<label>Numero cuartos:'.$psic['txt_numero_cuartos'].'</label><br>
		<label>Observaciones: '.$psic['txt_area_oservaciones_paciente'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>VIII. Educacion</legend>
		<label>Estudia: '.$xml->DRP_ESTUDIA->es->option[intval($psic['drp_estudia'])].'</label><br>
		<label>Nivel: '.$xml->DRP_NIVEL->es->option[intval($psic['drp_nivel'])].'</label><br>
		<label>Grado/curso: '.$psic['txt_grado_curso'].'</label><br>
		<label>Años aprobados: '.$psic['txt_anos_aprobados'].'</label><br>
		<label>Problemas colegio: '.$xml->DRP_PROBLEMAS_COLEGIO->es->option[intval($psic['drp_problemas_colegio'])].'</label> <br>
		<label>Años repetidos: '.$psic['chk_anos_repetidos'].'</label><br>
		<label>Causa años rep.: '.$psic['txt_causa'].'</label><br>
		<label>Desercion/exclusion: '.$xml->DRP_DESERCION->es->option[intval($psic['drp_desercion'])].'</label><br>
		<label>Causa Desercion: '.$psic['txt_causa_desercion'].'</label> <br>
		<label>Educacion no formal: '.$xml->DRP_NO_FORMAL->es->option[intval($psic['drp_no_formal'])].'</label><br>
		<label>Cual: '.$psic['txt_cual'].'</label><br>
		<label>Observaciones: '.$psic['txt_area_obervaciones_cual'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>IX. Trabajo</legend>
		<label>Actividad: '.$xml->DRP_ACTIVIDAD->es->option[intval($psic['drp_actividad'])].'</label><br>
		<label>Edad inicio trabajo: '.$psic['txt_inicio_trabajo'].'</label><br>
		<label>Horas/sem trabajo: '.$psic['txt_horas_trabajo'].'</label><br>
		<label>Horario trabajo: '.$xml->DRP_HORARIO_TRABAJO->es->option[intval($psic['drp_horario_trabajo'])].'</label><br>
		<label>Razon trabajo: '.$xml->DRP_RAZON_TRABAJO->es->option[intval($psic['drp_razon_trabajo'])].'</label><br>
		<label>Trabajo legalizado: '.$xml->DRP_TRABAJO_LEGALIZADO->es->option[intval($psic['drp_trabajo_legalizado'])].'</label><br>
		<label>Trabajo insalubre: '.$xml->DRP_TRABAJO_INSALUBRE->es->option[intval($psic['drp_trabajo_insalubre'])].'</label><br>
		<label>Tipo trabajo: '.$psic['txt_tipo_trabajo'].'</label><br>
		<label>Obervaciones: '.$psic['txt_area_observaciones_joven'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>X. Vida social</legend>
		<label>Aceptacion: '.$xml->DRP_ACEPTACION->es->option[intval($psic['drp_aceptacion'])].'</label><br>
		<label>Novio/a: '.$xml->DRP_NOVIAO->es->option[intval($psic['drp_noviao'])].'</label><br>
		<label>Amigos: '.$xml->DRP_AMIGOS->es->option[intval($psic['drp_amigos'])].'</label><br>
		<label>Actividad grupal: '.$xml->DRP_ACTIVIDAD_GRUPAL->es->option[intval($psic['drp_actividad_grupal'])].'</label> <br>
		<label>Deporte: '.$psic['txt_deporte'].' horas/sem</label><br>
		<label>TV: '.$psic['txt_tv'].' horas/dia</label><br>
		<label>Otras actividades: '.$xml->DRP_OTRAS_ACTIVIDADES->es->option[intval($psic['drp_otras_actividades'])].'</label><br>
		<label>Cuales: '.$psic['txt_otras_actividades'].'</label> <br>
		<label>Observaciones: '.$psic['txt_area_observaciones_vida_social_1029'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XI. Habitos</legend>
		<label>Sueño normal: '.$xml->DRP_SUENO_NORMAL->es->option[intval($psic['drp_sueno_normal'])].'</label><br>
		<label>Alimentacion adecuada: '.$xml->DRP_ALIMENTACION_ADECUADA->es->option[intval($psic['drp_alimentacion_adecuada'])].'</label><br>
		<label>Comidas por dia: '.$psic['txt_comidas_dia'].'</label><br>
		<label>Cigarrilos por dia: '.$psic['txt_cigarrillos_dia'].'</label><br>
		<label>Edad inicio tabaco: '.$psic['txt_inicio_tabaco'].' años</label><br>
		<label>Alcohol: '.$psic['txt_alcohol'].' lts cerveza/sem</label><br>
		<label>Edad inicio alcohol: '.$psic['txt_inicio_alcohol2'].'</label><br>
		<label>Otro toxico: '.$xml->DRP_OTRO_TOXICO->es->option[intval($psic['drp_otro_toxico'])].'</label><br>
		<label>Frecuencia y tipo: '.$psic['txt_otro_toxico_frecuencia'].'</label><br>
		<label>Conduce vehiculo: '.$xml->DRP_CONDUCE_VEHICULO->es->option[intval($psic['drp_conduce_vehiculo'])].'</label><br>
		<label>Cual: '.$psic['txt_conduce_cual'].'</label><br>
		<label>Observaciones: '.$psic['txt_area_obervaciones_cual1'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XII. Gineco-urologico</legend>
		<label>Fecha menarca/espermarca: '.$psic['txt_menarca_espermarca'].'</label><br>
		<label>Fecha ult. menstruacion: '.$psic['fecha_ultima_menstruacion'].'</label><br>
		<label>Ciclos regulares: '.$xml->DRP_CICLOS_REGULARES->es->option[intval($psic['drp_ciclos_regulares'])].'</label> <br>
		<label>Dismenorrea: '.$xml->DRP_DISMENORREA->es->option[intval($psic['drp_dismenorrea'])].'</label><br>
		<label>Flujo patologico/secrecion peneana: '.$xml->DRP_FLUJO_PATOLOGICO->es->option[intval($psic['drp_flujo_patologico'])].'</label><br>
		<label>ETS: '.$xml->DRP_ETS_JOVEN->es->option[intval($psic['drp_ets_joven'])].'</label><br>
		<label>Cual: '.$psic['txt_ets'].'</label> <br>
		<label>Embarazos: '.$psic['chkg_embarazos'].'</label><br>
		<label>Hijos: '.$psic['chkg_hijos'].'</label><br>
		<label>Abortos: '.$psic['chkg_abortos'].'</label><br>
		<label>Observaciones: '.$psic['txt_area_observaciones_sexualidad'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XIII. Sexualidad</legend>
		<label>Necesita informacion: '.$xml->DRP_NECESITA_INFO->es->option[intval($psic['drp_necesita_info'])].'</label> <br>
		<label>Relaciones sexuales: '.$psic['y_n_relaciones_sexuales'].'</label><br>
		<label>Tipo: '.$xml->DRP_RELACIONES_SEXUALES->es->option[intval($psic['drp_relaciones_sexuales'])].'</label><br>
		<label>Pareja: '.$xml->DRP_PAREJAS_SEXUALES->es->option[intval($psic['drp_parejas_sexuales'])].'</label><br>
		<label>Edad inicio relaciones sexuales: '.$psic['txt_inicio_sexo'].'</label> <br>
		<label>Problemas en relaciones sexuales: '.$xml->DRP_PROBLEMAS_SEXUALES->es->option[intval($psic['drp_problemas_sexuales'])].'</label><br>
		<label>Anticoncepcion: '.$xml->DRP_ANTICONCEPCION->es->option[intval($psic['drp_anticoncepcion'])].'</label><br>
		<label>Condon: '.$xml->DRP_CONDON->es->option[intval($psic['drp_condon'])].'</label><br>
		<label>Abuso sexual: '.$xml->DRP_ABUSO_SEXUAL->es->option[intval($psic['drp_abuso_sexual'])].'</label><br>
		<label>Observaciones: '.$psic['txt_observaciones_sex'].'</label><br>
	</fieldset>
	<fieldset>
		<legend>XIV. Situacion psicoemocional</legend>
		<label>Imagen corporal: '.$xml->DRP_IMAGEN_CORPORAL->es->option[intval($psic['drp_imagen_corporal'])].'</label> <br>
		<label>Autopercepcion: '.$xml->DRP_AUTOPERCEPCION->es->option[intval($psic['drp_autopercepcion'])].'</label><br>
		<label>Referente adulto: '.$xml->DRP_REFERENTE_ADULTO->es->option[intval($psic['drp_referente_adulto'])].'</label><br>
		<label>Proyecto de vida: '.$xml->DRP_PROYECTO_VIDA->es->option[intval($psic['drp_proyecto_vida'])].'</label><br>
		<label>Observaciones: '.$psic['txt_area_observaciones_psicoemocional'].'</label> <br>
	</fieldset>
	<fieldset>
		<legend>XV. Examen fisico</legend>
		<label>Aspecto general: '.$xml->DRP_ASPECTO_GENERAL->es->option[intval($psic['drp_aspecto_general'])].'</label><br>
		<label>Peso: '.$psic['txt_peso'].' kg</label><br>
		<label>Talla: '.$psic['txt_talla_mm'].' cm</label><br>
		<label>Centil peso/edad: '.$psic['txt_centil_pesoedad'].'</label><br>
		<label>Centil talla/edad: '.$psic['txt_centil_tallaedad'].'</label><br>
		<label>Centil peso/talla: '.$psic['txt_centil_pesotalla'].'</label> <br>
		<label>Piel y faneras: '.$xml->DRP_PIEL_FANERAS->es->option[intval($psic['drp_piel_faneras'])].'</label><br>
		<label>Cabeza: '.$xml->DRP_CABEZA->es->option[intval($psic['drp_cabeza'])].'</label><br>
		<label>Agudeza visual: '.$xml->DRP_AGUDEZA_VISUAL->es->option[intval($psic['drp_agudeza_visual'])].'</label><br>
		<label>Agudeza auditiva: '.$xml->DRP_AGUDEZA_AUDITIVA->es->option[intval($psic['drp_agudeza_auditiva'])].'</label> <br>
		<label>Boca y dientes: '.$xml->DRP_BOCA_DIENTES->es->option[intval($psic['drp_boca_dientes'])].'</label><br>
		<label> Cuello y tiroides: '.$xml->DRP_CUELLO_TIROIDES->es->option[intval($psic['drp_cuello_tiroides'])].'</label><br>
		<label>Torax y mamas: '.$xml->DRP_TORAX_MAMAS->es->option[intval($psic['drp_torax_mamas'])].'</label><br>
		<label>Cardiopulmonar: '.$xml->DRP_CARDIO_PULMONAR->es->option[intval($psic['drp_cardio_pulmonar'])].'</label><br>
		<label>PA: '.$psic['txt_presion_arterial'].'</label><br>
		<label>FC: '.$psic['txt_frecuencia_cardiaca'].' Lat/min</label> <br>
		<label>Abdomen: '.$xml->DRP_ABDOMEN->es->option[intval($psic['drp_abdomen'])].'</label><br>
		<label>Genito-urinario: '.$xml->DRP_GENITO_URINARIO->es->option[intval($psic['drp_genito_urinario'])].'</label><br>
		<label>Tanner: '.$xml->DRP_TANNER->es->option[intval($psic['drp_tanner'])].'</label><br>
		<label>Volumen testiculo derecho: '.$psic['txt_vol_testiculo_der'].' cm3</label> <br>
		<label>Volumen testiculo izquierdo: '.$psic['txt_vol_testiculo_izq'].' cm3</label><br>
		<label>Columna: '.$xml->DRP_COLUMNA->es->option[intval($psic['drp_columna'])].'</label><br>
		<label>Extremidades: '.$xml->DRP_EXTREMIDADES->es->option[intval($psic['drp_extremidades'])].'</label><br>
		<label>Neurologico: '.$xml->DRP_NEUROLOGICO->es->option[intval($psic['drp_neurologico'])].'</label><br>
		<label>Observaciones: '.$psic['txt_area_observaciones_examen_fisico'].'</label><br>
		<label>Impresion diagnostica: '.$psic['txt_area_impresion_diagnostica'].'</label><br>
		<label>Indicacion e interconsulta: '.$psic['txt_area_indicaciones_interconsultas'].'</label><br>
		<label>Fecha proxima cita: '.$psic['fecha_proxima_cita'].'</label><br>
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
	    echo "Error abriendo test.xml.";
	}
	
?>