<?php
require_once("../librerias/lib/connection.php");

global $conn;

$sql="select * from supernumerario_tmp where Id='".@$_POST['id']."' ";
$res=$conn->Execute($sql);
$row = $res->FetchRow();
$cod_cc2=$row["cod_cc2"];
$cod_epl_jefe=$row["cod_epl_jefe"];
$mes=$row["mes"];
$ano=$row["ano"];
$lista=array();

$sql2="SELECT (basic.nom_epl+' '+basic.ape_epl)as nombres, super.cod_epl_super 
FROM supernumerario_nov as super, empleados_basic as basic
WHERE basic.cod_epl=super.cod_epl_super and
MONTH(super.fec_ini)='".$mes."' AND YEAR(super.fec_ini)='".$ano."' AND super.cod_cc2='".$cod_cc2."' AND super.cod_epl_jefe='".$cod_epl_jefe."'
UNION
SELECT (basic.nom_eplc+' '+basic.ape_eplc)as nombres, super.cod_epl_super 
FROM supernumerario_nov as super, epl_ctistas2 as basic
WHERE basic.cod_eplc=super.cod_epl_super and
MONTH(super.fec_ini)='".$mes."' AND YEAR(super.fec_ini)='".$ano."' AND super.cod_cc2='".$cod_cc2."' AND super.cod_epl_jefe='".$cod_epl_jefe."'";

$rs=$conn->Execute($sql2);
		 
while($row1 = $rs->fetchrow()){
		$lista[]=array("codigo" => $row1["cod_epl_super"],
		"nombres"  => utf8_encode($row1["nombres"]));
}
$select = "<select class='supernume_re span12' name='reemplazo'>";
$select .="<option value='-1'>Seleccione supernumerario...</option>";
for($i=0; $i<count($lista);$i++){		
	 $select .="<option value='".@$lista[$i]['codigo']."' id='".@$lista[$i]['codigo']."'>".@$lista[$i]['nombres']."</option>";		
}
$select .= '</select>';
echo $select;	

?>