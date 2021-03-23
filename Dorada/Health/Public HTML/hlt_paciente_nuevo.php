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
	
	$sql = "INSERT INTO hlt_pacientes(no_historia,cod_documento,apel_1,apel_2,nom_1,nom_2,fecha_nac,cod_div_mun,cod_div_mun_res,direccion,barrio,telefono,celular,email,contacto,tel_contacto,dir_contacto,cod_parentezco,cod_etnia,cod_ciuo,cod_discapacidad,cod_estado_civil,cod_empresa,cod_escolaridad,cod_estrato,cod_sexo,afiliacion,rh,calificacion)
	 VALUES('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$datos[8]','$datos[9]','$datos[10]','$datos[11]','$datos[12]','$datos[13]','$datos[14]','$datos[15]','$datos[16]','$datos[17]','$datos[18]','$datos[19]','$datos[20]','$datos[21]','$datos[22]','$datos[23]','$datos[24]','$datos[25]','$datos[26]','$datos[27]','$datos[28]');";

	$result = pg_query($db_connection, $sql);
	die("1");	

?>