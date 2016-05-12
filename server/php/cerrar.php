<?php
session_start();

if(!$_SESSION){
	header("location: ../../");
}else{
	//$_SESSION='';
      unset($_SESSION['nom']);
	 unset($_SESSION['pas']);
      unset($_SESSION['privi']); 
		unset($_SESSION['cod_epl']); 
		unset($_SESSION['usuario']);
		unset($_SESSION['cod']);
        unset($_SESSION['cor']);
       unset( $_SESSION['ced']); 
		unset($_SESSION['ape']);

session_destroy();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Turnos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css?css=<?php echo rand(1, 100);?>" />
    <link rel="stylesheet" href="../../css/style.css?css=<?php echo rand(1, 100);?>"  />
    <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.css?css=<?php echo rand(1, 100);?>" />
  </head>
  <body>
 
  
   <script src="../../js/jquery-1.10.1.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
    <script src="../../js/bootstrap.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
    
    <script> 
	$(document).ready(function(){
	
			$("body").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");
			setTimeout(function() {
				window.location = "../../index.php";
			}, 2000);

	  });
     </script>
  </body>
</html>
