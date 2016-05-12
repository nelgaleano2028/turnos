<?php require_once("../librerias/lib/connection.php");


$festivo=verificar_festivos($_POST['cod_epl'],$_POST['fecha']); 

if($festivo==1){

	echo 1;

}else{

	global $conn;
	$sql3="select top(1) e.cod_gru, dias_vac, dias_Cons_vac -- into :ga_dias_vac, :dias_derecho
			from gru_dias_vac g, epl_grupos e
			where g.cod_gru=e.cod_gru and e.cod_epl='".@$_POST['cod_epl']."' order by e.cod_gru desc"; // sql para saber cuantos dias de vaciones tiene derecho el empleado por ley

			$rs3=$conn->Execute($sql3);
			
	
			$fila3=$rs3->FetchRow();
		
	if($_POST['ausencias'] == 11 && $_POST['canti']==(int)@$fila3['dias_vac']){ // si elijo en el combobox vacaciones y si la cantidad de vacaciones coincide con los dias vacaciones que tiene por ley
		
		$sql="select max(fec_cau_fin) as causacion from acumu_vacaciones where cod_epl = '".@$_POST['cod_epl']."'";
		//var_dump($sql); die("causacion");
		$rs=$conn->Execute($sql);
		$fila=$rs->FetchRow();
		
		//$fila['causacion']=NULL; // borrar --------------------------->>>>>>>>>>>>>>>>>>>>>>>>>
			
		if(@$fila['causacion']==NULL){ //inicio causacion NULL para los empleados que tiene null este campo.
			
			//var_dump($sql); die();
			
			$sql2="select top(1) e.cod_gru, dias_vac, dias_Cons_vac,(select ini_cto from empleados_basic where cod_epl='".@$_POST['cod_epl']."') as ini_cto
				   from gru_dias_vac g, epl_grupos e
				   where g.cod_gru=e.cod_gru and e.cod_epl='".@$_POST['cod_epl']."' order by e.cod_gru desc";
				   
			$rs2=$conn->Execute($sql2);	
			$fila2=$rs2->FetchRow();
			
			//$fila2['dias_Cons_vac']=180;
			
			
			if((int)$fila2['dias_Cons_vac']== 360){  //empleados que disfrutan 1 vez al año las vacaciones
				
				$flag=0;
					
				$causa_real2=noCausacion(@$_POST['cod_epl'],$flag,$fila2['ini_cto']);
				
				
			}else if((int)$fila2['dias_Cons_vac']== 180){  //empleados que disfrutan 2 vez al año las vacaciones
			
				$flag=1;
				
				$causa_real2=noCausacion(@$_POST['cod_epl'],$flag,$fila2['ini_cto']);	
			}
			
			//echo $fila2['ini_cto']; die("inicia contrato");
			$verificar=verificar_vacaciones($causa_real2,$_POST['fecha']);//verfica si el empleado tiene derecho a vacaciones

			//$verificar=1;
			if($verificar==1){
				
				/*verificar si tiene sabados habiles*/
				$sabadoh=sabadosHabiles(@$_POST['cod_epl']); // si es sabado == 0 no cuenta el sabado habil si es 1 lo cuenta
				
				
				echo vacaciones($_POST['fecha'],$_POST['canti'],$sabadoh,@$_POST['cod_epl']); //calcular del dia que inicia las vacaciones hasta el dia que entra a vacaciones

			}else{
				
				echo 2;
			
			}
			
			
		}else{ //@$fila['causacion'] si la causacion no es null
		
		

			date_default_timezone_set("America/Bogota");
			
			$sql2="select top(1) e.cod_gru, dias_vac, dias_Cons_vac 
				   from gru_dias_vac g, epl_grupos e
				   where g.cod_gru=e.cod_gru and e.cod_epl='".@$_POST['cod_epl']."' order by e.cod_gru desc";
				   
			//var_dump($sql2); die("dias vaciones");
				   
			$rs2=$conn->Execute($sql2);	
			$fila2=$rs2->FetchRow();
			
			//echo  @$fila['causacion']; die();
			if((int)$fila2['dias_Cons_vac']== 360){ 
				
				$flag=0;
				
				$causa_real2=causacion(@$_POST['cod_epl'],$flag,@$fila['causacion']);
				
				//echo $dias_ausencia; die("cuantos dias ausencia");
				
			}else if((int)$fila2['dias_Cons_vac']== 180){
			
				$flag=1;
				
				$causa_real2=causacion(@$_POST['cod_epl'],$flag,@$fila['causacion']);	
			}
			
			
			//ECHO @$fila['causacion']; die("causacion");
			$verificar=verificar_vacaciones($causa_real2,$_POST['fecha']);//verfica si el empleado tiene derecho a vacaciones
			
			
			if($verificar==1){
				
				/*verificar si tiene sabados habiles*/
				$sabadoh=sabadosHabiles(@$_POST['cod_epl']); // si es sabado == 0 no cuenta el sabado habil si es 1 lo cuenta
				
				echo $vacaciones=vacaciones($_POST['fecha'],$_POST['canti'],$sabadoh,@$_POST['cod_epl']); //calcular del dia que inicia las vacaciones hasta el dia que entra a vacaciones
				

			}else{
				
				echo 2;
			
			}			
			
		}//Fin causacion NULL

	}else if($_POST['ausencias'] == 11 && $_POST['canti']!=(int)@$fila3['dias_vac']){ // Fin $_POST['ausencias'] == 11 && $_POST['canti']==(int)@$fila3['dias_vac']

		echo 3;
		
	}else if($_POST['ausencias'] != 11 || $_POST['ausencias'] != 9000){ // es diferente a vacaciones o diferente a vacaciones en disfrute
	
		//calculo de la otras ausencias menos la de vacaciones
		$numero_dias=$_POST['canti'] * 86400;
		$fecha_final =(strtotime($_POST['fecha']) + $numero_dias) - 86400; 
		
		echo date('d-m-Y',$fecha_final);
	}

}// fin de validacion verificar si el dia que elije es festivo o domingo


