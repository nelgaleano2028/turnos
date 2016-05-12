<?php
@session_start();
require_once("class_turnoshe.php");

$obj= new Turnoshe();

$datos=$obj->consultar_turnos();

?>

<html>
<head>
    <title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    
	<!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css?css=<?php echo rand(1, 100);?>" />
    <link rel="stylesheet" href="../../css/style.css?css=<?php echo rand(1, 100);?>"  />
    <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.css?css=<?php echo rand(1, 100);?>" />
	<style type="text/css" title="currentStyle">
		@import "../../js/DataTables/extras/TableTools/media/css/TableTools.css";
		@import "../../js/DataTables/extras/TableTools/media/css/TableTools_JUI.css";
		@import "../../js/DataTables/media/css/demo_page.css";
		@import "../../js/DataTables/media/css/demo_table_jui.css";
		@import "../../js/DataTables/media/css/jquery-ui-1.8.4.custom.css";
	</style>
	
</head>
<body >
	
	<div id="contenido" class="container-fluid">
		<div class="row-fluid">
			 <table cellpadding="0" cellspacing="0" border="0" class="display " id="turnoshe" width="100%" style="color:rgb(41,76,139) !important;">
				<thead style="background-color:rgb(41,76,139) !important;">
			        <tr>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Turno</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Horas</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Hora Inicial</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Hora Fin</th>	
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Usuario</th>	
						
					
			        </tr>
			    </thead>
				<tbody>
					<?php for($i=0; $i<count($datos); $i++){ ?>
						<tr> 
							<td align="center"><?php echo $datos[$i]['cod_tur']; ?></td>
							<td align="center"><?php echo $datos[$i]['horas']; ?></td>
							<td align="center"><?php echo $datos[$i]['hor_ini']; ?></td>
							<td align="center"><?php echo $datos[$i]['hor_fin'];?></td>
							<td align="center"><?php echo $datos[$i]['usuario'];?></td>
							
							
						</tr>
					<?php } ?>
				</tbody>
			 </table>
		</div>
	</div>



<script src="../../js/alert.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/TableTools.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="../../js/turnoshe.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
</body>
</html>