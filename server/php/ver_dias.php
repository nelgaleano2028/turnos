<?php require_once("../librerias/lib/connection.php");

$sql9="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".($_POST['mes'])."-".$_POST['anio']."'  )+1, 0))))as saber"; 
$rs9 = $conn->Execute($sql9);
$row=$rs9->fetchrow();
$saber2=(int)@$row['saber'];


$numeros=array();

for($i=1;$i<=$saber2;$i++){

	
	$semana=semana($i,$_POST['mes'],$_POST['anio']);
	
	$dia=(int)date('N',strtotime($i."-".@$_POST['mes']."-".@$_POST['anio']));
	
	$numeros[]=array("semana"=>$semana,
					 "dia"=>$dia);
}

echo json_encode(array('numeros'=>$numeros));


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