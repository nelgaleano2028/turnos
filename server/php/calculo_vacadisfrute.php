<?php require_once("../librerias/lib/connection.php");





$festivo=verificar_festivos($_POST['cod_epl'],$_POST['fecha']); 

if($festivo==1){

	echo 1;
	
}else{
	
	global $conn;
		
		
	$sabadoh=sabadosHabiles(@$_POST['cod_epl']); // si es sabado == 0 no cuenta el sabado habil si es
	
	//echo $sabadoh; die();
	
	
	
	echo $vacaciones=vacaciones($_POST['fecha'],$_POST['canti'],$sabadoh,@$_POST['cod_epl']); 


}

function vacaciones($fecha,$dias,$sabadoh,$cod_epl){ //funcion para calcular del dia que inicia las vacaciones hasta el dia que entra a vacaciones
	
	// si es sabado == 0 no cuenta el sabado habil si es 1 lo cuenta
	//echo $sabadoh; die("sabado");
	
	 $flag1=0;     
	 
	 
	 //echo $sabadoh; die("hola");
	 
	 if($sabadoh==0){ // para que no cuente los sabados 
		
		$flag2=0;
	 }else{
	 
		$flag2=1;
	 }
	 
	
	$dias=$dias -1; // 14
	
	while($dias>0){ // inicio de while 1 > 0 
		 
		$dias--; // dias == 0
		
		
		if($flag1==0){
		
			 $festivo=verificar_festivos($cod_epl,$fecha); //  10-10-2013
			 
			 date_default_timezone_set("America/Bogota");
			 $fecha=(int)strtotime($fecha);
			 
			if($festivo ==1 || ($flag2==0 && date('l', $fecha) == 'Saturday')){
			
				$fecha=  $fecha + 24*60*60;//un dia
				 
				$dias++;
	
			}else if($flag2==1 && date('l', $fecha) == 'Saturday'){
				
				$fecha=  $fecha + 24*60*60;
				
				
			}else{
				
				$fecha=  $fecha + 24*60*60;
				
			}
			
			
			
			$fecha=date('d-m-Y',$fecha);
			
			
		}
		
		
		
		
		if($dias==0){ // si el ultimo dia tambien cae un festivo
			
			
			$flag1=1;
			
			
			$festivo=verificar_festivos($cod_epl,$fecha);	
			
		  
			
			$fecha= strtotime($fecha);
			
			if($festivo ==1 || ($flag2==0 && date('l', $fecha) == 'Saturday') ){
			
				$fecha=  $fecha	+ 86400;
				
				$dias++;
				
			}
			
			$fecha=date('d-m-Y',$fecha);
		}
			
	}// fin de while
	
		
	return $fecha;
	


}// fin de la funcion vacaciones

function sabadosHabiles($cod_epl){ //verificar si tiene sabados habiles
	
	global $conn;
	
	$sql="select top(1) g.ban_31,g.ban_sab --into :Nocuenta31,:vfn_sabhab
		from gru_dias_vac g, epl_grupos e 
		where g.cod_gru = e.cod_gru and e.cod_epl = '".$cod_epl."' AND g.cod_gru not in (1,2)";
	$rs=$conn->Execute($sql);
	$fila=$rs->FetchRow();
	
	if((int)$fila['ban_sab'] == 0){ //sabado no habil
		return 0;
	}else if((int)$fila['ban_sab'] == 1){ // sabado habil
		return 1;
	}
}



function verificar_festivos($cod_epl,$fecha){
	
	global $conn;  
	
	/*if($fecha=='26-10-2013'){
		echo $cod_epl; die();
	}*/
	
	$startDate=strtotime($fecha); // convierte a formato unix  1378962000
	
	if(date('l',$startDate) == 'Sunday'){ // me dice en que dia estoy
		return 1;
	}
	
	$sql="select * from feriados,epl_grupos
		 where feriados.fec_fer = '".$fecha."'
		 and epl_grupos.cod_epl = '".$cod_epl."'
		 and epl_grupos.cod_gru = feriados.cod_gru";
		 
	$rs = $conn->Execute($sql);
	if($rs->RecordCount() > 0){
		return 1;
	}else{
		return 0;
	}
}
