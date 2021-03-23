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
	
	$sql = "INSERT INTO PMT_HLT_GRADOS(SEDE,NIVEL,GRADO,NUM,DIR)
	 VALUES('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]');";

	if ($conn->query($sql) === TRUE) {    	
	}
	die("1");	
?>