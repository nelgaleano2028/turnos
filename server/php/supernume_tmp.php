<?php
@session_start();

if (!isset($_SESSION['privi'])){
  
  echo "<script>location.href='../../index.php'</script>";
}
$cod_epl_sesion=$_SESSION['cod_epl']; //sesion de RHERRERA
require_once("class_programacion.php");
$obj=new programacion();
$lista1=$obj->anio_programaciones_anteriores();
$lista2=$obj->anio_max_programacion();	
$lista3=$obj->lista_centroCosto($cod_epl_sesion);
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
				
				<h3 id="myModalLabel">Supernumerario Temporal</h3>
				</div>
				<div class="modal-body">
				 <form id="su_temp" method="post">
				 <div id="val1">
                    <label class="login_label control-label nombre" for="nombre">Nombres:</label>
                        <div class="controls">
							<input type="text" class="span12"  name="nombre" id="nombre" />
						</div>
				 </div>
				 
				 <div id="val2">
                    <label class="login_label control-label ano" for="passv">Año:</label>
                        <div class="controls">
							<select name="ano" class="span12 anio">
							<option value="-1">Seleccione a&ntilde;o</option> 
							<?php for($i=0; $i<count($lista1);$i++){
							echo "<option value='".@$lista1[$i]['anio']."' id='".@$lista1[$i]['anio']."'>".@$lista1[$i]['anio']."</option>";		
				
							}?>
							 <option value="<?php echo @$lista2[0]['ano']; ?>" id="<?php echo @$lista2[0]['ano']; ?>"><?php echo @$lista2[0]['ano']; ?></option>
							</select>
						</div>  
				 </div>
				 
				 <div id="val3">
                       <label class="login_label control-label mes_super" for="passv">Mes:</label>
                        <div class="controls">
							<select name="mes" class="span12 mes">
							  <option value="-1">Seleccione Mes</option>
							  <option value="1">Enero</option>
							  <option value="2">Febrero</option>
							  <option value="3">Marzo</option>
							  <option value="4">Abril</option>
							  <option value="5">Mayo</option>
							  <option value="6">Junio</option>
							  <option value="7">Julio</option>
							  <option value="8">Agosto</option>
							  <option value="9">Septiembre</option>
							  <option value="10">Octubre</option>
							  <option value="11">Noviembre</option>
							  <option value="12">Diciembre</option>
						   </select>
						</div>  
				 </div>
				 <div id="val3">
                       <label class="login_label control-label centro_costo_tmp" for="cod_cc2">Centro costo:</label>
                        <div class="controls">
							<select name="cod_cc2" class="span12 centro_costo">
							<option value="-1">Seleccione Centro de Costo</option>
							  <?php 
								for($i=0; $i<count($lista3);$i++){
									echo "<option value='".@$lista3[$i]['codigo']."' id='".@$lista3[$i]['codigo']."'>".@$lista3[$i]['area']."</option>";		
								} 
							   ?>
						   </select>
						</div>  
				 </div>
				 
				 <div id="val3">
                       <label class="login_label control-label cargo_tmp" for="passv">&Aacute;rea:</label>
                        <div class="controls" id="combo2">
							
						</div>  
				 </div>
				  <input id="cod_epl_sesion" name="cod_epl_jefe" type="hidden" value="<?php echo $cod_epl_sesion ?>">
				  <input id="server" type="hidden" value="1">
				  <div><input id="supernume_temp" type="button" class="btn btn-primary" value="Registrar"/></div>
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
