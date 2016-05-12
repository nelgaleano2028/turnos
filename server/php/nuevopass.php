<?php
@session_start();

if (!isset($_SESSION['privi'])){
  
  echo "<script>location.href='../../index.php'</script>";
}
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
    

  
</head>
<body>
	<div id="error"></div>
	<div class="container-fluid">
		<div class="row-fluid">
          <div class="dialog span4">
              
			<div class="cambia" >
				<div class="modal-header">
				
				<h3 id="myModalLabel">Cambia tu Contrase&ntilde;a</h3>
				</div>
				<div class="modal-body">
				<p>Las contraseñas seguras contienen 8-16 caracteres, no incluyen palabras comunes o nombres, y combinan mayúsculas, minúsculas, números y símbolos.</p>
				 <form id="form_pass">
				 <div id="val1">
                    <label class="login_label control-label" for="passv">Contrase&ntilde;a Actual</label>
                        <div class="controls">
							<input type="password" class="span12" id="passv" name="passv"/>
						</div>  
				  </div>
				  
				  
				  <div id="val2">
                    <label class="login_label control-label" for="nue_cont">Nueva Contrase&ntilde;a </label><span id="result"></span>
                        <div class="controls">
							<input type="password" class="span12 pass" id="nue_cont" name="nue_cont"/>
						</div>  
				  </div>
				  
				  <div id="val3">
                    <label class="login_label control-label" for="pass">Confirmar Contrase&ntilde;a</label>
                        <div class="controls">
							<input type="password" class="span12 conf_pass" id="pass" name="pass"/>
						</div>  
				  </div>
				  <div><input id="enviar_click" type="submit" class="btn btn-primary" value="Enviar"/></div>
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
