<?php require_once("../librerias/lib/connection.php");

global $conn;


if($_POST['info']==1){ // Para el combobox y traer todas las ausencias
	
	$sql="select c.cod_con, con.nom_con from conceptos_ayu c, conceptos con where con.cod_con = c.cod_con and tabla = 'turnos'";
	$rs=$conn->Execute($sql);

	$html="";
	$html.= "<option value='0'>Seleccione una ausencia....</option>";

	while($fila=$rs->FetchRow()){

		$html.= "<option value=".$fila['cod_con'].">".$fila['nom_con']."</option>";
	}
		
		echo $html;

}else if($_POST['info']== 2){ // para traer los dias de vacaciones del empleado que tiene derecho el empleado
	
	$sql="select top(1) e.cod_gru, dias_vac, dias_Cons_vac -- into :ga_dias_vac, :dias_derecho
		from gru_dias_vac g, epl_grupos e
		where g.cod_gru=e.cod_gru and e.cod_epl='".@$_POST['cod_epl']."' order by e.cod_gru desc";
	
	$rs=$conn->Execute($sql);
	$fila=$rs->FetchRow();
	
	echo (int)@$fila['dias_vac'];
}else if($_POST['info']== 3){


	$sql3="select Id from supernumerario_tmp where Id='".@$_POST['cod_epl']."'";
	$rs3=$conn->Execute($sql3);
	if($rs3->RecordCount() > 0){
		
		$lista[]=array(	"datos"=> 1
								);
		echo json_encode($lista);	
	
	
	
	
	}else{
		

		/*$sql4="SELECT *
		FROM supernumerario_nov 
		WHERE 
		(DATEPART(month, convert(date,'".$_POST['fecha']."',105)) BETWEEN fec_ini AND FEC_FIN  OR DATEPART(month, convert(date,'".$_POST['fecha']."',105)) BETWEEN FEC_INI AND fec_fin) 
		AND ( DATEPART(month, convert(date,'".$_POST['fecha']."',105)) BETWEEN fec_ini AND FEC_FIN  OR DATEPART(month, convert(date,'".$_POST['fecha']."',105)) BETWEEN FEC_INI AND fec_fin)
		AND cod_epl_super='".@$_POST['cod_epl']."' and cod_epl_jefe='".@$_POST['jefe']."' and 
		cod_cc2='".@$_POST['cod_cc2']."'";	*/
		
		$sql4="SELECT *
		FROM supernumerario_nov 
		WHERE 
		DATEPART(month, fec_ini)='".$_POST['mes']."' and DATEPART(year, fec_ini)='".$_POST['anio']."'
		AND cod_epl_super='".@$_POST['cod_epl']."' and cod_epl_jefe='".@$_POST['jefe']."' and 
		cod_cc2='".@$_POST['cod_cc2']."'";
		
		//var_dump($sql4); die();
		$rs4=$conn->Execute($sql4);
		//$row = $rs4->fetchrow();
		

		//var_dump($row['cuantos']); die();
		
		if($rs4->RecordCount() > 0){
			
		
			$lista[]=array(	"datos"=> 2
								);
			echo json_encode($lista);	
	
	
	
	
		}else{
		
		
			$sql="select convert(varchar,fec_cau_ini,105) as fec_cau_ini, convert(varchar,fec_cau_fin,105) as fec_cau_fin 
		  from acumu_vacaciones where cod_epl='".@$_POST['cod_epl']."' order by fec_cau_ini desc";
	
			$rs=$conn->Execute($sql);
			if($rs->RecordCount() > 0){
			
				while($row = $rs->fetchrow()){
				$fec_cau_ini=explode(" ",$row["fec_cau_ini"]);
				$fec_cau_ini=explode("-",$fec_cau_ini[0]); //'2011-04-22'
				$fec_cau=$fec_cau_ini[0]."-".$fec_cau_ini[1]."-".$fec_cau_ini[2];
				
				/*$fec_cau_fin=explode(" ",$row["fec_cau_fin"]);
				$fec_cau_fin=explode("-",$fec_cau_fin[0]);*/
				
				$sql2="select sum(dias)as dias from bs_ausencias_vac where cod_epl='".@$_POST['cod_epl']."' and fec_ini =convert(varchar,'".$fec_cau."',105)";
				//var_dump($sql2); die();
				$rs2=$conn->Execute($sql2);
				$row2=$rs2->FetchRow();
					if(@$row2["dias"]==NULL):$row2["dias"]=0;endif;
					
				$lista[]=array(	"fec_cau_ini"=> $row["fec_cau_ini"],
								"fec_cau_fin" =>$row["fec_cau_fin"],
								"dias"=> @$row2["dias"]);
				}
			
			}else{
				$lista[]=array(	"fec_cau_ini"=> "no tiene",
								"fec_cau_fin" =>"no tiene",
								"dias"=> 0);
			}
			
			
			echo json_encode($lista);			
		}
		
	
	
	}
	
	
        
}else if($_POST['info']== 4){
    
    $sql="select c.cod_con, con.nom_con from conceptos_ayu c, conceptos con where con.cod_con = c.cod_con and tabla = 'turnos' and
        c.cod_con !=48 and  c.cod_con !=545 and c.cod_con !=71 and c.cod_con !=72 and c.cod_con !=73 and c.cod_con !=74
        and c.cod_con !=9000";
	$rs=$conn->Execute($sql);

	$html="";
	$html.= "<option value='0'>Seleccione una ausencia....</option>";

	while($fila=$rs->FetchRow()){

		$html.= "<option value=".$fila['cod_con'].">".$fila['nom_con']."</option>";
	}
		
		echo $html;
    
}
?>