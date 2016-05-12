<?php
require_once("../librerias/lib/connection.php");


		global $conn;
		
		$anio=$_POST['anio'];		
		
		$mes=$_POST['mes'];
		
		if($mes=="1"){
			$anio=$anio-1;
			$mes_real="12";
		}else{
			$mes_real=$mes-1;
		}
		
		$codigo=$_POST['cod'];	
			
		
$sql="select (case when cod_ciclo6 != 'X'then cod_ciclo6
         when cod_ciclo5 != 'X' then cod_ciclo5
         when cod_ciclo4 !='X' then cod_ciclo6  
         else '' end) as ultimo_ciclo from prog_mes_tur where ano='$anio' and mes='$mes_real' and cod_epl='$codigo'";
		 
		

		
		
		$rs=$conn->Execute($sql);
		
		$row = $rs->fetchrow();
		
		$ciclo=$row['ultimo_ciclo'];
		
		echo $ciclo;
		
?>