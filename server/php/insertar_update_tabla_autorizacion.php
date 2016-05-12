<?php require_once("../librerias/lib/connection.php");

global $conn;

$cod_epl=$_POST['cod_epl'];
$mes=$_POST['mes'];	
$anio=$_POST['anio'];
$dia=$_POST['dia'];
$codigo_jefe=$_POST['codigo_jefe'];





//CONCEPTOS

$extras_jefe_autoriza_hed_rel=$_POST['extras_jefe_autoriza_hed_rel'];
$extras_jefe_autoriza_hen_rel=$_POST['extras_jefe_autoriza_hen_rel'];
$extras_jefe_autoriza_hedf_rel=$_POST['extras_jefe_autoriza_hedf_rel'];
$extras_jefe_autoriza_henf_rel=$_POST['extras_jefe_autoriza_henf_rel'];
$extras_jefe_autoriza_hfd_rel=$_POST['extras_jefe_autoriza_hfd_rel'];
$extras_jefe_autoriza_rno_rel=$_POST['extras_jefe_autoriza_rno_rel'];
$extras_jefe_autoriza_rnf_rel=$_POST['extras_jefe_autoriza_rnf_rel'];
						
//**SEGUIMIENTO 1**//
/*
var_dump($extras_jefe_autoriza_hed_rel);
var_dump($extras_jefe_autoriza_hen_rel);
var_dump($extras_jefe_autoriza_hedf_rel);
var_dump($extras_jefe_autoriza_henf_rel);
var_dump($extras_jefe_autoriza_hfd_rel);
var_dump($extras_jefe_autoriza_rno_rel);
var_dump($extras_jefe_autoriza_rnf_rel);
die("bn1");
*/
						
						
$hed_apr=0.000;
$hen_apr=0.000;
$hedf_apr=0.000;
$henf_apr=0.000;
									
$hfd_apr=0.000;
$rno_apr=0.000;
$rnf_apr=0.000;


$sql0="SELECT  hed_rel,hen_rel,hedf_rel,henf_rel,hfd_rel,rno_rel,rnf_rel FROM prog_reloj_he  where cod_epl='".$cod_epl."' and cod_epl_jefe='".$codigo_jefe."' and fecha='".$anio."-".$dia."-".$mes."'";

$rs0=$conn->Execute($sql0);	

$row0 = $rs0->fetchrow();

$hed_rel = $row0["hed_rel"];
$hen_rel = $row0["hen_rel"];
$hedf_rel= $row0["hedf_rel"];
$henf_rel= $row0["henf_rel"];
$hfd_rel = $row0["hfd_rel"];
$rno_rel = $row0["rno_rel"];
$rnf_rel = $row0["rnf_rel"];




if($hed_rel !=0.0000){
			
	$hed_apr=$extras_jefe_autoriza_hed_rel;		
			
}
				
if($hen_rel !=0.0000){
					
	$hen_apr=$extras_jefe_autoriza_hen_rel;
					
}
				
if($hedf_rel !=0.0000){
	
	$hedf_apr=$extras_jefe_autoriza_hedf_rel;
						
}
					
if($henf_rel !=0.0000){
					
	$henf_apr=$extras_jefe_autoriza_henf_rel;
							
}
						
if($hfd_rel !=0.0000){
			
	$hfd_apr=$extras_jefe_autoriza_hfd_rel;
								
}
								
if($rno_rel !=0.0000){
					
	$rno_apr=$extras_jefe_autoriza_rno_rel;
									
}
									
if($rnf_rel !=0.0000){
					
	$rnf_apr=$extras_jefe_autoriza_rnf_rel;
										
}							


 $sql="update prog_reloj_he set hed_apr=".$hed_apr.", hen_apr=".$hen_apr.", hedf_apr=".$hedf_apr.", henf_apr=".$henf_apr.", hfd_apr=".$hfd_apr.", rno_apr=".$rno_apr.", rnf_apr=".$rnf_apr.", estado='Validada'
 where cod_epl='".$cod_epl."' and cod_epl_jefe='".$codigo_jefe."' and fecha='".$anio."-".$dia."-".$mes."'";

 //var_dump($sql);die("bn1");
 
 $rs=$conn->Execute($sql);	

echo "1";


?>