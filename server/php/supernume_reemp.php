<?php
@session_start();

if (!isset($_SESSION['privi'])){
  echo "<script>location.href='../../index.php'</script>";
}
$cod_epl_sesion=$_SESSION['cod_epl']; //sesion de RHERRERA
require_once("class_programacion.php");
$obj=new programacion();
$lista=$obj->supernumerario_tmp($cod_epl_sesion);
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    
	<!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css?css=<?php echo rand(1, 100);?>" />
    <link rel="stylesheet" href="../../css/style.css?css=<?php echo rand(1, 100);?>"  />
    <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.css?css=<?php echo rand(1, 100);?>" />
	<script src="../../js/alert.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
	<script src="../../js/programacion.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>  
</head>
<body>
	<div id="error"></div>
	<div class="container-fluid">
		<div class="row-fluid">
          <div class="dialog span4">
              
			<div class="cambia" >
				<div class="modal-header">
				
				<h3 id="myModalLabel">Supernumerario</h3>
				</div>
				<div class="modal-body">
				 <form id="su_reemp" method="post">
				 
				 <div id="val2">
                    <label class="login_label control-label ano" for="passv">Supernumerario Temporal:</label>
                        <div class="controls">
							<select name="supernume_tmp" class="span12 supernume_tmp">
							<option value="-1">Seleccione Supernumerario...</option> 
							<?php for($i=0; $i<count($lista);$i++){
								echo "<option value='".@$lista[$i]['codigo']."'>".@$lista[$i]['nombre']."</option>";		
							}?>
							</select>
						</div>  
				 </div>
				<div id="val3">
                       <label class="login_label control-label cargo_tmp" for="passv">Supernumerario:</label>
                        <div class="controls" id="super_reempl">						
						</div>  
				 </div>
				  <div><input id="supernume_reemplazo" type="button" class="btn btn-primary" value="Registrar"/></div>
				  </form>
				</div>
          </div>
		</div>
    </div>
	<script src="../../js/jquery-1.10.1.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
	<script src="../../js/bootstrap.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>	
    <script src="../../js/cambiapass.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>	
</body>
</html>