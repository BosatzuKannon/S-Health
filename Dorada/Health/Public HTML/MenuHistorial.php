<!DOCTYPE>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Historia</title>

<script src="jquery-1.12.3.js"></script>
<script src="dataTables.bootstrap.min.js"></script>
<script src="jquery.dataTables.min.js"></script>

<link href="bootstrap.min.css" rel="stylesheet">
<link href="dataTables.bootstrap.min.css" rel="stylesheet">

 <style>
          /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
          @import url("http://fonts.googleapis.com/css?family=Open+Sans:400,600,700");
            @import url("http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css");
            *, *:before, *:after {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
            }

            html, body {
              height: 100%;
            }

            body {
              font: 14px/1 'Open Sans', sans-serif;
              color: #555;
              background: #eee;
            }

            h1 {
              padding: 20px 0;
              font-weight: 800;
              text-align: center;
            }

            h2 {
              padding: 10px 0;
              font-weight: 400;
              text-align: left;
            }

            p {
              margin: 0 0 20px;
              line-height: 1.5;
            }

            main {
              min-width: 400px;
              max-width: 1250px;
              padding: 50px;
              margin: 0 auto;
              background: #fff;
            }

            section {
              display: none;
              padding: 20px 0 0;
              border-top: 1px solid #005791;
            }

            input {
              display: none;
            }

            label {
              display: inline-block;
              margin: 0 0 -1px;
              padding: 15px 25px;
              font-weight: 600;
              text-align: center;
              color: #bbb;
              border: 1px solid transparent;
            }

            label:before {
              font-family: fontawesome;
              font-weight: normal;
              margin-right: 10px;
            }

            label[for*='1']:before {
              content: '\f1cb';
            }

            label[for*='2']:before {
              content: '\f17d';
            }

            label[for*='3']:before {
              content: '\f16b';
            }

            label[for*='4']:before {
              content: '\f1a9';
            }

            label:hover {
              color: #888;
              cursor: pointer;
            }

            input:checked + label {
              color: #555;
              border: 1px solid #005791;
              border-top: 2px solid orange;
              border-bottom: 1px solid #fff;
            }

            #tab1:checked ~ #content1,
            #tab2:checked ~ #content2,
            #tab3:checked ~ #content3,
            #tab4:checked ~ #content4 {
              display: block;
            }

            @media screen and (max-width: 650px) {
              label {
                font-size: 0;
              }

              label:before {
                margin: 0;
                font-size: 18px;
              }
            }
            @media screen and (max-width: 400px) {
              label {
                padding: 15px;
              }
            }
    </style>
 <style>
          /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
          @import url("http://fonts.googleapis.com/css?family=Open+Sans:400,600,700");
            @import url("http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css");
            *, *:before, *:after {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
            }

            html, body {
              height: 100%;
            }

            body {
              font: 14px/1 'Open Sans', sans-serif;
              color: #555;
              background: #eee;
            }

            h1 {
              padding: 20px 0;
              font-weight: 800;
              text-align: center;
            }

            h2 {
              padding: 10px 0;
              font-weight: 400;
              text-align: left;
            }

            p {
              margin: 0 0 20px;
              line-height: 1.5;
            }

            main {
              min-width: 400px;
              max-width: 1250px;
              padding: 50px;
              margin: 0 auto;
              background: #fff;
            }

            section {
              display: none;
              padding: 20px 0 0;
              border-top: 1px solid #005791;
            }

            input {
              display: none;
            }

            label {
              display: inline-block;
              margin: 0 0 -1px;
              padding: 15px 25px;
              font-weight: 600;
              text-align: center;
              color: #bbb;
              border: 1px solid transparent;
            }

            label:before {
              font-family: fontawesome;
              font-weight: normal;
              margin-right: 10px;
            }

            label[for*='1']:before {
              content: '\f1cb';
            }

            label[for*='2']:before {
              content: '\f17d';
            }

            label[for*='3']:before {
              content: '\f16b';
            }

            label[for*='4']:before {
              content: '\f1a9';
            }

            label:hover {
              color: #888;
              cursor: pointer;
            }

            input:checked + label {
              color: #555;
              border: 1px solid #005791;
              border-top: 2px solid orange;
              border-bottom: 1px solid #fff;
            }

            #tab1:checked ~ #content1,
            #tab2:checked ~ #content2,
            #tab3:checked ~ #content3,
            #tab4:checked ~ #content4 {
              display: block;
            }

            @media screen and (max-width: 650px) {
              label {
                font-size: 0;
              }

              label:before {
                margin: 0;
                font-size: 18px;
              }
            }
            @media screen and (max-width: 400px) {
              label {
                padding: 15px;
              }
            }
    </style>

    <style type="text/css">
            .form-style-2{
                max-width: 1300px;
                padding: 20px 12px 10px 20px;
                font: 13px Arial, Helvetica, sans-serif;
            }
            .form-style-2-heading{
                font-weight: bold;
                font-style: italic;
                border-bottom: 2px solid #ddd;
                margin-bottom: 20px;
                font-size: 15px;
                padding-bottom: 3px;
            }
            .form-style-2 label{
                display: block;
                margin: 0px 0px 15px 0px;
            }
            .form-style-2 label > span{
                width: 100px;
                font-weight: bold;
                float: left;
                padding-top: 8px;
                padding-right: 5px;
            }
            .form-style-2 span.{
                color:red;
            }
            .form-style-2 .tel-number-field{
                width: 40px;
                text-align: center;
            }
            .form-style-2 input.input-field{
                width: 48%;
                
            }

            .form-style-2 input.input-field, 
            .form-style-2 .tel-number-field, 
            .form-style-2 .textarea-field, 
             .form-style-2 .select-field{
                box-sizing: border-box;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                border: 1px solid #C2C2C2;
                box-shadow: 1px 1px 4px #EBEBEB;
                -moz-box-shadow: 1px 1px 4px #EBEBEB;
                -webkit-box-shadow: 1px 1px 4px #EBEBEB;
                border-radius: 3px;
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                padding: 7px;
                outline: none;
            }
            .form-style-2 .input-field:focus, 
            .form-style-2 .tel-number-field:focus, 
            .form-style-2 .textarea-field:focus,  
            .form-style-2 .select-field:focus{
                border: 1px solid #005791;
            }
            .form-style-2 .textarea-field{
                height:100px;
                width: 55%;
            }
            .form-style-2 input[type=submit],
            .form-style-2 input[type=button]{
                border: none;
                padding: 8px 15px 8px 15px;
                background: #00a1e4;
                color: #fff;
                box-shadow: 1px 1px 4px #DADADA;
                -moz-box-shadow: 1px 1px 4px #DADADA;
                -webkit-box-shadow: 1px 1px 4px #DADADA;
                border-radius: 3px;
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
            }
            .form-style-2 input[type=submit]:hover,
            .form-style-2 input[type=button]:hover{
                background: #6095ab;
                color: #fff;
            }
    </style>

