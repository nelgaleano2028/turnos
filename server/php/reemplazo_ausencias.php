<?php require_once("../librerias/lib/connection.php");

global $conn;

if($_POST['info']==1){ // segundo combo empleados x cargo ó reemplazante del empleado session
	
	$sql="select a.cod_epl, RTRIM(a.nom_epl)+' '+RTRIM(a.ape_epl) as nombres 
		from empleados_basic a, cargos b 
		where a.cod_car=b.cod_car and a.estado='A' and b.estado='A' and a.cod_car='".$_POST['cod_car']."' 
		order by nombres asc";
	$rs=$conn->Execute($sql);

	$html="";
	$html.= "<option value='0'>Seleccione un reemplazo....</option>";

	while($fila=$rs->FetchRow()){

		$html.= "<option value=".$fila['cod_epl'].">".utf8_encode($fila['nombres'])."</option>";
	}
		
	 echo $html; // imprimir el combobox
	 
}else if($_POST['info']==2){ //tercer combo empleados x area  del empleado session

	$sql2="select b.cod_epl,RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as nombres
		from empleados_basic b, empleados_gral g 
		where b.cod_epl=g.cod_epl and g.cod_jefe='".$_POST['cod_epl_jefe']."' and b.cod_cc2='".$_POST['cod_cc2']."' and b.estado='A'  ";
	$rs2=$conn->Execute($sql2);

	$html="";
	$html.= "<option value='0'>Seleccione un reemplazo....</option>";

	while($fila2=$rs2->FetchRow()){

		$html.= "<option value=".$fila2['cod_epl'].">".utf8_encode($fila2['nombres'])."</option>";
	}
	echo $html; // imprimir el combobox
	
}else if($_POST['info']==3){ //cuarto combo empleados x externo listos deben de ser de las mismo cargo del empleado de session
	
	$sql2="select a.cod_eplc, RTRIM(a.nom_eplc)+' '+RTRIM(a.ape_eplc)as nombres 
			from epl_ctistas2 a
			where a.estado ='A'  order by nom_eplc asc";   //Todos los empleados de listos             //and a.cod_car='".$_POST['cod_car']."'
		
	$rs2=$conn->Execute($sql2);

	$html="";
	$html.= "<option value='0'>Seleccione un reemplazo....</option>";

	while($fila2=$rs2->FetchRow()){

		$html.= "<option value=".$fila2['cod_eplc'].">".utf8_encode($fila2['nombres'])."</option>";
	}
	
	echo $html; // imprimir el combobox
}else if($_POST['info']==4){
	
	
	$sql2="SELECT (RTRIM(basic.nom_epl)+' '+RTRIM(basic.ape_epl))as nombres, super.cod_epl_super as cod_epl
		FROM supernumerario_nov as super, empleados_basic as basic
		WHERE basic.cod_epl=super.cod_epl_super and
		(convert(date,'".@$_POST['fec_ini']."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".@$_POST['fec_fin']."',105) BETWEEN FEC_INI AND fec_fin)  AND super.cod_cc2='".@$_POST['cod_cc2']."' AND super.cod_epl_jefe='".@$_POST['cod_epl_jefe']."' 
		AND super.cod_epl_reemp='".@$_POST['cod_epl']."'
		UNION
		SELECT (RTRIM(basic.nom_eplc)+' '+RTRIM(basic.ape_eplc))as nombres, super.cod_epl_super 
		FROM supernumerario_nov as super, epl_ctistas2 as basic
		WHERE basic.cod_eplc=super.cod_epl_super and
	   (convert(date,'".@$_POST['fec_ini']."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".@$_POST['fec_fin']."',105) BETWEEN FEC_INI AND fec_fin)  AND super.cod_cc2='".@$_POST['cod_cc2']."' AND super.cod_epl_jefe='".@$_POST['cod_epl_jefe']."'
		AND super.cod_epl_reemp='".@$_POST['cod_epl']."'
		UNION
		SELECT nombre as nombres, Id as cod_epl
		FROM supernumerario_tmp where cod_car='".@$_POST['cod_car']."' AND cod_cc2='".@$_POST['cod_cc2']."' AND cod_epl_jefe='".@$_POST['cod_epl_jefe']."' AND mes='".@$_POST['mes']."' AND ano='".@$_POST['anio']."'
		order by nombres asc";
	
	//var_dump($sql2); die();
		
	$rs2=$conn->Execute($sql2);

	$html="";
	$html.= "<option value='0'>Seleccione un reemplazo....</option>";

	while($fila2=$rs2->FetchRow()){

		$html.= "<option value=".$fila2['cod_epl'].">".utf8_encode($fila2['nombres'])."</option>";
	}
	
	echo $html; // imprimir el combobox
	
	
}
?>