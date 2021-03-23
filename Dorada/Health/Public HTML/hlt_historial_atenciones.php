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

	$no_historia = $_GET['q'];
	$atenciones = '';
	$query = "select concat('Atención : ',b.descripcion,'   Fecha : ',a.fecha_cita,'    Hora : ',a.hora_cita),a.caso from hlt_citas a left join hlt_atencion b on a.cod_atencion=b.cod_atencion where a.no_historia = '$no_historia';";

	$result = pg_query($db_connection, $query);
    while($r = pg_fetch_array($result)){

    	$atenciones.= (empty($atenciones) ? '' : ', ') . '{ "texto" : "' . $r['concat']  .  '","caso" : "' . $r['caso']  .   '"}';
    }

	die('[' . $atenciones . ']');

?>