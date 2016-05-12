<?php
@session_start();

?>

<html>
<head>
    <title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    
	<!-- Bootstrap -->
	<link rel="stylesheet" href="../../css/tunohe.css?css=<?php echo rand(1, 100);?>" />
    <link rel="stylesheet" href="../../css/bootstrap.min.css?css=<?php echo rand(1, 100);?>" />
    <link rel="stylesheet" href="../../css/style.css?css=<?php echo rand(1, 100);?>"  />
    <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.css?css=<?php echo rand(1, 100);?>" />
	<link rel="stylesheet" href="../../css/tablascroll_programacion.css?css=<?php echo rand(1, 100);?>" /> 
	<link rel="stylesheet" href="../../css/scroll.css?css=<?php echo rand(1, 100);?>" /> 
	<link rel="stylesheet" href="../../css/chosen.css?css=<?php echo rand(1, 100);?>" />
	<link rel="stylesheet" href="../../css/popover.css?css=<?php echo rand(1, 100);?>" />
	<link rel="stylesheet" href="../../css/jquery.contextMenu.css?css=<?php echo rand(1, 100);?>" />
	<style type="text/css" title="currentStyle">
		@import "../../js/DataTables/extras/TableTools/media/css/TableTools.css";
		@import "../../js/DataTables/extras/TableTools/media/css/TableTools_JUI.css";
		@import "../../js/DataTables/media/css/demo_page.css";
		@import "../../js/DataTables/media/css/demo_table_jui.css";
		@import "../../js/DataTables/media/css/jquery-ui-1.8.4.custom.css";
	</style>
	
</head>
<body >
	<div class="container-fluid">
		
			<form class="form-inline">
				<select class="select mes">
						  
					  <option value="00"  id="enero">Seleccione el mes...</option>
					  <option value="01"  id="enero">Enero</option>
					  <option value="02"  id="febrero">Febrero</option>
					  <option value="03"  id="marzo">Marzo</option>
					  <option value="04"  id="abril">Abril</option>
					  <option value="05"  id="mayo">Mayo</option>
					  <option value="06"  id="junio">Junio</option>
					  <option value="07"  id="julio">Julio</option>
					  <option value="08"  id="agosto">Agosto</option>
					  <option value="09"  id="septiembre">Septiembre</option>
					  <option value="10" id="octubre">Octubre</option>
					  <option value="11" id="noviembre">Noviembre</option>
					  <option value="12" id="diciembre">Diciembre</option>	
					  <option value="13" >Elegir solo a&ntilde;o</option>	
				</select>
				
				<div style="display:inline !important;" id="esconder1"  >
					
						
				</div>
				
				 <input type="button"  id="correo_electronico" name="singlebutton" class="btn btn-primary" value="Correo Electronico">
			</form>
		
	</div>
		<div id="contenido" class="container-fluid">
			
		</div>
		
		
		<div id="contenido2"  style="display:none;">
			
		</div>
	



<script src="../../js/alert.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/TableTools.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="../../js/turnoshe.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
<script src="../../js/chosen.jquery.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
<script src="../../js/tiny_mce/tiny_mce.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
<script src="../../js/jquery.contextMenu.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
</body>
</html>