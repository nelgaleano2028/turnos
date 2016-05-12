<?php
require_once("../librerias/lib/connection.php");

global $conn;


if($_POST['info']==1){

	$lista=array();

	$sql="select RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl)as empleado, reloj.cod_epl, convert(varchar,reloj.hor_entr,105) as hor_entr, convert(varchar,reloj.hor_entr,108) as hor_entr1, convert(varchar,reloj.hor_sal,105) as hor_sal, convert(varchar,reloj.hor_sal,108) as hor_sal1
	from prog_reloj_tur as reloj, empleados_basic as b
	where
	reloj.cod_epl=b.cod_epl and 
	DATEPART(year, reloj.fecha)='".$_POST['anio']."' and DATEPART(month, reloj.fecha)='".$_POST['mes']."'";


	$rs=$conn->Execute($sql);
	while($row = $rs->fetchrow()){
		
		$lista[]=array("cod_epl"=>$row["cod_epl"],
						"empleado"=>$row["empleado"],
						"hor_entr"=>$row["hor_entr"].' '.$row["hor_entr1"],
						"hor_sal"=>$row["hor_sal"].' '.$row["hor_sal1"]
						);

	}

	echo json_encode($lista);


}else if($_POST['info']==2){

	$lista=array();

	$sql="select RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl)as empleado, reloj.cod_epl, convert(varchar,reloj.hor_entr,105) as hor_entr, convert(varchar,reloj.hor_entr,108) as hor_entr1, convert(varchar,reloj.hor_sal,105) as hor_sal, convert(varchar,reloj.hor_sal,108) as hor_sal1
	from prog_reloj_tur as reloj, empleados_basic as b
	where
	reloj.cod_epl=b.cod_epl and 
	DATEPART(year, reloj.fecha)='".$_POST['anio']."'";
	

	$rs=$conn->Execute($sql);
	while($row = $rs->fetchrow()){
		
		$lista[]=array("cod_epl"=>$row["cod_epl"],
						"empleado"=>$row["empleado"],
						"hor_entr"=>$row["hor_entr"].' '.$row["hor_entr1"],
						"hor_sal"=>$row["hor_sal"].' '.$row["hor_sal1"]
						);

	}

	echo json_encode($lista);


}


	
?>