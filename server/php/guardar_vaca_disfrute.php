<?php require_once("../librerias/lib/connection.php");

global $conn;

$sql="select cod_aus, (select max(cnsctvo)+1  from ausencias ) as consecutivo from conceptos_ausencias where cod_con=11"; // el 11 se cambia ta que no existe el cod_aus para vacaciones en disfrute

$rs = $conn->Execute($sql);

$fila=$rs->FetchRow();
$cod_aus=@$fila['cod_aus'];
$cnsctvo=@$fila['consecutivo'];


$sql3="insert into bs_ausencias_vac(cod_con,cod_epl,fec_ini,fec_fin,estado,cod_cc2,dias,cod_aus,fec_ini_r,fec_fin_r,cnsctvo,dias_pen,fecha)
	values(11,'".$_POST['cod_epl']."',convert(varchar,'".$_POST['fec_cau_ini']." 00:00:00.000',121),convert(varchar,'".$_POST['fec_cau_fin']." 00:00:00.000',121),
	'C','".$_POST['cod_cc2']."',".$_POST['dias'].",".$cod_aus.",convert(varchar,'".$_POST['fec_ini']." 00:00:00.000',121),convert(varchar,'".$_POST['fec_fin']." 00:00:00.000',121),'".$cnsctvo."',
	".$_POST['dias_pen'].",convert(varchar,'".$_POST['fec_ini']." 00:00:00.000',121))";
$rs3 = $conn->Execute($sql3);




if($rs3){
	echo 1;
}else{ echo 2;}


?>