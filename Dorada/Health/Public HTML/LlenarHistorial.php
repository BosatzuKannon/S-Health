<?php	

    ini_set ("display_errors", "1");
    error_reporting(E_ALL);	
	include("con_post.php");

	$cedula=$_POST['cedula'];
	$servicio= $_POST['servicio']; 

	if(!$connect) echo "error: ".pg_last_error();		
  	
	if ($servicio=="890208")$servicio="89.02.08";
	if ($servicio=="890701")$servicio="89.07.01";
	if ($servicio=="890703")$servicio="89.07.03";
	if ($servicio=="890203")$servicio="89.02.03";
	if ($servicio=="890201")$servicio="89.02.01";

	//VER CUAL ESTADO FUE EL FACTURADO
	$bandera=0;
	if ($servicio=='lab') {
		$sql = "SELECT * from hlt_formula_laboratorio where no_historia='$cedula'";
		$bandera++;
	}
	if ($servicio=='med') {
		$sql = "select distinct a.caso,a.dosis,a.cantidad,a.fecha_entrega,a.consecutivo_medicamento,b.fecha_cita,c.descripcion,b.profesional,b.cod_atencion from hlt_formula_medica a left join hlt_citas b on a.caso=b.caso left join hlt_atencion c on b.cod_atencion=c.cod_atencion where b.no_historia = '$cedula';";
		$bandera=2;
	}
	if ($servicio=='pro') {
		$sql = "select distinct a.caso,a.consecutivo_procedimiento,a.cantidad,b.fecha_cita,b.profesional,b.cod_atencion from hlt_formula_procedimiento a left join hlt_citas b on a.caso=b.caso left join hlt_atencion c on b.cod_atencion=c.cod_atencion where b.no_historia = '$cedula';";
		$bandera=3;
	}
	if ($servicio=='dx') {
		$sql = "select distinct a.hlt_citas_caso,a.dx1,a.dx2,a.dx3,a.dx4,b.fecha_cita,b.profesional,b.cod_atencion from hlt_diagnosticos a left join hlt_citas b on a.hlt_citas_caso=b.caso left join hlt_atencion c on b.cod_atencion=c.cod_atencion where b.no_historia = '$cedula';";
		$bandera=4;
	}
	if($bandera==0){
		$sql = "SELECT * from hlt_citas where no_historia='$cedula' and cod_atencion='$servicio' AND estado='1';";
	}

	if ($servicio=="89.02.08")$servicio="890208";
	if ($servicio=="89.07.01")$servicio="890701";
	if ($servicio=="89.07.03")$servicio="890703";
	if ($servicio=="89.02.03")$servicio="890203";
	if ($servicio=="89.02.01")$servicio="890201";

	$result = pg_query($sql)  or die('La consulta fallo: ' . pg_last_error());
	$numfilas = pg_numrows($result);
	
	$ret = '<table id="tb1" name="tb1" class="table table-striped table-bordered" cellspacing="0" width="100%">';

	if ($bandera==0)$ret .= '<thead><tr style="background-color:#00a1e4;"><td>No.</td><td>fecha_cita</td><td>Hora_cita</td><td>Profesional</td><td>Historia</td></tr></thead>';
	if ($bandera==1) $ret .= '<thead><tr style="background-color:#00a1e4;"><td>No.</td><td>fecha solicitud</td><td>fecha toma</td><td>Profesional</td><td>Estado</td><td>Fecha Cita</td></tr></thead>';
	if ($bandera==2)$ret .= '<thead><tr style="background-color:#00a1e4;"><td>Codigo</td><td>Nombre</td><td>Dosis</td><td>Cantidad</td><td>Profesional</td><td>Fecha Entrega</td><td>Fecha Cita</td><td>Cod-Atencion</td></tr></thead>';
	if ($bandera==3)$ret .= '<thead><tr style="background-color:#00a1e4;"><td>Cod. Cup</td><td>Cod. SOAT</td><td>Nombre</td><td>Cantidad</td><td>Profesional</td><td>Fecha Cita</td><td>Cod-Atencion</td></tr></thead>';
	if ($bandera==4)$ret .= '<thead><tr style="background-color:#00a1e4;"><td>DX1</td><td>DX2</td><td>DX3</td><td>DX4</td><td>Profesional</td><td>Fecha Cita</td><td>Cod-Atencion</td></tr></thead>';

	$bandera=0;
	for ($i=0; $i<$numfilas; $i++)
	{
		$fila = pg_fetch_array($result);
		$numlista = $i + 1;
		if ($servicio=='lab') {			
			$ret.= '<tr><td>'.$numlista.'</td>';		
			$ret.= '<td>'.$fila['fecha_solicitud'].'</td>';	
	        $ret.= '<td>'.$fila['fecha_toma'].'</td>';
	        $ret.= '<td>'.$fila['profesional'].'</td>';
	        $ret.= '<td>'.$fila['estado'].'</td>';
	         $ret.= '<td>'.$fila['fecha_cita'].'</td>';
	       
	        $bandera++;
		}
		if ($servicio=='med') {			
			$codme=$fila['consecutivo_medicamento'];
			$sql = "select distinct a.consecutivo_medicamento,b.cod_medicamento,b.descripcion from hlt_formula_medica a left join hlt_medicamento b on a.consecutivo_medicamento=b.consecutivo_medicamento where b.consecutivo_medicamento = '$codme';";
			
			$result2 = pg_query($sql)  or die('La consulta fallo: ' . pg_last_error());
			$fila2 = pg_fetch_array($result2);

			$ret.= '<tr><td>'.$fila2['cod_medicamento'].'</td>';
			$ret.= '<td>'.$fila2['descripcion'].'</td>';
			$ret.= '<td>'.$fila['dosis'].'</td>';
	        $ret.= '<td>'.$fila['cantidad'].'</td>';
	        $ret.= '<td>'.$fila['profesional'].'</td>';
	        $ret.= '<td>'.$fila['fecha_entrega'].'</td>';
	          $ret.= '<td>'.$fila['fecha_cita'].'</td>';
	           $ret.= '<td>'.$fila['cod_atencion'].'</td>';
	        $bandera++;
		}
		if ($servicio=='pro') {			
			$codme=$fila['consecutivo_procedimiento'];
			$sql = "select distinct a.consecutivo_procedimiento,b.descripcion,b.cod_cup_procedimiento,b.cod_soat_procedimiento from hlt_formula_procedimiento a left join hlt_procedimiento b on a.consecutivo_procedimiento=b.consecutivo_procedimiento where b.consecutivo_procedimiento = '$codme';";
			$result2 = pg_query($sql)  or die('La consulta fallo: ' . pg_last_error());
			$fila2 = pg_fetch_array($result2);
			$ret.= '<tr><td>'.$fila2['cod_cup_procedimiento'].'</td>';
			$ret.= '<td>'.$fila2['cod_soat_procedimiento'].'</td>';
			$ret.= '<td>'.$fila2['descripcion'].'</td>';
	        $ret.= '<td>'.$fila['cantidad'].'</td>';
	        $ret.= '<td>'.$fila['profesional'].'</td>';
	        $ret.= '<td>'.$fila['fecha_cita'].'</td>';
	        $ret.= '<td>'.$fila['cod_atencion'].'</td>';
	        $bandera++;
		}
		if ($servicio=='dx') {			
			$ret.= '<tr><td>'.$fila['dx1'].'</td>';
	        $ret.= '<td>'.$fila['dx2'].'</td>';
	        $ret.= '<td>'.$fila['dx3'].'</td>';
	        $ret.= '<td>'.$fila['dx4'].'</td>';
	        $ret.= '<td>'.$fila['profesional'].'</td>';
	        $ret.= '<td>'.$fila['fecha_cita'].'</td>';
	          $ret.= '<td>'.$fila['cod_atencion'].'</td>';
	        $bandera++;
		}

		if ($bandera==0) {
			$ret.= '<tr><td>'.$numlista.'</td>';
			$ret.= '<td>'.$fila['fecha_cita'].'</td>';
			$ret.= '<td>'.$fila['hora_cita'].'</td>';
		    $ret.= '<td>'.$fila['profesional'].'</td>';
		 
		    if($servicio=='19237')$ret.= '<td><a href="PdfAdultoMayor-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//adu-mayor
		    if($servicio=='19517')$ret.= '<td><a href="PdfAdultoJoven-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//adu-joven
		    if($servicio=='60403')$ret.= '<td><a href="PdfAgudezaVisual-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>'; // agu visual
		    if($servicio=='19304')$ret.= '<td><a href="PdfAlteracionesEmbarazo-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//embarazo
		    if($servicio=='60401')$ret.= '<td><a href="PdfCCU-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//Cuello ut
		    if($servicio=='890201')$ret.= '<td><a href="PdfConsultaExterna-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>'; // consulta externa
		    if($servicio=='60302')$ret.= '<td><a href="PdfCrecimientoDesarrollo-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//C Y D
		    if($servicio=='11')$ret.= '<td><a href="PdfLactante-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//Lactante
		    if($servicio=='890203')$ret.= '<td><a href="PdfOdontologia-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>'; // odonlogia
		    if($servicio=='19509')$ret.= '<td><a href="PdfPartoYRecienNacido-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//recien-na	
		    if($servicio=='39141')$ret.= '<td><a href="PdfPlanificacionFamiliar-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//Planificacion
		    if($servicio=='890208')$ret.= '<td><a href="PdfPsicologia-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>'; // psicoogia
		    if($servicio=='890701')$ret.= '<td><a href="PdfUrgencias-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>'; // urgencias		
		    if($servicio=='9999')$ret.= '<td><a href="PdfEnfermedadCronica-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//Enf Cronica

		    if($servicio=='22')$ret.= '<td><a href="PdfCitologia-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//Citologia
		    if($servicio=='33')$ret.= '<td><a href="PdfSifilis-html.php?id='.$fila['caso'].'" target="frame name">ver</a></td></tr>';//Sifilis
		}		

	}
	pg_close($connect);
	$ret.= "</table>";

	die($ret);
?>