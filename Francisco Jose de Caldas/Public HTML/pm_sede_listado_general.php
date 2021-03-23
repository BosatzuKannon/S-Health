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
	
	$sql1 = "SELECT COD,UPPER(NOMBRE) as NOMBRE,UPPER(DIRECCION) as DIRECCION,TEL,DANE FROM PMT_HLT_SEDES;";
	$result = $conn->query($sql1);
	$listado = "";
	while($r = $result->fetch_assoc()){		
		
		$listado.= (empty($listado) ? '' : ', ') . '{ "COD" : "' . $r['COD']  .  '","NOMBRE" : "' . $r['NOMBRE']  .  '","DIRECCION" : "' . $r['DIRECCION']  .'","TEL" : "' . $r['TEL']  .'","DANE" : "' . $r['DANE']  . '"}';  		
	}
	die('[' . $listado . ']');
?>