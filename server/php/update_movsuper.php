<?php
$raiz="";
require_once('class_supernumerario.php');


$obj=new supernumerario();


	
	if(isset($_POST['cod_epl_reemp'])){
		
		/*Updta para reemplazo*/
		$datos=$obj->update_movreemp($_POST['id_super_nov'],$_POST['cod_epl_super'],$_POST['cod_epl_reemp'],$_POST['fec_ini'],$_POST['fec_fin'],$_POST['cod_epl_jefe'],
								 $_POST['cod_cc2'],$_POST['observaciones'],$_POST['tipo_baja'],$_POST['id_reemp_old']);
				
		if($datos==1){
			echo 1;	
		}else if($datos==2){
			echo 2;
		}else if($datos==3){
			echo 3;
		}else if($datos==4){
			echo 4;
		}
			
	}else{
		
		/*update para cubrimiento*/
		$datos=$obj->update_movcubri($_POST['id_super_nov'],$_POST['cubri_super'],$_POST['cubri_fecini'],$_POST['cubri_fecfin'],$_POST['cubri_jefe'],
								 $_POST['cubri_area'],$_POST['cubri_observa']);
				
		if($datos==1){
			echo 1;	
		}else if($datos==2){
			echo 2;
		}else if($datos==3){
			echo 3;
		}else if($datos==4){
			echo 4;
		}
	
	}
?>