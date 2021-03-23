<?php 

	ini_set("soap.wsdl_cache_enabled", "0");
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', True);
	header('Content-Type: text/html; charset=utf-8');
	include("zeusfjc_mysql.php");	

	if(!isset($_GET['q'])) { echo "no se ha recibido nada"; }

	$datos = $_GET['q'];
	
	$conn = new mysqli($servername, $username, $password, $dbname);	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	
	$sql1 = "SELECT COD FROM PMT_HLT_SEDES WHERE DANE = '$datos';";
	$result = $conn->query($sql1);
	$con = 0;
	while($r = $result->fetch_assoc()){		
		$con++;  		
	}
	die('[{ "resultado" : "' . $con . '"}]');
?>