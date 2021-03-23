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

	$cod_agenda = $_GET['q'];
	$citas = '';
	$query = "select a.hora_cita,concat(b.apel_1,' ',b.apel_2,' ',b.nom_1,' ',b.nom_2) as paciente  from hlt_citas a left join hlt_pacientes b on a.no_historia=b.no_historia where a.cod_agenda = '$cod_agenda' and a.estado != '3';";

	$result = pg_query($db_connection, $query);
    while($r = pg_fetch_array($result)){

    	$citas.= (empty($citas) ? '' : ', ') . '{ "hora" : "' . $r['hora_cita']  .  '","paciente" : "' . $r['paciente']  .   '"}';
    }

	die('[' . $citas . ']');

?>