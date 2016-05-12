<?php
session_start();
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=ficheroExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");

$anio=$_GET['anio']; 
$mes=$_GET['mes'];
$cargo=$_GET['cargo'];
$centro_costo=$_GET['cc'];
$perfil=@$_SESSION['nom']; //pERFIL JEFE



if($perfil=="TURNOSHE"){
	
	$perfil=@$_GET['perfil'];

}



switch ($mes){

	case 1:
		$return='ENERO';
	break;
	case 2:
		$return='FEBRERO';
	break;
	case 3:
		$return='MARZO';
	break;
	case 4:
		$return='ABRIL';
	break;
	case 5:
		$return='MAYO';
	break;
	case 6:
		$return='JUNIO';
	break;
	case 7:
		$return='JULIO';
	break;
	case 8:
		$return='AGOSTO';
	break;
	case 9:
		$return='SEPTIEMBRE';
	break;
	case 10:
		$return='OCTUBRE';
	break;
	case 11:
		$return='NOVIEMBRE';
	break;
	case 12:
		$return='DICIEMBRE';
	break;
	default :
		$return='VACIO';
				
}

include("tabla_programacion.php");


echo $html;


?>