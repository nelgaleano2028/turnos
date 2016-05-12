<?php require_once("../librerias/lib/connection.php");

$fecha=$_POST['fecha'];
$cod_epl=$_POST['cod_epl'];

if($_POST['calculo']==2){

	$dias=@$_POST['canti']; //las arroas se ponen en el $_POST
	
	 $flag1=0;
	 
	 
	$dias=$dias -1; // 14
	
	while($dias>0){ // inicio de while 1 > 0 
		
		$dias--; // dias == 0
		
		if($flag1==0){
			
				
			 /*$festivo=verificar_festivos($cod_epl,$fecha); //  10-10-2013*/
			 $festivo=0;
			 
			 date_default_timezone_set("America/Bogota");
			 $fecha= strtotime($fecha);
			
			 
			if($festivo ==1){
			
				$fecha=  $fecha + 24*60*60;//un dia
				 
				$dias++;
				
				
			}else{
			
				$fecha=  $fecha + 24*60*60;
			}
			
			$fecha=date('d-m-Y',$fecha);
		}
		
		if($dias==0){ // si el ultimo dia tambien cae un festivo
		
			$flag1=1;
			
			
			/*$festivo=verificar_festivos($cod_epl,$fecha);*/
			$festivo=0;
			
			date_default_timezone_set("America/Bogota");
			$fecha= strtotime($fecha);
		
			
			if($festivo ==1){
			
				$fecha=  $fecha	+ 86400;
				
				$dias++;
				
			}
			
			
			$fecha=date('d-m-Y',$fecha);
		}
			
	}// fin de while
	
	echo $fecha;


}else{

	$calculo=verificar_festivos($cod_epl,$fecha);

	echo $calculo;
}

	



function verificar_festivos($cod_epl,$fecha){
	
	global $conn;  
	date_default_timezone_set("America/Bogota");
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
?>