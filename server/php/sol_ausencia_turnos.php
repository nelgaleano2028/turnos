<?php
@session_start();
require_once("class_novedades.php");

$obj= new novedades();

$datos=$obj->get_ausencias($_SESSION['cod_epl']);

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
                @import "../../js/DataTables/media/css/jquery.dataTables_themeroller.css";			
	</style>
	
</head>
<body >
	
	<div id="contenido" class="container-fluid">
		<div class="row-fluid">
			 <table cellpadding="0" cellspacing="0" border="0" class="display " id="admin" width="100%" style="color:rgb(41,76,139) !important;">
				<thead style="background-color:rgb(41,76,139) !important;" >
			        <tr>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Codigo Empleado</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Empleado</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Fecha Inicio</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Fecha Fin</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Tipo Ausencia</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Aceptar</th>	
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Rechazar</th>
			        </tr>
			    </thead>
				<tbody>
					<?php for($i=0; $i<count($datos); $i++){ ?>
						<tr>
                                                    <td align="center"><?php echo $datos[$i]['cod_epl']; ?></td>
                                                    <td align="center"><?php echo $datos[$i]['empleado']; ?></td>
                                                    <td align="center"><?php echo $datos[$i]['fecha_ini']; ?></td>
                                                    <td align="center"><?php echo $datos[$i]['fecha_fin']; ?></td>
                                                    <td align="center"><?php echo $datos[$i]['nom_tip_aus']; ?></td>
                                                    <td align="center">
                                                            <a href="#"  onClick="aceptar_solicitud_aus('<?php echo $datos[$i]['id']; ?>','<?php echo $datos[$i]['cod_epl']; ?>','<?php echo $datos[$i]['fecha_ini']; ?>','<?php echo $datos[$i]['fecha_fin']; ?>','<?php echo $datos[$i]['cod_cc2']; ?>','<?php echo $datos[$i]['cod_con']; ?>','<?php echo $_SESSION['cod_epl'] ; ?>');" >
                                                                    <img src="../../img/success.gif" title="Aprobar" alt="Aprobar" />
                                                            </a></td>
                                                            <td align="center">
                                                            <a href="#"  onClick="rechazar_solicitud_aus('<?php echo $datos[$i]['id']; ?>','<?php echo $datos[$i]['cod_epl']; ?>','<?php echo $datos[$i]['fecha_ini']; ?>','<?php echo $datos[$i]['fecha_fin']; ?>','<?php echo $datos[$i]['cod_cc2']; ?>','<?php echo $datos[$i]['cod_con']; ?>','<?php echo $_SESSION['cod_epl'] ; ?>');" >
                                                                    <img src="../../img/delete.png" title="Aprobar" alt="Aprobar" />
                                                            </a>
                                                    </td>
						</tr>
					<?php } ?>
				</tbody>
			 </table>
		</div>
	</div>



<script src="../../js/alert.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
<script src="../../js/dollar_get.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/TableTools.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="../../js/novedades.js?js=<?php echo rand(1, 100);?>&param=[0,1,2,3]" type="text/javascript"></script>
</body>
</html>