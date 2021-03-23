<?php

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");
    require_once("PDF/dompdf/dompdf_config.inc.php");	
	
	$caso= $_GET['id'];

	$strConsulta = "SELECT * from hlt_consulta_psicologia where caso =  '$caso'";
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

	
	if (file_exists('datosxml/AgudezaVisualXml.xml')) {
    $xml = simplexml_load_file('datosxml/AgudezaVisualXml.xml');

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
		<label>Atencion: Psicologia</label><br>	
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
		<legend>III. Definicion del problema</legend><br>
		<fieldset><legend>Evolucion</legend><label>'.$psic['evol'].'</label></fieldset><br>
		<fieldset><legend>Causas</legend><label>'.$psic['causas'].'</label></fieldset><br>
		<fieldset><legend>Acciones realizadas en busca de solucion</legend><label>'.$psic['acciones'].'</label></fieldset><br>
		<fieldset><legend>Implicacion (a nivel familiar, social, académico, etc.)</legend><label>'.$psic['implicacion'].'</label></fieldset> 
	</fieldset>
	<br>
	<fieldset>
		<legend>IV. Estructura y funcionalidad familiar</legend><br>
		<fieldset><legend>Familiograma</legend><br>
			<table width="100%" border="1" cellspacing="0" cellpadding="0">
			  <tr>
			    <td><strong>Miembro</strong></td>
			    <td><strong>Parentezco</strong></td>
			    <td><strong>Edad</strong></td>
			    <td><strong>Escolaridad</strong></td>
			    <td><strong>Ocupacion</strong></td>
			  </tr>';
    
	$strConsulta7 = "SELECT * from hlt_familiograma where no_historia =  '$ced' ";
	$campos7= pg_query($strConsulta7);
	//$famili = pg_fetch_array($campos7);
	$numfilas = pg_numrows($campos7);
	
	for ($i=0; $i<$numfilas; $i++){
		$fila = pg_fetch_array($campos7);

		$escfa=$fila['cod_escolaridad'];
		$strConsulta9 = "SELECT * from hlt_escolaridad where cod_escolaridad =  '$escfa'";
		$campos9= pg_query($strConsulta9);
		$escolafami = pg_fetch_array($campos9);

		$ocup=$fila['cod_ciuo'];
		$strConsulta10 = "SELECT * from hlt_ciuo where cod_ciuo =  '$ocup'";
		$campos10= pg_query($strConsulta10);
		$ocupafami = pg_fetch_array($campos10);

		$paren=$fila['cod_parentezco'];
		$strConsulta10 = "SELECT * from hlt_parentezco where cod_parentezco =  '$paren'";
		$campos10= pg_query($strConsulta10);
		$parenfami = pg_fetch_array($campos10);

        $mie=$fila['cod_miembro'];
		$strConsulta10 = "SELECT * from pmt_ciuo where cod_miembro =  '$mie'";
		$campos10= pg_query($strConsulta10);
		$miemfami = pg_fetch_array($campos10);
			
		$codigoHTML.='	
			<tr>
				<td>'.$miemfami['miembro'].'</td>
				<td>'.$parenfami['parentezco'].'</td>
				<td>'.$fila['edad'].'</td>
				<td>'.$escolafami['descripcion'].'</td>
				<td>'.$ocupafami['descripcion'].'</td>	
			</tr>';
	}
	
	$codigoHTML.='
			</table>	
		</fieldset><br>
	</fieldset><br>
	
	<fieldset>
		<legend>VI. Historia Escolar</legend><br>
		<label>'.$psic['escolaridad'].'</label>
	</fieldset><br>
	<fieldset>
		<legend>VII. Observaciones  (descripción física, lenguaje no verbal, actitud, etc.)</legend><br>
		<label>'.$psic['obs_fis'].'</label>
	</fieldset><br>
	<fieldset>
		<legend>VIII. Dimensiones</legend><br>
		<fieldset><legend>Comportamenal</legend><label>'.$psic['comportamenal'].'</label></fieldset><br>
		<fieldset><legend>Afectiva</legend><label>'.$psic['afectivo'].'</label></fieldset><br>
		<fieldset><legend>Somatico</legend><label>'.$psic['somatico'].'</label></fieldset><br>
		<fieldset><legend>Cognitiva</legend><label>'.$psic['cognitivo'].'</label></fieldset><br>
		<fieldset><legend>Social</legend><label>'.$psic['social'].'</label></fieldset><br>
	</fieldset><br>
	<fieldset>
		<legend>IX. Prueba y analisis de resultados</legend><br>
		<fieldset><legend>Personalidad</legend><label>'.$psic['personalidad'].'</label></fieldset><br>
		<fieldset><legend>Inteligencia</legend><label>'.$psic['inteligencia'].'</label></fieldset><br>
		<fieldset><legend>Habilidades</legend><label>'.$psic['habilidades'].'</label></fieldset><br>
		<fieldset><legend>Otras</legend><label>'.$psic['otros'].'</label></fieldset><br>
	</fieldset><br>
	<fieldset>
		<legend>V. Historia Personal</legend><br>
		<fieldset><legend>infancia</legend><label>'.$psic['infancia'].'</label></fieldset><br>
		<fieldset><legend>Adolescencia</legend><label>'.$psic['adolescencia'].'</label></fieldset><br>
	</fieldset><br>

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