<?php 
	include("con_post.php");  
	ini_set ("display_errors", "1");
    error_reporting(E_ALL);	

    if(isset($_GET['r'])) {
    $r = $_GET['r'];
	} else {
	    $r = '';
	}

	if(isset($_GET['s'])) {
    $s = $_GET['s'];
	} else {
	    $s = '';
	}

?>

</head>
<body onBlur="self.focus()" onLoad="self.focus()">
<div id="content">

<h1 id="h1">Historial</h1>
<?php  
    $ced=$r;
	
	$strConsulta3 = "SELECT * from hlt_pacientes where no_historia =  '$ced'";
	$campos3 = pg_query($strConsulta3);
	$personal = pg_fetch_array($campos3);

	$tipod=$personal['cod_documento'];
	$strConsulta4 = "SELECT * from hlt_documento where cod_documento =  '$tipod'";
	$campos4 = pg_query($strConsulta4);
	$codtipo = pg_fetch_array($campos4);

	$estc=$personal['cod_estado_civil'];
	$strConsulta5 = "SELECT * from hlt_estado_civil where cod_estado_civil =  '$estc'";
	$campos5 = pg_query($strConsulta5);
	$codest = pg_fetch_array($campos5);
	
	$mun=$personal['cod_div_mun'];
	$strConsulta6 = "SELECT * from hlt_divipola where consecutivo_divipola =  '$mun'";
	$campos6 = pg_query($strConsulta6);
	$codmun = pg_fetch_array($campos6);
	
	$par=$personal['cod_parentezco'];
	$strConsulta6 = "SELECT * from hlt_parentezco where cod_parentezco =  '$par'";
	$campos6 = pg_query($strConsulta6);
	$codpar = pg_fetch_array($campos6);

	$pro=$personal['cod_ciuo'];
	$strConsulta6 = "SELECT * from hlt_ciuo where cod_ciuo =  '$pro'";
	$campos6 = pg_query($strConsulta6);
	$codpro = pg_fetch_array($campos6);

	$emp=$personal['cod_empresa'];
	$strConsulta6 = "SELECT * from hlt_empresa where cod_empresa =  '$emp'";
	$campos6 = pg_query($strConsulta6);
	$codemp = pg_fetch_array($campos6);

	$estra=$personal['cod_estrato'];
	$strConsulta6 = "SELECT * from hlt_estrato where cod_estrato =  '$estra'";
	$campos6 = pg_query($strConsulta6);
	$codestra = pg_fetch_array($campos6);

	$etn=$personal['cod_etnia'];
	$strConsulta6 = "SELECT * from hlt_etnia where cod_etnia =  '$etn'";
	$campos6 = pg_query($strConsulta6);
	$codetn = pg_fetch_array($campos6);
	
	$dis=$personal['cod_discapacidad'];
	$strConsulta6 = "SELECT * from hlt_discapacidad where cod_discapacidad =  '$dis'";
	$campos6 = pg_query($strConsulta6);
	$coddis = pg_fetch_array($campos6);

	$esc=$personal['cod_escolaridad'];
	$strConsulta6 = "SELECT * from hlt_escolaridad where cod_escolaridad =  '$esc'";
	$campos6 = pg_query($strConsulta6);
	$codesc = pg_fetch_array($campos6);

	//$ins=$personal['cod_ins_educativa'];
	//$strConsulta6 = "SELECT * from hlt_institucion_educativa where cod_institucion =  '$ins'";
	//$campos6 = pg_query($strConsulta6);
	//$codins = pg_fetch_array($campos6);
	//echo '<script language="javascript">alert("Aqui voy");</script>'; 

	$fenac=$personal['fecha_nac'];
	$fecha = time() - strtotime($fenac);
	$edad = floor((($fecha / 3600) / 24) / 360);

	$codigoHTML='
	
	<html>	
	<style type="text/css">
		label {
	    	display: inline;
	    	padding-right: 30px;
	    }
	</style>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Historia</title>
	</head>
	
	<div>
		
		<label>No. Historia: '.$ced.'</label>
		<label>Nombres: '.$personal['nom_1'].' '.$personal['nom_2'].'</label>
		<label>Apellidos: '.$personal['apel_1'].' '.$personal['apel_2'].'</label><br>
		<label>Documento de identidad: '.$codtipo['descripcion'].'</label>
		<label>Numero Documento: '.$ced.'</label><br>
		<label>Empresa: '.$codemp['nombre'].'</label><br>
		<label>Edad: '.$edad.'</label>
		<label>Sexo: '.$personal['cod_sexo'].'</label>
		<label>Estado Civil: '.$codest['descripcion'].'</label><br>
		<label>Lugar de Nacimiento: '.$codmun['nom_departamento'].'-'.$codmun['nom_municipio'].'-'.$codmun['nom_poblacion'].'</label><br>
		<label>Fecha de Nacimiento: '.$personal['fecha_nac'].'</label><br>
		<label>Direccion: '.$personal['direccion'].'-'.$personal['barrio'].'</label>
		<label>Telefono: '.$personal['telefono'].'</label><br>
		<label>Celular: '.$personal['celular'].'</label>
		<label>Email: '.$personal['email'].'</label><br>
		<label>Etnia: '.$codetn['descripcion'].'</label>
		<label>Profesion: '.$codpro['descripcion'].'</label><br>
		<label>'.$codestra['descripcion'].'</label>
		<label>Discapacidad: '.$coddis['descripcion'].'</label>
		<label>Escolaridad: '.$codesc['descripcion'].'</label><br>
		<label>Nombre contacto: '.$personal['contacto'].'</label><br>
		<label>Parentezco: '.$codpar['descripcion'].'</label>
		<label>Direccion de contacto: '.$personal['dir_contacto'].'</label><br>
		<label>Telefono de contacto: '.$personal['tel_contacto'].'</label>
	</div>
	<br>';
	echo $codigoHTML;
