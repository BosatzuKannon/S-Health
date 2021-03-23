<?php 

	ini_set("soap.wsdl_cache_enabled", "0");
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', True);
	header('Content-Type: text/html; charset=utf-8');
	include("zeusfjc_mysql.php");	

	$conn = new mysqli($servername, $username, $password, $dbname);	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	
	$sql1 = "SELECT COD,UPPER(concat(APEL1,' ',APEL2,' ',NOM1,' ',NOM2)) as NOMBRE,UPPER(CONTACTO) as CONTACTO,TEL_CONTACTO FROM PMT_HLT_ALUMNOS;";
	$result = $conn->query($sql1);
	$listado = "";
	while($r = $result->fetch_assoc()){		
		
		$listado.= (empty($listado) ? '' : ', ') . '{ "COD" : "' . $r['COD']  .  '","NOMBRE" : "' . $r['NOMBRE']  .  '","CONTACTO" : "' . $r['CONTACTO']  .'","TEL_CONTACTO" : "' . $r['TEL_CONTACTO']  . '"}';  		
	}
	die('[' . $listado . ']');
?>