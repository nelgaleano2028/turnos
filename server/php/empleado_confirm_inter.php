<?php session_start();

require_once("class_novedades.php");

$obj= new novedades();

$datos=$obj->get_inter_epl($_SESSION['cod']);

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
			 <table cellpadding="0" cellspacing="0" border="0" class="display " id="admin" width="100%" style="color:rgb(41,76,139) !important;">
				<thead style="background-color:rgb(41,76,139) !important;">
			        <tr>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Fecha</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Empleado Actual</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Turno Actual</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Turno a Cambiar</th>
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Empleado Cambio</th>	
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Aceptar</th>	
					<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Rechazar</th>	
					
			        </tr>
			    </thead>
				<tbody>
					<?php for($i=0; $i<count($datos); $i++){  ?>
                                        
						<tr> 
                                                    <td align="center"><?php echo $datos[$i]['Fecha']; ?></td>
                                                    <td align="center"><?php echo $datos[$i]['Empleado_de_la_solicitud']; ?></td>
                                                    <td align="center"><?php echo $datos[$i]['Turno_Actual']; ?>(<?php echo $datos[$i]['hora_actual']; ?>)</td>
                                                    <td align="center"><?php echo $datos[$i]['Turno_a_Cambiar'];?>(<?php echo $datos[$i]['hora_cambiar']; ?>)</td>
                                                    <td align="center"><?php echo $datos[$i]['Empleado_a_Intercambiar']; ?></td>
                                                    <td align="center">
                                                            <a href="#"  onClick="aceptar_solicitud_inter_emp('<?php echo $datos[$i]['id']; ?>','<?php echo $datos[$i]['Fecha']; ?>','<?php echo $datos[$i]['cod_epl_actual']; ?>','<?php echo $datos[$i]['cod_epl_cambio']; ?>','<?php echo $datos[$i]['Turno_Actual']; ?>','<?php echo $datos[$i]['Turno_a_Cambiar']; ?>','<?php echo $datos[$i]['jefe']; ?>');" >
                                                                    <img src="../../img/success.gif" title="Aprobar" alt="Aprobar" />
                                                            </a></td>
                                                            <td align="center">
                                                            <a href="#"  onClick="rechazar_solicitud_inter_emp('<?php echo $datos[$i]['id']; ?>','<?php echo $datos[$i]['Fecha']; ?>','<?php echo $datos[$i]['cod_epl_actual']; ?>','<?php echo $datos[$i]['cod_epl_cambio']; ?>','<?php echo $datos[$i]['Turno_Actual']; ?>','<?php echo $datos[$i]['Turno_a_Cambiar']; ?>','<?php echo $datos[$i]['jefe']; ?>');" >
                                                                    <img src="../../img/delete.png" title="Rechazar" alt="Aprobar" />
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
<script src="../../js/novedades.js?js=<?php echo rand(1, 100);?>&param=[0,1,2,3,4,5]" type="text/javascript"></script>

</body>
</html>