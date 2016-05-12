<?php require_once("../librerias/lib/connection.php");


if($_POST['info']==1){

	$parametro='t_hor_max_turnos';
		
	echo json_encode(parametros($parametro));
			
}else if($_POST['info']==2){
		
	$parametro='t_hor_min_ciclos';
	
	echo json_encode(parametros($parametro));

}else if($_POST['info']==3){

		//echo $_POST['ciclo2']; die();
		if($_POST['ciclo1']=='undefined' || $_POST['ciclo1'] =="" ||  $_POST['ciclo1'] =='L'  || $_POST['ciclo2']=='undefined' || $_POST['ciclo2'] =="" ||  $_POST['ciclo2'] =='L'){
		
	 
			echo 1;
			
		}else{
			
			
				$parametro='tiempo_desc_turnos';
		
				$horas=parametros($parametro); 
				$horas_bd=$horas['tiempo_desc_turnos']; 	
			 
				$sql2="select hor_fin from turnos_prog where cod_tur='".@$_POST['ciclo1']."'
						union
						select hor_fin  from turnos_prog_tmp where cod_tur='".@$_POST['ciclo1']."'";
								
								
				$rs2=$conn->Execute($sql2);
				$row2= $rs2->fetchrow();
				
				$sql3="select hor_ini from turnos_prog where cod_tur='".@$_POST['ciclo2']."'
						union
						select hor_ini  from turnos_prog_tmp where cod_tur='".@$_POST['ciclo2']."'";
						
				$rs3=$conn->Execute($sql3);
				$row3= $rs3->fetchrow();
				
				$horas_basedatos=(int)$horas_bd * 3600; // son  las horas que vienen parametrizadas por el administrador
				
				$hor_fin_t1=explode(" ", @$row2['hor_fin']); // descompongo  las horas del turno 1
				$hor_fin2_t1=explode(":",@$hor_fin_t1[1]); //obtengo las horas del turno 1
				
				$hor_fin_horas_t1=(int)$hor_fin2_t1[0] * 3600; //convierto las horas del turno 1 en segundos
				$hor_fin_minutos_t1=(int)$hor_fin2_t1[0]; //convierto los  minutos del turno 1 en segundos
				//var_dump($hor_fin_horas_t1);
				//var_dump($hor_fin_minutos_t1);
				//var_dump($horas_basedatos);
				$suma_horas_fin_t1=$hor_fin_horas_t1 + $hor_fin_minutos_t1 + $horas_basedatos; // convierto las las horas y minutos del turno 1 en segundos y le sumo las horas de la parametrizacion
				//var_dump($suma_horas_fin_t1); 
				
				
				
				$hor_ini_t2=explode(" ", @$row3['hor_ini']); // descompongo  las horas del turno 2
				$hor_ini2_t2=explode(":",@$hor_ini_t2[1]); //obtengo las horas del turno 2
				
				
				$hor_ini_horas_t2=(int)$hor_ini2_t2[0] * 3600; //convierto las horas del turno 2 en segundos
				$hor_ini_minutos_t2=(int)$hor_ini2_t2[0]; //convierto los minutos del turno 2 en segundos
				
				//var_dump($hor_ini_horas_t2);
				//var_dump($hor_ini_minutos_t2);
				//var_dump($horas_basedatos); die();
				
				$suma_horas_ini_t2=$hor_ini_horas_t2 + $hor_ini_minutos_t2; // convierto las las horas y minutos del turno 2 en segundos 
				
				//var_dump($suma_horas_fin_t1); die();
				if($suma_horas_fin_t1 > 86350){
					
					//var_dump("hola1");
					
					
					
					$c1=$suma_horas_fin_t1;
					
					
					$c1= $c1 -86550;
					
					//var_dump($c1);
//var_dump('>=');					
					//var_dump($suma_horas_ini_t2);
					//die("hola");
					
					if($c1 >$suma_horas_ini_t2){
					
					 
					/*var_dump("hola2");*/
					
						echo  @(int)$horas_bd;
					}else{
					 //var_dump("hola3");
						echo 1;
					}
					
				//die("hola4");
				
				}else{
				//die("hola5");
					echo 1;
				}
				

				
		}

}else if($_POST['info']==4){

	$parametro='dias_vac';
		
	$dias_vac=parametros($parametro); 
	$dias_vacbd=(int)$dias_vac['dias_vac'];   // dias  que puede tomar en vacaciones en disfrute.
	
	if((int)$_POST['ausencia'] <= $dias_vacbd ){ 
		echo 1;
	}else{ //  el usuario digita mas dias  de vacaciones que el que esta parametrizado desde la base de datos
	
	
		echo $dias_vacbd;
	}


}

function parametros($parametro){

	global $conn;

	$lista=array();

	$sql="select top 1 ".$parametro." from turnos_parametros";
	
		
		$res=$conn->Execute($sql);
		 
		 	if($res){
			 
				while($row = $res->FetchRow()){
				
					$lista =  array($parametro=>$row[$parametro]);	
				}	
			}
			
	 return $lista;
}
