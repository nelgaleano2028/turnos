<?php
@session_start();
require_once("class_turnoshe.php");

$obj= new Turnoshe();

$datos=$obj->consultar_ciclos();

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
			 <table cellpadding="0" cellspacing="0" border="0" class="display " id="cicloshe" width="100%" style="color:rgb(41,76,139) !important;">
				<thead style="background-color:rgb(41,76,139) !important;">
			        <tr>
						<th style="color:#2b4c88; font-weight: bold" width="5%" scope="col">Ciclo</th>
						<th style="color:#2b4c88; font-weight: bold" width="3%" scope="col">L</th>
						<th style="color:#2b4c88; font-weight: bold" width="3%" scope="col">M</th>
						<th style="color:#2b4c88; font-weight: bold" width="3%" scope="col">M</th>	
						<th style="color:#2b4c88; font-weight: bold" width="3%" scope="col">J</th>	
						<th style="color:#2b4c88; font-weight: bold" width="3%" scope="col">V</th>
						<th style="color:#2b4c88; font-weight: bold" width="3%" scope="col">S</th>
						<th style="color:#2b4c88; font-weight: bold" width="3%" scope="col">D</th>
						<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Descripci&oacute;n</th>
						<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Usuario</th>
						
			        </tr>
			    </thead>
				<tbody>
					<?php for($i=0; $i<count($datos); $i++){ ?>
						<tr> 
							<td align="center"><?php echo $datos[$i]['cod_ciclo']; ?></td>
							<td align="center"><?php echo $datos[$i]['L']; ?></td>
							<td align="center"><?php echo $datos[$i]['M']; ?></td>
							<td align="center"><?php echo $datos[$i]['MI'];?></td>
							<td align="center"><?php echo $datos[$i]['J'];?></td>
							<td align="center"><?php echo $datos[$i]['V'];?></td>
							<td align="center"><?php echo $datos[$i]['S'];?></td>
							<td align="center"><?php echo $datos[$i]['D'];?></td>
							<td align="center"><?php echo $datos[$i]['descripcion'];?></td>
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