?>
<label id="total"></label><br>
<input class="btn btn-primary" type="button" id="19237" name="amo" width="100%" value="Adulto-Mayor">
<input class="btn btn-primary" type="button" id="19517" name="ajo" value="Adulto-Joven">
<input class="btn btn-primary" type="button" id="60403" name="avi" value="Agudeza-Visual">
<input class="btn btn-primary" type="button" id="19304" name="emb" value="Embarazo">
<input class="btn btn-primary" type="button" id="60401" name="cut" value="Cuello-Uterino">
<input class="btn btn-primary" type="button" id="890201" name="con" value="Consulta Externa">
<input class="btn btn-primary" type="button" id="60302" name="cde" value="Crecimiento-Desarrollo">
<input class="btn btn-primary" type="button" id="11" name="lac" value="Lactante">
<input class="btn btn-primary" type="button" id="890203" name="odo" value="Odontologia">
<input class="btn btn-primary" type="button" id="19509" name="rna" value="Recien-nacido">
<input class="btn btn-primary" type="button" id="39141" name="pfa" value="Planificacion-familiar">
<input class="btn btn-primary" type="button" id="890208" name="psi" value="Psicologia">
<input class="btn btn-primary" type="button" id="890701" name="urg" value="Urgencias">
<input class="btn btn-primary" type="button" id="9999" name="ecro" value="Enfermedades cronicas">

