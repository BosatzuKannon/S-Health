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

	if($datos[1] == "1"){

		$query = "SELECT descripcion as response FROM hlt_cei WHERE cod_cei = '$datos[0]';";
	}
	else{

		$query = "SELECT hlt_cei as response FROM cod_cei WHERE descripcion = '$datos[0]';";
	}
	
	$result = pg_query($db_connection, $query);

    $dx = '';
	while($r = pg_fetch_array($result)) {
		
		$dx .= (empty($dx) ? '' : ', ') . '{ "response" : "' . $r['response']  .  '"}';
	}	
	
	die('[' . $dx . ']');

?>