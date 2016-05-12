<?php
date_default_timezone_set("America/Bogota");

$hora=date('Y-n-j H:i:s', time()); //  hora actual 


//var_dump($hora);die();


//var_dump($_SESSION['time']);die();

$tiempo_transcurrido = abs(strtotime($hora)-strtotime($_SESSION['time'])); // resto la hora que he entrado al sistema con la hora actual

//var_dump($tiempo_transcurrido);die();

 if($tiempo_transcurrido >= 3600) { // si el tiempo trasncurrido de inactividad  es mayor a  una hora
 
	  session_destroy(); // destruyo la sesión
	  echo "
	  <script>
	  var r=confirm('La sesion se ha cerrado');
		if (r==true)
		{
			window.location = '../../index.php';
		}
	  </script>
	  ";
      //header("Location: ../../index.php"); 	// me devuelve a la session
 }else{// sino ha  pasado la hora de inactividad
 
	$_SESSION['time']=$hora; // le asgigno  otravez tiempo a la sesion
 }
?>


