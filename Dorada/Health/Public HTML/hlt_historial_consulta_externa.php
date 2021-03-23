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

	$caso = $_GET['q'];
	$atenciones = '';
	$query = "select motivo_consulta,enfermedad_actual,tratamiento from hlt_consulta_externa where caso = '$caso';";

	$result = pg_query($db_connection, $query);
    while($r = pg_fetch_array($result)){

    	$atenciones.= (empty($atenciones) ? '' : ', ') . '{ "motivo_consulta" : "' . $r['motivo_consulta']  .  '","enfermedad_actual" : "' . $r['enfermedad_actual']  . '","tratamiento" : "' . $r['tratamiento']  .   '"}';
    }

	die('[' . $atenciones . ']');

?>