/*======================================
	Funciones para calcular vacaciones
========================================*/
function causacion($cod_epl,$flag,$causacion){ // empleados con fecha de causacion
	
	$fecha_ini=explode(" ", $causacion);
	//echo $causacion; die("causacion");
	$fecha_ini2=explode("-", $fecha_ini[0]);
	
	//echo  $flag; die();
	
	if($flag==0){
		
		$fecha_causacion=(int)strtotime($fecha_ini2[2]."-".$fecha_ini2[1]."-".$fecha_ini2[0]) + 31536000; // le sumo 365 dias 
		//echo $fecha_causacion; die();
	}else{
	
		$fecha_causacion=(int)strtotime($fecha_ini2[2]."-".$fecha_ini2[1]."-".$fecha_ini2[0]) + 15552000; // le sumo 180 dias empleados de rayos x
	}
	
	$fecha_sum=date('d-m-Y',$fecha_causacion); 
	
	$fecha_causacacion=$fecha_ini2[2]."-".$fecha_ini2[1]."-".$fecha_ini2[0]; 
	
	$dias_ausencia=tabla_ausencia($cod_epl,$fecha_causacacion,$fecha_sum);// invoca la funcion tabla_aunsencia	

	if(@$dias_ausencia != NULL ){
				
		$dias_ausencia= $dias_ausencia * 86400; //86400 es un dia en segundos por el momento esta estatico
		
		
		$causa_real=(int)strtotime($fecha_sum) + $dias_ausencia;
		
		return $causa_real2=date('d-m-Y',$causa_real);
		
	}else{

		return $causa_real2=$fecha_sum;
		
	}
}

