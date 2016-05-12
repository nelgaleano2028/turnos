<?php
require_once("../librerias/lib/connection.php");
	
	
	
	function validar_progMesTur($cod_epl,$mes,$anio){
	
		global $conn;
		$array=array();
		$sql="select * from prog_mes_tur where cod_epl='".$cod_epl."' and mes='".$mes."' and Ano='".$anio."'";
		
		
	    $rs=$conn->Execute($sql);
		
		$acc=$rs->RecordCount();
		
		
		
		if($acc >0 ){
			return 1;
		}else{
			return 2;
		}
			
	}
	
	
   function validar_programacion($cod_epl,$mes,$anio,$accion){
		global $conn;
		$array=array();
		$sql="select * from prog_mes_tur_ini where cod_epl='".$cod_epl."' and mes='".$mes."' and Ano='".$anio."'";
		
	    $rs=$conn->Execute($sql);
		if($accion == "cantidad"){
			$acc=$rs->RecordCount();
			
		}else if($accion == "arreglo"){
		
			while($fila=$rs->FetchRow()){
				
				$array[]=array("cod_epl"=>$fila["cod_epl"],
							   "Mes"=>$fila["Mes"],
							   "Ano"=>$fila["Ano"],
							   "cod_ciclo"=>$fila["cod_ciclo"],
							   "cod_ciclo2"=>$fila["cod_ciclo2"],
							   "cod_ciclo3"=>$fila["cod_ciclo3"],
							   "cod_ciclo4"=>$fila["cod_ciclo4"],
							   "cod_ciclo5"=>$fila["cod_ciclo5"],
							   "cod_ciclo6"=>$fila["cod_ciclo6"],
							   "sem1"=>$fila["sem1"],
							   "sem2"=>$fila["sem2"],
							   "sem3"=>$fila["sem3"],
							   "sem4"=>$fila["sem4"],
							   "sem5"=>$fila["sem5"],
							   "sem6"=>$fila["sem6"],
							   "cod_cc2"=>$fila["cod_cc2"],
							   "cod_car"=>$fila["cod_car"],
							   "cod_epl_jefe"=>$fila["cod_epl_jefe"],
							    1=>$fila["Td1"],
								2=>$fila["Td2"],
								3=>$fila["Td3"],
								4=>$fila["Td4"],
								5=>$fila["Td5"],
								6=>$fila["Td6"],
								7=>$fila["Td7"],
								8=>$fila["Td8"],
								9=>$fila["Td9"],
								10=>$fila["Td10"],
								11=>$fila["Td11"],
								12=>$fila["Td12"],
								13=>$fila["Td13"],
								14=>$fila["Td14"],
								15=>$fila["Td15"],
								16=>$fila["Td16"],
								17=>$fila["Td17"],
								18=>$fila["Td18"],
								19=>$fila["Td19"],
								20=>$fila["Td20"],
								21=>$fila["Td21"],
								22=>$fila["Td22"],
								23=>$fila["Td23"],
								24=>$fila["Td24"],
								25=>$fila["Td25"],
								26=>$fila["Td26"],
								27=>$fila["Td27"],
								28=>$fila["Td28"],
								29=>$fila["Td29"],
								30=>$fila["Td30"],
								31=>$fila["Td31"],
								"id"=>$fila["ID"]
							  );
				
			}
			
			$acc = $array;
		}
		
		return $acc;
	}
	
	$cod_epl=$_POST['cod_epl'];
	$mes=$_POST['mes'];
	$anio=$_POST['anio'];
	$resultado=null;
	$menos= $mes - 1;
	$cantidad=validar_programacion($cod_epl,$mes,$anio,"cantidad");
	
	if( $cantidad > 0){
		
		//abre el modal ya tiene programacion asignada
		$resultado=1;
	}else{
		
		
		$cantidad=validar_programacion($cod_epl,$menos,$anio,"cantidad");
		
		if($cantidad >0){
			
			//abre el modal desea copiar el mes anterior
			$datos=validar_programacion($cod_epl,$menos,$anio,"arreglo");
			$resultado=$datos;
				
		}else{
		
			//Mirar la programación de la tabla prog_mes_tur
			
			$resultado=validar_progMesTur($cod_epl,$mes,$anio);
			
		
		
			//abre atumaticamente la programacion de turnos con ciclo
			//$resultado=2;
		}
	
	}
	
	
	
	echo json_encode($resultado);
	
	
?>