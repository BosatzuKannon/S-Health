<?php 

	$db_connection = pg_connect("host=localhost dbname=dorada user=postgres password=carajo123");
	if (!$db_connection) {
		$error = pg_last_error();
    	echo $error;
	    exit;
	}
	
	if(!isset($_GET['q'])){
		echo "no se ha recibido nada";
	}

	$datos = explode('*-*',$_GET['q']);
	
	$sql1 = "SELECT cod_documento,no_historia FROM hlt_pacientes WHERE cod_documento = '$datos[0]' AND no_historia = '$datos[1]';";
	
	$con = 0;
	$result = pg_query($db_connection, $sql1);
    
    while($r = pg_fetch_array($result)) { $con++; }
	die('[{ "resultado" : "' . $con . '"}]');
?>