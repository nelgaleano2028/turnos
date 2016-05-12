<?php require_once("../librerias/lib/connection.php");

global $conn;

$turnos=array();
$horas=array();

$sql="SELECT * FROM prog_mes_tur where cod_epl='".@$_POST['cod_epl']."' and Mes='".@$_POST['mes']."' and Ano='".@$_POST['anio']."' and cod_car='".@$_POST['cod_car']."'
     and  cod_cc2='".@$_POST['cod_cc2']."' and cod_epl_jefe='".@$_POST['jefe']."'";
	 
	 //var_dump($sql); die();
	 	 

$rs=$conn->Execute($sql);

while($row=$rs->fetchrow()){
	
	for($i=1;$i<=31;$i++){
		
		$sql4="select horas from turnos_prog where cod_tur='".$row["Td".$i]."'";
		$rs4=$conn->Execute($sql4); 
		
		if($rs4->RecordCount() > 0){
			$row4= $rs4->fetchrow();
			$hora=$row4['horas'];
		}else{
			$sql5="select horas from turnos_prog_tmp where cod_tur='".$row["Td".$i]."' ";
			$rs5=$conn->Execute($sql5);
			$row5= $rs5->fetchrow();
			$hora=$row5['horas'];
		}
		
        $semana=semana($i,@$_POST['mes'],@$_POST['anio']);
		
		$dia=(int)date('N',strtotime($i."-".@$_POST['mes']."-".@$_POST['anio']));
		
		$turnos[]=array("turno"=> $row["Td".$i],
						"semana"=>$semana,
						"dia"=>$dia,
						"hora"=>$hora);	
		if($i<=6){
			$horas[]=array("horas"=>$row["sem".$i]);
			
			if($i==1){
					
					$ciclos[]=array("ciclos"=>$row['cod_ciclo']);
			}else{
			
					$ciclos[]=array("ciclos"=>$row['cod_ciclo'.$i]);
			}
			
			
		}
	}
}

echo json_encode(array('turnos'=>$turnos,'horas'=>$horas,'ciclos'=>$ciclos));

function semana($dia,$mes,$anio){

    $con_sem=0;
	
	for ($j=1;$j<=$dia;$j++){
		
		$domingo=(int)date('N',strtotime($j."-".$mes."-".$anio));
		
		if($domingo==7 && $j != $dia){
			$con_sem++;
		}else if($j==$dia && $j != $domingo){
			$con_sem++;	
		}
	}
	return $con_sem;
}
?>