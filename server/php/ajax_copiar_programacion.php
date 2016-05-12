<?php 
	session_start();
	
	/*Esta validacion es para reutilizar codigo 
		si se envía datos por POST["id"] retorne los datos y crea una variable de session para copiar la programación */
	if(isset($_POST["id"])){
		require_once("class_programacion.php");
		
		$copiar= new programacion();
		
		echo $_SESSION["programacion"]=json_encode($copiar->copiar_programacion(@$_POST["id"]));
	}else{/*de lo contrario si no se envío POST retorna lo que contenga la varible de session (PEGAR)*/
		echo $_SESSION["programacion"];
	}
?>