function noCausacion($cod_epl,$flag,$ini_cto){ //para los empleados que no tienen fecha de causacion
	
	$fecha_ini=explode(" ", $ini_cto); // 2012-10-01 00:00:00.000
	
	$fecha_ini2=explode("-", $fecha_ini[0]);
	
	
	
	if($fecha_ini2[2]=='01' && $fecha_ini2[1]!='01' ){ // si inicia el contrato un primero y que no sea el mes de enero
		
		if($flag==0){
			//date("d",mktime(0,0,0,$fecha_ini2[1]+1,0,$fecha_ini2[2])); para saber cuantos dias tiene un mes
$fecha_causacion=date("d",mktime(0,0,0,(int)$fecha_ini2[1],0,$fecha_ini2[0]))."-".((int)$fecha_ini2[1]-1)."-".($fecha_ini2[0] + 1);
			
			
		}else{ //flag 1 cuando el empleado tiene 180 de consecutivos de vaciones osea cuando $fila2['dias_Cons_vac']== 180
			$fecha_causacion=mes_aumento($fecha_ini2[1],$fecha_ini2[0]);
			
		}
		
		//die($fecha_causacion); //imprimir fecha de causacion en consola
		
	}else if($fecha_ini2[2]=='01' && $fecha_ini2[1]=='01'){ // si inicio_contrato el primero de enero
		
		if($flag==0){
			//$fecha_causacion='31-12-'.((int)$fecha_ini2[0] - 1);
			$fecha_causacion='01-01-'.((int)$fecha_ini2[0] + 1);
		}else{ // flag 1
			$fecha_causacion=mes_aumento($fecha_ini2[1],$fecha_ini2[0]);
		}
		//die($fecha_causacion); //imprimir fecha de causacion en consola
		
	}else{// flag 1
	
		if($flag==0){
			$fecha_causacion=((int)$fecha_ini2[2]-1)."-".$fecha_ini2[1]."-".($fecha_ini2[0] + 1);
			
			
		}else if($flag==1){
		
			date_default_timezone_set("America/Bogota");
			$a=((int)strtotime($fecha_ini2[2]."-".$fecha_ini2[1]."-".$fecha_ini2[0]) + 15778458)- 86400; // 15778458 equivalen a 6 meses - un dia
			
			$fecha_causacion=date('d-m-Y',$a);
		}
		//die($fecha_causacion); //imprimir fecha de causacion en consola
	}
	
		$fecha_ing=$fecha_ini2[2]."-".$fecha_ini2[1]."-".$fecha_ini2[0];
		
		
		//echo "fecha de ingreso->".$fecha_ing." fecha de causacion->".$fecha_causacion; die();
		
		$dias_ausencia=tabla_ausencia($cod_epl,$fecha_causacion,$fecha_ing); 
		
			
		
		if(@$dias_ausencia != NULL){
			
		   $dias_ausencia= $dias_ausencia * 86400; //86400 es un dia en segundos por el momento esta estatico

			$causa_real=(int)strtotime($fecha_causacion) *  $dias_ausencia;

			$causa_real2=date('d-m-Y',$causa_real);
			
		}else{
		
			$causa_real2=$fecha_causacion;
		}
	
		return $causa_real2;
}

function mes_aumento($mes,$anio){ // esta funcion para  la causacion de los empleados que tiene dos veces vacaciones

	$mes=(int)$mes+5;
			
	if($mes <= 12){
		$fecha_causacion=date("d",mktime(0,0,0,$mes+1,0,$anio))."-".$mes."-".$anio;
	}else{
		$mes_causa=$mes - 12;
		
		if($mes_causa==1){
			$fecha_causacion="31-12-".$anio;
		}else{
			$fecha_causacion=date("d",mktime(0,0,0,$mes_causa+1,0,((int)$anio+ 1)))."-".$mes_causa."-".((int)$anio+ 1);
		}
	}
	
	return $fecha_causacion;
}

function tabla_ausencia($cod_epl,$fecha_causacion,$fecha_ing){ //verifica si tiene licencias no remuneradas en la tabla ausencias de la base de datos y aumentas dias
	
	global $conn;
	
	$sql="select sum(dias) as dias from ausencias where cod_epl='".$cod_epl."' 
		 and fec_ini_r BETWEEN convert(date,'".$fecha_causacion ."',105) and convert(date,'".$fecha_ing."',105) and (cod_aus='2' or cod_aus='7')"; 
		 
		 // cod_aus es 2 porque es el codigo de la licencia no remunerada y el de suspencion es 7
		 
		 
	$rs=$conn->Execute($sql);
	$fila=$rs->FetchRow();

	return @$fila['dias'];
}

function verificar_vacaciones($cuasa_real2,$fecha){ // verificar si el empleado tiene derecho ha vacaciones

	 $fecha1=strtotime($cuasa_real2);
	 //echo $cuasa_real2; die("causa real");
	 $fecha2=strtotime($fecha);
	 
	 
	 if((int)$fecha1 <= (int)$fecha2){
	 
		return 1;
	 }else{
	 
		return 2;
	 }
}

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

function verificar_festivos($cod_epl,$fecha){
	
	global $conn;  
	
	/*if($fecha=='26-10-2013'){
		echo $cod_epl; die();
	}*/
	
	$startDate=strtotime($fecha); // convierte a formato unix  1378962000
	
	if(date('l',$startDate) == 'Sunday'){ // me dice en que dia estoy
		return 1;
	}
	
	// $sql="select * from feriados,epl_grupos
		 // where feriados.fec_fer = '".$fecha."'
		 // and epl_grupos.cod_epl = '".$cod_epl."'
		 // and epl_grupos.cod_gru = feriados.cod_gru ";
		 
		 $sql="select * from feriados,epl_grupos
		 where feriados.fec_fer = '".$fecha."'
		 and epl_grupos.cod_epl = '".$cod_epl."'
		 and epl_grupos.cod_gru = feriados.cod_gru ";
		 
		 
	$rs = $conn->Execute($sql);
	if($rs->RecordCount() > 0){
		return 1;
	}else{
		return 0;
	}
}
?>