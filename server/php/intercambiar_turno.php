<?php require_once("../librerias/lib/connection.php");

global $conn;

$lista=array();

$sql="select tur.cod_epl,tur.Td".$_POST["dia"]." as turno,(em.nom_epl+' '+em.ape_epl)as nombres
from prog_mes_tur as tur, empleados_basic as em
where tur.Mes='".$_POST["mes"]."' and tur.Ano='".$_POST["anio"]."' and em.cod_epl=tur.cod_epl
and tur.cod_cc2='".$_POST["cod_cc2"]."' and tur.cod_car='".$_POST["cod_car"]."' and cod_epl_jefe='".$_POST["jefe"]."' and tur.cod_epl <> '".$_POST["cod_epl"]."'
and tur.Td".$_POST["dia"]." <> '' ";

$rs=$conn->Execute($sql);

while($row = $rs->fetchrow()){
	$lista[]=array(	"cod_epl"=> $row["cod_epl"],
					"turno" => $row["turno"],
					"nombres"=> utf8_encode($row["nombres"]));
}

echo json_encode($lista);
?>