<input class="btn btn-primary" type="button" id="22" name="cit" value="Citologia">
<input class="btn btn-primary" type="button" id="33" name="sif" value="Sifilis">

<input class="btn btn-success" type="button" id="pro" name="pro" value="Procedimientos">
<input class="btn btn-success" type="button" id="med" name="med" value="Medicamentos">
<input class="btn btn-success" type="button" id="dx" name="dx" value="Diagnosticos">
<input class="btn btn-success" type="button" id="lab" name="lab" value="Laboratorios">
<input class="btn btn-warning" type="button" id="ant" name="ant" value="Antecedentes">
<input class="btn btn-warning" type="button" id="fri" name="fri" value="Fact Riesgo">

<hr />


<div id="divtb"></div>
<script type="text/javascript">
	$("input").hide();
	var servicio=<?php echo $s ?>;
    ///////////////////////////////////////////////
	$( "input" ).click(function() {
	  var cedula=<?php echo $r ?>;
	  //var servicio=<?php echo $s ?>;
	  var servicioC=$(this).attr('id');
	  var parametros = {
	                "cedula" : cedula,
	                "servicio" : servicioC
	  };
	  //alert($(this).attr('id'));
	  $.ajax({
                data:  parametros,
                url:   'LlenarHistorial.php',
                type:  'post',
                beforeSend: function () {
                        $("#tb1").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        $("#divtb").html(response);
                        $('#tb1').DataTable();
                }
     	});
	  

	});

	if(servicio=="19237")$("#19237").show(); // Adulto mayor
	if(servicio=="19517")$("#19517").show(); // Adulto Joven	
	if(servicio=="60403")$("#60403").show(); // Agudeza visual
	if(servicio=="19304")$("#19304").show(); // Embarazo
	if(servicio=="60401")$("#60401").show(); // Cuello uterino
	if(servicio=="890201")$("#890201").show(); // consulta externa	
	if(servicio=="60302")$("#60302").show(); // Crecimiento y desarrollo
	if(servicio=="11")$("#11").show(); // lactante
	if(servicio=="890203")$("#890203").show(); // odonlogia	
	if(servicio=="19509")$("#19509").show(); // Recien nacido
	if(servicio=="39141")$("#39141").show(); // Planificacion familiar
	if(servicio=="890208")$("#890208").show(); // psicoogia
	if(servicio=="890701")$("#890701").show(); // urgencias
	if(servicio=="9999")$("#9999").show(); // enfermedades cronicas

	if(servicio=="22")$("#22").show(); // citologia
	if(servicio=="33")$("#33").show(); // sifilis

  $("#pro").show(); // procedimientos
	$("#lab").show(); // Laboratorios
	$("#dx").show(); // diagnosticos
	$("#med").show(); // medicamentos
    $("#ant").show(); // antecedentes
  $("#fri").show(); // fac riesgo
	//////////////////////////////////////////////////
</script>
</div>
</body>
</html>
