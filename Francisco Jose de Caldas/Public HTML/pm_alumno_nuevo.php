<?php 

	ini_set("soap.wsdl_cache_enabled", "0");
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', True);
	header('Content-Type: text/html; charset=utf-8');
	include("zeusfjc_mysql.php");	

	if(!isset($_GET['q'])) { echo "no se ha recibido nada"; }

	$datos = explode('*-*',$_GET['q']);
	
	$conn = new mysqli($servername, $username, $password, $dbname);	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	
	$sql = "INSERT INTO PMT_HLT_ALUMNOS(TIPO_DOC,DOC,RH,APEL1,APEL2,NOM1,NOM2,GEN,NAC,ESTRA,ETNIA,MUN_NAC,MUN_RES,DIR,BAR,EMAIL,TEL,CEL,CIVIL,DISC,CONTACTO,PAR,DIR_CON,TEL_CONTACTO)
	 VALUES('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$datos[8]','$datos[9]','$datos[10]','$datos[11]','$datos[12]','$datos[13]','$datos[14]','$datos[15]','$datos[16]','$datos[17]','$datos[18]','$datos[19]','$datos[20]','$datos[21]','$datos[22]','$datos[23]');";

	if ($conn->query($sql) === TRUE) {    	
	}
	die("1");	
?>