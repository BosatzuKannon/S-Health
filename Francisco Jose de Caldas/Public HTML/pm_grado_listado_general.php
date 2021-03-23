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
	
	$sql1 = "SELECT UPPER(b.NOMBRE) as SEDE,CASE WHEN a.NIVEL = '0' THEN \"Pre-Escolar\" WHEN a.NIVEL = '1' THEN \"Primaria\" ELSE \"Secundaria\" END AS NIVEL,a.NUM,concat(c.USR_LASTNAME,' ',c.USR_FIRSTNAME) AS DIRECTOR, a.GRADO, a.COD FROM PMT_HLT_GRADOS a LEFT JOIN PMT_HLT_SEDES b ON a.SEDE=b.COD LEFT JOIN USERS c ON a.DIR=c.USR_UID;";
	$result = $conn->query($sql1);
	$listado = "";
	$pre = "";
	while($r = $result->fetch_assoc()){

		if($r['GRADO'] == "pr1"){$pre = 'P-';}
		else if($r['GRADO'] == "p1") {$pre = "1-";}
		else if($r['GRADO'] == "p2") {$pre = "2-";}
		else if($r['GRADO'] == "p3") {$pre = "3-";}
		else if($r['GRADO'] == "p4") {$pre = "4-";}
		else if($r['GRADO'] == "p5") {$pre = "5-";}
		else if($r['GRADO'] == "s1") {$pre = "6-";}
		else if($r['GRADO'] == "s2") {$pre = "7-";}
		else if($r['GRADO'] == "s3") {$pre = "8-";}
		else if($r['GRADO'] == "s4") {$pre = "9-";}
		else if($r['GRADO'] == "s5") {$pre = "10-";}
		else {$pre = "11-";}
		
		$listado.= (empty($listado) ? '' : ', ') . '{ "SEDE" : "' . $r['SEDE']  .  '","NIVEL" : "' . $r['NIVEL']  .  '","GRADO" : "' . $pre  . $r['NUM']  .'","DIRECTOR" : "' . $r['DIRECTOR']  .'","LINK" : "http://iefranciscojosedecaldas.com/syszeusfjc/es-ES/neoclassic/4069736305ed95c5881f2f1013924734/6814565155efbcbd09e2fe0055609095.php?gra=' . $r['COD']  . '"}';
	}
	die('[' . $listado . ']');
?>