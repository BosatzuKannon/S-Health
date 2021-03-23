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

	$datos = $_GET['q'];
	$query = "select distinct caso,fecha_emision,servicio,medico,observaciones from hlt_formula_medica where estado = '0' and no_historia = '$datos';";

	$result = pg_query($db_connection, $query);
    $formulas = '';

    while($r = pg_fetch_array($result)){

    	$formulas .= (empty($formulas) ? '' : ', ') . '{ "caso" : "' . $r['caso']  .  '","fecha" : "' . $r['fecha_emision']  .  '", "servicio" : "' . $r['servicio'] . '" , "medico" : "' . $r['medico'] . '" , "observacion" : "' . $r['observaciones'] . '"}';
	}	
	
	die('[' . $formulas . ']');
?>