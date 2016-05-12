<?php session_start();


require_once("../librerias/lib/connection.php");

global $conn;



$GLOBALS['ausencia']=$_POST['ausencia'];


if($_POST['modulo']==1){
	
	$sql="select cod_aus, (select max(cnsctvo)+1  from bs_ausencias_vac ) as consecutivo from conceptos_ausencias where cod_con=".$_POST['cod_con'];
	$rs = $conn->Execute($sql);

	$fila=$rs->FetchRow();
	$cod_aus=@$fila['cod_aus'];
	$cnsctvo=@$fila['consecutivo'];

	$sql3="insert into bs_ausencias_vac(cod_con,cod_epl,fec_ini,fec_fin,estado,cod_cc2,dias,cod_aus,fec_ini_r,fec_fin_r,cnsctvo,dias_pen,fecha)
	values(11,'".$_POST['cod_epl']."',convert(varchar,'".$_POST['fec_cau_ini']." 00:00:00.000',121),convert(varchar,'".$_POST['fec_cau_fin']." 00:00:00.000',121),
	'C','".$_POST['cod_cc2']."',".$_POST['dias'].",".$cod_aus.",convert(varchar,'".$_POST['fec_ini']." 00:00:00.000',121),convert(varchar,'".$_POST['fec_fin']." 00:00:00.000',121),'".$cnsctvo."',
	".$_POST['dias_pen'].",convert(varchar,'".$_POST['fec_ini']." 00:00:00.000',121))";
	
	$conn->Execute($sql3);

}else{

    //para las ausencias que no son vacaciones en disfrute
	$sql="select cod_aus, (select max(cnsctvo)+1  from ausencias ) as consecutivo from conceptos_ausencias where cod_con=".$_POST['cod_con'];

	$rs = $conn->Execute($sql);

	$fila=$rs->FetchRow();
	$cod_aus=@$fila['cod_aus'];
	$cnsctvo=@$fila['consecutivo'];
	
	$sql3="insert into ausencias(cod_con,cod_epl,fec_ini,fec_fin,estado,cod_cc2,dias,cod_aus,fec_ini_r,fec_fin_r,cnsctvo)
	values(".$_POST['cod_con'].",'".$_POST['cod_epl']."',convert(varchar,'".$_POST['fec_ini']." 00:00:00.000',121),convert(varchar,'".$_POST['fec_fin']." 00:00:00.000',121),
	'P','".$_POST['cod_cc2']."',".$_POST['dias'].",".$cod_aus.",convert(varchar,'".$_POST['fec_ini']." 00:00:00.000',121),convert(varchar,'".$_POST['fec_fin']." 00:00:00.000',121),".$cnsctvo.")";
	
	//var_dump($sql3);die();
	
	
	$conn->Execute($sql3);	// insertar las ausencia en la tabla ausencias
	
}

	$fecha_ini=explode("-",$_POST['fec_ini']);
	$fecha_fin=explode("-",$_POST['fec_fin']);
	
	

	
	
	/*=======================================================
		insertar ausencias en la tabla prog_novedades auditoria
	==========================================================*/
	$ausencias=strip_tags($GLOBALS['ausencia']);
	$sql="insert into prog_novedades values('".$_POST['cod_epl']."',".$_POST['anio'].",".$_POST['mes'].",'se ingresa ausencias de tipo: ".$ausencias." del empleado ".$_POST['cod_epl']."  desde: ".$fecha_ini[0]."-".$fecha_ini[1]."-".$fecha_ini[2]."  hasta: ".$fecha_fin[0]."-".$fecha_fin[1]."-".$fecha_fin[2]."','".$_POST['cod_epl_jefe']."',GETDATE (),2)";
	//var_dump($sql); die();
	$conn->Execute($sql);
	//auditoria reemplazos
	
	
	if(@(int)$_POST['reem_car'] != 0 && @(int)$_POST['reem_car'] !=1){
		
		$sql2="insert into prog_novedades values('".$_POST['cod_epl']."',".$_POST['anio'].",".$_POST['mes'].",'El empleado ".@$_POST['nom_reem']." realizar&aacute; un reemplazo  al empleado ".$_POST['nom_epl']." por motivo de la ausencia de tipo: ".$ausencias."  desde: ".$fecha_ini[0]."-".$fecha_ini[1]."-".$fecha_ini[2]."  hasta: ".$fecha_fin[0]."-".$fecha_fin[1]."-".$fecha_fin[2]."','".$_POST['cod_epl_jefe']."',GETDATE (),5)";
		//var_dump($sql2); die();
		$conn->Execute($sql2);
	}
	// fin de la auditoria =======================================
	
	
	/*Para verificar si tiene registro. si tiene entonces actualice si no inserte*/
	$sql3="select ID , (SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$_POST['mes']."-".$_POST['anio']."'  )+1, 0)))))as saber from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$_POST['mes']."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
	and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
	
	$rs3 = $conn->Execute($sql3);
	$fila3=$rs3->FetchRow();

   ($rs3->RecordCount() > 0)? $bandera=1 :$bandera=0;// bandera=1 tiene registro entonces actualice
													   // bandera=2 no tiene entonces inserte
		
   
	if($fecha_ini[1]==$fecha_fin[1]){ // si es el mismo mes
	
	
		if($bandera==1 && $_POST['reem_car']!= 1){
		
			$ban=1;
			pasar_turno($fecha_ini[0],$fecha_fin[0],$_POST['cod_epl'],$_POST['mes'],$_POST['anio'],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['cod_epl_jefe'],$_POST['reem_car'],$ban,$fecha_fin[1],$fecha_fin[2]);
			
			
		
		}else if($bandera==0){
		
			
			for($j=1; $j <=$fecha_ini[0]; $j++){
				
				
				if($bandera==0){
				
			

					$sql2="insert into prog_mes_tur(cod_epl,Mes,Td$j,Ano,cod_cc2,cod_car,cod_epl_jefe)
					 values('".$_POST['cod_epl']."','".$_POST['mes']."','N','".$_POST['anio']."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
					 
					
					$rs2 = $conn->Execute($sql2);
					$guardar_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
					
					$bandera=1;
				}else if($bandera==1){
				
					$sql3="update prog_mes_tur set  Td$j='N' where ID=".$guardar_id."";
					
					
					$rs3 = $conn->Execute($sql3);
				}
		
			}
		}
		
		
		(@$guardar_id!=NULL)? $id=$guardar_id : $id=$fila3['ID'];
		
		for($i=(int)$fecha_ini[0]; $i<=$fecha_fin[0]; $i++){

			$sql3="update prog_mes_tur set  Td$i='".$GLOBALS['ausencia']."' where ID=".$id."";
			$rs3 = $conn->Execute($sql3);
			
			if($i==$fecha_fin[0] && $id==$fila3['ID']){ $bandera=3;}else if($i==$fecha_fin[0] && $id==$guardar_id){ $bandera=4;}
	
		}

		if($fecha_fin[0] == 31){
			
			$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$id."";
			$r= $conn->Execute($s);
			$f=$r->fetchrow();
			
		}else{
		
			$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$id."";
			$r= $conn->Execute($s);
			$f=$r->fetchrow();
		
		}
		
		
		if(@$f['turno']== NULL){
			
			for($j=$fecha_fin[0]+1; $j<=31; $j++){
		
				$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
				$rs3 = $conn->Execute($sql3);
		
			}	
		}else{
		
			$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$_POST['mes']."-".$_POST['anio']."')+1, 0))))as saber";
			$r = $conn->Execute($s);
			$ro=$r->fetchrow();
			
			for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
			
				$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
				$rs3 = $conn->Execute($sql3);
			}

		}
		
		
		
		if($bandera==3){ //inicio bandera3
		
			$contar=contar_semana($fila3['ID'],$fecha_ini[1],$fecha_ini[2]);
		
			echo $contar;
			
		}else if($bandera==4){ echo 1;}else{echo 2;}
		
   
   }else{ // si se pasa el otro mes
   
		
		
		if($bandera==1){ // si tiene registro osea tiene programacion
		
	
	
			$sql10="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$_POST['mes']."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
					and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
			$rs10 = $conn->Execute($sql10);
			$fila10=$rs10->FetchRow();
			
			
			if($rs10->RecordCount() > 0  && $_POST['reem_car']!= 1){ //tiene programación y alguien que lo reemplaze
			//die("hola 1");
				$bandera=5;
				$ban=2;
				pasar_turno($fecha_ini[0],$fecha_fin[0],$_POST['cod_epl'],$_POST['mes'],$_POST['anio'],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['cod_epl_jefe'],$_POST['reem_car'],$ban,$fecha_fin[1],$fecha_fin[2]);
			}else if($rs10->RecordCount() ==0 && $_POST['reem_car']!= 1){
				//die("hola 2");
				$bandera=6;
				$ban=1;
				pasar_turno($fecha_ini[0],(int)$fila3['saber'],$_POST['cod_epl'],$_POST['mes'],$_POST['anio'],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['cod_epl_jefe'],$_POST['reem_car'],$ban,$fecha_fin[1],$fecha_fin[2]);
			
			}else if($rs10->RecordCount() > 0 && $_POST['reem_car']== 1){ // si hay programacion y  no tiene un $reemplazo $rs10->RecordCount() > 0 
			
				$bandera=5;
			
			}else if($rs10->RecordCount() ==0 && $_POST['reem_car']== 1){ // revisar
				//die("hola 4");
				$bandera=6;
			}
			
				
			for($i=$fecha_ini[0]; $i<=31; $i++){
				
				$sql4="update prog_mes_tur set  Td$i='".$GLOBALS['ausencia']."' where ID=".$fila3['ID']."";
				$rs4 = $conn->Execute($sql4);
				
			}
			
			
			
			contar_semana($fila10['ID'],$fecha_ini[1],$fecha_ini[2]);
			
			if($bandera==5){  // si hay programacion y  no tiene un reemplazo
				
				if(($fecha_ini[1] +1)== $fecha_fin[1] && ($fecha_ini[2]==$fecha_fin[2])){
					
					$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".($fecha_ini[1]+1)."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
					and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
					$rs = $conn->Execute($sql);
					$fila=$rs->FetchRow();
					
					if($rs->RecordCount() > 0){
					
						$id =$fila['ID'];
					}else{
						
						$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sql5);
						$id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");

					}
					
					
					for($j=1; $j <=(int)$fecha_fin[0]; $j++){
						
						$sql9="update prog_mes_tur set  Td$j='".$GLOBALS['ausencia']."' where ID=".$id."";
						$rs9 = $conn->Execute($sql9);
					}
					
					
					if($fecha_fin[0] == 31){
			
						$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$id."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
						
					}else{
					
						$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$id."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
					
					}
						
						
					if(@$f['turno']== NULL){
						
						for($j=$fecha_fin[0]+1; $j<=31; $j++){
					
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
							$rs3 = $conn->Execute($sql3);
					
						}	
					}else{ //para llenar el ultimo 
					
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
						
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
							$rs3 = $conn->Execute($sql3);
						}
					}
		
					
					$contar=contar_semana($id,$fecha_fin[1],$fecha_fin[2]);
					
				
					echo $contar;
					
				}else if($fecha_fin[2] > $fecha_ini[2]){
					
					
					
					for($m=($fecha_ini[1] +1); $m<=12; $m++){
						
						$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$m."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
							
						if($rs->RecordCount() > 0){
					
							$fila['ID'] =$fila['ID'];
							
						}else{
						
							$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$_POST['anio']."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
							$conn->Execute($sql5);
							$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
						}
							
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_ini[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						
						for($d=1; $d<=$ro['saber'];$d++){
							
							$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$conn->Execute($p);
						}
						
		            }
					
					
					
					if((int)$fecha_fin[1]==01){ // si el mes es igual a enero
						
						
						
						$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$fecha_fin[1]."' and Ano='".$fecha_fin[2]."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
							
						
							
						if($rs->RecordCount() > 0){
					
							$fila['ID'] =$fila['ID'];
						}else{
							
							$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
							$conn->Execute($sql5);
							$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");

						}
							
						
						for($m2=1; $m2<=$fecha_fin[0]; $m2++){
							
							$p="update prog_mes_tur set  Td$m2='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$conn->Execute($p);
							
						}
						
					
					
						if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$fila['ID']."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
						}else{
						
							$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$fila['ID']."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
						
						}
						
						
						if(@$f['turno']== NULL){
							
							for($j=$fecha_fin[0]+1; $j<=31; $j++){
						
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$rs3 = $conn->Execute($sql3);
						
							}	
						}else{ //para llenar el ultimo 
						
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
							
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$rs3 = $conn->Execute($sql3);
							}
						}
						
						if($rs3){ echo 1;}else{ echo 2;}
						
						
					}else{
					
					
						for($m=1; $m<=($fecha_fin[1]-1); $m++){
							
							$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$m."' and Ano='".$fecha_fin[2]."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
							
							
							if($rs->RecordCount() > 0){
					
							$fila['ID'] =$fila['ID'];
							
							}else{
								
								$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
								$conn->Execute($sql5);
								$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");

							}
						
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							
							for($d=1; $d<=$ro['saber'];$d++){
								
								$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$conn->Execute($p);
							}
						}
						
							
							$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$fecha_fin[1]."' and Ano='".$fecha_fin[2]."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
							
							if($rs->RecordCount() > 0){
					
								$fila['ID'] =$fila['ID'];
							
							}else{
								
								$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
								$conn->Execute($sql5);
								$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");

							}
							
							
							for($m2=1; $m2<=$fecha_fin[0];$m2++){
						
								$p="update prog_mes_tur set  Td$m2='".$GLOBALS['ausencia']."' where ID=".$fila['ID']."";
								$conn->Execute($p);
						
							}
							
							if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$fila['ID']."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
							}else{
							
								$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$fila['ID']."";
								$r= $conn->Execute($s);
								$f=$r->fetchrow();
							
							}
						
						
						if(@$f['turno']== NULL){
							
							for($j=$fecha_fin[0]+1; $j<=31; $j++){
						
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$rs3 = $conn->Execute($sql3);
						
							}	
						}else{ //para llenar el ultimo 
						
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
							
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$rs3 = $conn->Execute($sql3);
							}

						}
						
						$contar=contar_semana($fila['ID'],$fecha_fin[1],$fecha_fin[2]);
											
										
						echo $contar;	
						
						//if($rs3){ echo 1;}else{ echo 2;}
						
					}
				}else if($fecha_fin[1] >($fecha_ini[1] +1)  && ($fecha_ini[2]==$fecha_fin[2])){
					
					
					for($m=($fecha_ini[1] +1); $m<=($fecha_fin[1] - 1); $m++){
						
						$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$m."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
						
						if($rs->RecordCount() > 0){
					
							$fila['ID'] =$fila['ID'];
						}else{
							
							$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
							$conn->Execute($sql5);
							$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");

						}

						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_ini[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						
						for($d=1; $d<=$ro['saber'];$d++){
							
							$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$conn->Execute($p);
						}
					
					}
					
					
					$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$fecha_fin[1]."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
					
					if($rs->RecordCount() > 0){
					
							$fila['ID'] =$fila['ID'];
					}else{
							
							$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$_POST['anio']."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
							$conn->Execute($sql5);
							$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");

					}
							
					for($m=1;$m<=$fecha_fin[0];$m++){
					
						$p="update prog_mes_tur set  Td$m='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
						$conn->Execute($p);
					}
						
					if($fecha_fin[0] == 31){
		
						$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$fila['ID']."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
						
					}else{
					
						$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$fila['ID']."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
					
					}
						
						
					if(@$f['turno']== NULL){
						
						for($j=$fecha_fin[0]+1; $j<=31; $j++){
					
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$rs3=$conn->Execute($sql3);
					
						}	
					}else{ //para llenar el ultimo 
					
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
						
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$rs3 = $conn->Execute($sql3);
						}

					}
					
					if($rs3){ echo 1;}else{ echo 2;}
				
				
				}
				
				
					
			}else{
			
				
				if(($fecha_ini[1] +1)== $fecha_fin[1] && ($fecha_ini[2]==$fecha_fin[2])){
					
					$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
					 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
					$conn->Execute($sql5);
					$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
					
					
					for($j=2; $j <=(int)$fecha_fin[0]; $j++){
						
						$sql9="update prog_mes_tur set  Td$j='".$GLOBALS['ausencia']."' where ID=".$new_id."";
						$rs9 = $conn->Execute($sql9);
					}
					
				    
					if($fecha_fin[0] == 31){
			
						$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$new_id."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
						
					}else{
					
						$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$new_id."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
					
					}
						
						
					if(@$f['turno']== NULL){
						
						for($j=$fecha_fin[0]+1; $j<=31; $j++){
					
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$rs3 = $conn->Execute($sql3);
					
						}	
					}else{ //para llenar el ultimo 
					
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
						
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$rs3 = $conn->Execute($sql3);
						}
					}
					
					if($rs3){ echo 1;}else{ echo 2;}
					
				
				}else if($fecha_fin[2] > $fecha_ini[2]){// inicio else
					
					
					//llenar los meses faltantes del año a vencer
					for($m=($fecha_ini[1] +1); $m<=12; $m++){
						
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_ini[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$fecha_ini[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sql5);
						$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
						
						
						for($d=1; $d<=$ro['saber'];$d++){
							
							$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$conn->Execute($p);
						}
					}
					
					if((int)$fecha_fin[1]==01){ // si el mes es igual a enero
					
						$sq5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$_POST['cod_epl']."','01','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sq5);
						$new=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
						
					
						for($m2=1; $m2<=$fecha_fin[0]; $m2++){
							
							$p="update prog_mes_tur set  Td$m2='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new."";
							$conn->Execute($p);
							
						}
						
						if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$new."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
						}else{
						
							$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$new."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
						
						}
						
						
						if(@$f['turno']== NULL){
							
							for($j=$fecha_fin[0]+1; $j<=31; $j++){
						
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new."";
								$rs3 = $conn->Execute($sql3);
						
							}	
						}else{ //para llenar el ultimo 
						
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
							
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new."";
								$rs3 = $conn->Execute($sql3);
							}
						}
						
						if($rs3){ echo 1;}else{ echo 2;}
						
						
					
					}else{ //inicio else
						
						for($m=1; $m<=($fecha_fin[1]-1); $m++){
						
							
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
							$conn->Execute($sql5);
							$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							
							
							for($d=1; $d<=$ro['saber'];$d++){
								
								$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
								$conn->Execute($p);
							}
						
						}
						
						$sq="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sq);
						$n=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
						
							
						for($m2=1; $m2<=$fecha_fin[0];$m2++){
						
							$p="update prog_mes_tur set  Td$m2='".$GLOBALS['ausencia']."' where ID=".$n."";
							$conn->Execute($p);
						
						}
						
						
						if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$n."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
						}else{
						
							$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$n."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
						
						}
						
						
						if(@$f['turno']== NULL){
							
							for($j=$fecha_fin[0]+1; $j<=31; $j++){
						
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$n."";
								$rs3 = $conn->Execute($sql3);
						
							}	
						}else{ //para llenar el ultimo 
						
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
							
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
								$rs3 = $conn->Execute($sql3);
							}

						}
										
						if($rs3){ echo 1;}else{ echo 2;}
					
					}// fin else
					
					
					
				}else if($fecha_fin[1] >($fecha_ini[1] +1)  && ($fecha_ini[2]==$fecha_fin[2])){
				
					
					for($m=($fecha_ini[1] +1); $m<=($fecha_fin[1] - 1); $m++){
						
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_ini[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$fecha_ini[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sql5);
						$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
						
						for($d=1; $d<=$ro['saber'];$d++){
							
							$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$conn->Execute($p);
						}
					}
					
					$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_ini[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sql5);
						$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
					
					
					for($m=1;$m<=$fecha_fin[0];$m++){
						
						$p="update prog_mes_tur set  Td$m='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
						$conn->Execute($p);

					}


					if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$new_id."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
					}else{
					
						$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$new_id."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
					
					}
						
						
					if(@$f['turno']== NULL){
						
						for($j=$fecha_fin[0]+1; $j<=31; $j++){
					
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$rs3=$conn->Execute($sql3);
					
						}	
					}else{ //para llenar el ultimo 
					
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
						
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$rs3 = $conn->Execute($sql3);
						}

					}
					
					if($rs3){ echo 1;}else{ echo 2;}
				
				
				}// fin else
				
				
				
			}
			
		}else{
		
			
			
			for($i=1; $i < $fecha_ini[0]; $i++){
				
				if($bandera==0){
				
					$sql2="insert into prog_mes_tur(cod_epl,Mes,Td$i,Ano,cod_cc2,cod_car,cod_epl_jefe)
					 values('".$_POST['cod_epl']."','".$_POST['mes']."','N','".$_POST['anio']."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
					$rs2 = $conn->Execute($sql2);
					$guardar_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
					
					$bandera=1;
				}else if($bandera==1){
				
					$sql3="update prog_mes_tur set  Td$i='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$guardar_id."";
					$rs3 = $conn->Execute($sql3);
				}
			
			}
			

			$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$_POST['mes']."-".$_POST['anio']."')+1, 0))))as saber";
			$r = $conn->Execute($s);
			$ro=$r->fetchrow();
			
			for($t=(int)$fecha_ini[0]; $t<=(int)$ro['saber']; $t++){
				
				$sq="update prog_mes_tur set Td$t='".$GLOBALS['ausencia']."' where ID=".$guardar_id."";
				$conn->Execute($sq);
				
			}
			
			for($j=(int)$ro['saber']+1; $j<=31; $j++){
			
				$sq="update prog_mes_tur set Td$j='X' where ID=".$guardar_id."";
				$conn->Execute($sq);
			}
			
			
			$sql10="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$fecha_fin[1]."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
				and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
			$rs10 = $conn->Execute($sql10);
			$fila10=$rs10->FetchRow();
			
			
			
			if($rs10->RecordCount() > 0 && $_POST['reem_car']!= 1){
				$bandera=5; 
				$ban=2;
				pasar_turno(1,$fecha_fin[0],$_POST['cod_epl'],$fecha_fin[1],$fecha_fin[2],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['cod_epl_jefe'],$_POST['reem_car'],$ban,$fecha_fin[1],$fecha_fin[2]);
				//pasar_turno($fecha_ini[0],(int)$fila3['saber'],$_POST['cod_epl'],$_POST['mes'],$_POST['anio'],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['cod_epl_jefe'],$_POST['reem_car'],$ban,$fecha_fin[1],$fecha_fin[2]);
			}else if($rs10->RecordCount() == 0 && $_POST['reem_car']== 1){
				
				$bandera=6;
			}else if($rs10->RecordCount() > 0 && $_POST['reem_car']== 1){
				
				$bandera=5;
				 
			}
			
			//$fec_ini,$fec_fin,$cod_epl,$mes,$anio,$cod_cc2,$cod_car,$cod_epl_jefe,$reemplazo,$ban,$mes_fin,$ano_fin
			
			if($bandera==5){
				
				if(($fecha_ini[1] +1)== $fecha_fin[1] && ($fecha_ini[2]==$fecha_fin[2])){
					
					
					$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".($fecha_ini[1]+1)."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
					and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
					$rs = $conn->Execute($sql);
					$fila=$rs->FetchRow();
					
					
					
					
					for($j=1; $j <=(int)$fecha_fin[0]; $j++){
						
						$sql9="update prog_mes_tur set  Td$j='".$GLOBALS['ausencia']."' where ID=".$fila['ID']."";
						$rs9 = $conn->Execute($sql9);
					}
					
					$contar=contar_semana($fila['ID'],($fecha_ini[1]+1),$fecha_fin[2]);
					
				
					echo $contar;
					
				}else if($fecha_fin[2] > $fecha_ini[2]){
					
					for($m=($fecha_ini[1] +1); $m<=12; $m++){
						
						$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$m."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
						
						if($rs->RecordCount() > 0){
					
							$fila['ID'] =$fila['ID'];
						}else{
							
							$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$_POST['anio']."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
							$conn->Execute($sql5);
							$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
						
						
						}
							
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_ini[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						for($d=1; $d<=$ro['saber'];$d++){
							
							$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$conn->Execute($p);
						}
						
		            }
					
					if((int)$fecha_fin[1]==01){ // si el mes es igual a enero
						
						$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$fecha_fin[1]."' and Ano='".$fecha_fin[2]."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
							
							
						if($rs->RecordCount() > 0){
					
							$fila['ID'] =$fila['ID'];
						}else{
							
							$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
							$conn->Execute($sql5);
							$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
						
						}
							
							
						
						for($m2=1; $m2<=$fecha_fin[0]; $m2++){
							
							$p="update prog_mes_tur set  Td$m2='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$conn->Execute($p);
							
						}
					
						if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$fila['ID']."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
						}else{
						
							$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$fila['ID']."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
						
						}
						
						
						if(@$f['turno']== NULL){
							
							for($j=$fecha_fin[0]+1; $j<=31; $j++){
						
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$rs3 = $conn->Execute($sql3);
						
							}	
						}else{ //para llenar el ultimo 
						
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
							
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$rs3 = $conn->Execute($sql3);
							}
						}
						
						if($rs3){ echo 1;}else{ echo 2;}
						
						
					}else{
					
						for($m=1; $m<=($fecha_fin[1]-1); $m++){
							
							$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$m."' and Ano='".$fecha_fin[2]."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
							
							
							if($rs->RecordCount() > 0){
					
								$fila['ID'] =$fila['ID'];
							}else{
								
								$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
								$conn->Execute($sql5);
								$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							
							
							}
							
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							for($d=1; $d<=$ro['saber'];$d++){
								
								$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$conn->Execute($p);
							}
						}
						
							
							$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$fecha_fin[1]."' and Ano='".$fecha_fin[2]."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
							
							if($rs->RecordCount() > 0){
					
								$fila['ID'] =$fila['ID'];
							}else{
								
								$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
								$conn->Execute($sql5);
								$fila['ID']=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
								
							}
							
							
							for($m2=1; $m2<=$fecha_fin[0];$m2++){
						
								$p="update prog_mes_tur set  Td$m2='".$GLOBALS['ausencia']."' where ID=".$fila['ID']."";
								$conn->Execute($p);
						
							}
							
							if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$fila['ID']."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
							}else{
							
								$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$fila['ID']."";
								$r= $conn->Execute($s);
								$f=$r->fetchrow();
							
							}
						
						
						if(@$f['turno']== NULL){
							
							for($j=$fecha_fin[0]+1; $j<=31; $j++){
						
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$rs3 = $conn->Execute($sql3);
						
							}	
						}else{ //para llenar el ultimo 
						
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
							
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
								$rs3 = $conn->Execute($sql3);
							}

						}
										
						if($rs3){ echo 1;}else{ echo 2;}
						
						
						
					
					}
				}else if($fecha_fin[1] >($fecha_ini[1] +1)  && ($fecha_ini[2]==$fecha_fin[2])){
					
					
					for($m=($fecha_ini[1] +1); $m<=($fecha_fin[1] - 1); $m++){
						
						$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$m."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
						

						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_ini[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						
						for($d=1; $d<=$ro['saber'];$d++){
							
							$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$conn->Execute($p);
						}
					
					}
					
					
					$sql="select ID from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes='".$fecha_fin[1]."' and Ano='".$_POST['anio']."' and cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."'
							and cod_epl_jefe='".$_POST['cod_epl_jefe']."'";
							$rs = $conn->Execute($sql);
							$fila=$rs->FetchRow();
							
					for($m=1;$m<=$fecha_fin[0];$m++){
					
						$p="update prog_mes_tur set  Td$m='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
						$conn->Execute($p);
					}
						
					if($fecha_fin[0] == 31){
		
						$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$fila['ID']."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
						
					}else{
					
						$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$fila['ID']."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
					
					}
						
						
					if(@$f['turno']== NULL){
						
						for($j=$fecha_fin[0]+1; $j<=31; $j++){
					
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$rs3=$conn->Execute($sql3);
					
						}	
					}else{ //para llenar el ultimo 
					
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
						
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$fila['ID']."";
							$rs3 = $conn->Execute($sql3);
						}

					}
					
					if($rs3){ echo 1;}else{ echo 2;}
				
				
				}
				
				
					
			}else{
			
				
				if(($fecha_ini[1] +1)== $fecha_fin[1] && ($fecha_ini[2]==$fecha_fin[2])){
					
					$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
					 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
					$conn->Execute($sql5);
					$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
					
					for($j=2; $j <=(int)$fecha_fin[0]; $j++){
						
						$sql9="update prog_mes_tur set  Td$j='".$GLOBALS['ausencia']."' where ID=".$new_id."";
						$rs9 = $conn->Execute($sql9);
					}
					
				    
					if($fecha_fin[0] == 31){
			
						$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$new_id."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
						
					}else{
					
						$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$new_id."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
					
					}
						
						
					if(@$f['turno']== NULL){
						
						for($j=$fecha_fin[0]+1; $j<=31; $j++){
					
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$rs3 = $conn->Execute($sql3);
					
						}	
					}else{ //para llenar el ultimo 
					
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
						
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$rs3 = $conn->Execute($sql3);
						}
					}
					
					if($rs3){ echo 1;}else{ echo 2;}
					
				
				}else if($fecha_fin[2] > $fecha_ini[2]){// inicio else
					
					
					//llenar los meses faltantes del año a vencer
					for($m=($fecha_ini[1] +1); $m<=12; $m++){
						
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_ini[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$fecha_ini[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sql5);
						$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");

						
						for($d=1; $d<=$ro['saber'];$d++){
							
							$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$conn->Execute($p);
						}
					}
					
					if((int)$fecha_fin[1]==01){ // si el mes es igual a enero
					
						$sq5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$_POST['cod_epl']."','01','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sq5);
						$new=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");

					
						for($m2=1; $m2<=$fecha_fin[0]; $m2++){
							
							$p="update prog_mes_tur set  Td$m2='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new."";
							$conn->Execute($p);
							
						}
						
						if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$new."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
						}else{
						
							$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$new."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
						
						}
						
						
						if(@$f['turno']== NULL){
							
							for($j=$fecha_fin[0]+1; $j<=31; $j++){
						
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new."";
								$rs3 = $conn->Execute($sql3);
						
							}	
						}else{ //para llenar el ultimo 
						
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
							
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new."";
								$rs3 = $conn->Execute($sql3);
							}
						}
						
						if($rs3){ echo 1;}else{ echo 2;}
						
						
					
					}else{ //inicio else
						
						for($m=1; $m<=($fecha_fin[1]-1); $m++){
						
							
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
							$conn->Execute($sql5);
							$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							
							for($d=1; $d<=$ro['saber'];$d++){
								
								$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
								$conn->Execute($p);
							}
						
						}
						
						$sq="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_fin[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sq);
						$n=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							
						for($m2=1; $m2<=$fecha_fin[0];$m2++){
						
							$p="update prog_mes_tur set  Td$m2='".$GLOBALS['ausencia']."' where ID=".$n."";
							$conn->Execute($p);
						
						}
						
						
						if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$n."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
						}else{
						
							$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$n."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
						
						}
						
						
						if(@$f['turno']== NULL){
							
							for($j=$fecha_fin[0]+1; $j<=31; $j++){
						
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$n."";
								$rs3 = $conn->Execute($sql3);
						
							}	
						}else{ //para llenar el ultimo 
						
							$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
							$r = $conn->Execute($s);
							$ro=$r->fetchrow();
							
							for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
							
								$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
								$rs3 = $conn->Execute($sql3);
							}

						}
										
						if($rs3){ echo 1;}else{ echo 2;}
					
					}// fin else
					
					
					
				}else if($fecha_fin[1] >($fecha_ini[1] +1)  && ($fecha_ini[2]==$fecha_fin[2])){
				
					
					for($m=($fecha_ini[1] +1); $m<=($fecha_fin[1] - 1); $m++){
						
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$fecha_ini[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$_POST['cod_epl']."','".$m."','".$GLOBALS['ausencia']."','".$fecha_ini[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sql5);
						$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");

						
						for($d=1; $d<=$ro['saber'];$d++){
							
							$p="update prog_mes_tur set  Td$d='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$conn->Execute($p);
						}
					}
					
					$sql5="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$_POST['cod_epl']."','".$fecha_fin[1]."','".$GLOBALS['ausencia']."','".$fecha_ini[2]."','".$_POST['cod_cc2']."','".$_POST['cod_car']."','".$_POST['cod_epl_jefe']."')";
						$conn->Execute($sql5);
						$new_id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
					
					
					for($m=1;$m<=$fecha_fin[0];$m++){
						
						$p="update prog_mes_tur set  Td$m='".$GLOBALS['ausencia']."', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
						$conn->Execute($p);

					}


					if($fecha_fin[0] == 31){
			
							$s="select Td".$fecha_fin[0]." as turno from prog_mes_tur where ID=".$new_id."";
							$r= $conn->Execute($s);
							$f=$r->fetchrow();
							
					}else{
					
						$s="select Td".($fecha_fin[0]+1)." as turno from prog_mes_tur where ID=".$new_id."";
						$r= $conn->Execute($s);
						$f=$r->fetchrow();
					
					}
						
						
					if(@$f['turno']== NULL){
						
						for($j=$fecha_fin[0]+1; $j<=31; $j++){
					
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$rs3=$conn->Execute($sql3);
					
						}	
					}else{ //para llenar el ultimo 
					
						$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$fecha_fin[1]."-".$fecha_fin[2]."')+1, 0))))as saber";
						$r = $conn->Execute($s);
						$ro=$r->fetchrow();
						
						for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
						
							$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$new_id."";
							$rs3 = $conn->Execute($sql3);
						}

					}
					
					if($rs3){ echo 1;}else{ echo 2;}
				
				
				}// fin else
				
				
				
			}
			
			
			
			
		
		}
		

   }
  
 
 function pasar_turno($fec_ini,$fec_fin,$cod_epl,$mes,$anio,$cod_cc2,$cod_car,$cod_epl_jefe,$reemplazo,$ban,$mes_fin,$ano_fin){

	global $conn;
	
	$flag=1; // para pasar el primer turno
	if($ban==1){
	
		$sql="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";

		$find = $conn->Execute($sql);
		$row_find=$find->fetchrow();
		
		($find->RecordCount() > 0)? $v=0 :$v=1;
		
		if($v==1){
		 
			for($j=1; $j<$fec_ini; $j++){
				if($flag==1){ // mejorar codigo
					
					$fec_ini_r=$fec_ini."-".$mes."-".$anio;
					$fec_fin_r=$fec_fin."-".$mes."-".$anio;
				
					$s3="SELECT cod_epl_reemp
						FROM supernumerario_nov 
						WHERE 
						(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
						AND cod_epl_super='".$reemplazo."'";
						
					$r3= $conn->Execute($s3);
					
					if($r3->RecordCount() > 0){
						$sql2="insert into prog_mes_tur(cod_epl,Mes,Td$j,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$reemplazo."','".$mes."','N','".$anio."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";

							$rs2 = $conn->Execute($sql2);
							$id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							$flag=2;
						
					}else{
						
						
						$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
						from  empleados_basic as bas, empleados_gral gral
						where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
						
							$reg= $conn->Execute($sql3);
							$fila=$reg->fetchrow();
							
							if($reg->RecordCount() > 0){
								
								$cod_cc2_2=$fila['cod_cc2'];
								$cod_car2=$fila['cod_car'];
								$cod_epl_jefe2=$fila['cod_jefe'];
								
								$sql="select ID, Td".$j." from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";
								

								$find = $conn->Execute($sql);
								$row_find=$find->fetchrow();
								$id=$row_find['ID'];
								
								($find->RecordCount() > 0)? $flag=2 :$flag=1;
								
								
							}else{
							
								
									
									$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
								
							
							}
							
							if($flag==1){
								
								$sql2="insert into prog_mes_tur(cod_epl,Mes,Td$j,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$reemplazo."','".$mes."','N','".$anio."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
								$rs2 = $conn->Execute($sql2);
								$id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
								$flag=2;
							
							}else if($flag==2  && @$row_find['Td'.$j]== NULL){
							
							
								$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id."";
								$rs3 = $conn->Execute($sql3);
							
							}else if(@$row_find['Td'.$j] != NULL){
							
								 break;
								
							}
							
					}
					
					
				}else if($flag==2){
				
					$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id."";
					$rs3 = $conn->Execute($sql3);
				
				}
			}
		}
		
	
		(@$id!=NULL)? $id=$id : $id=$row_find['ID'];
		
		for($i=$fec_ini; $i<=$fec_fin; $i++){

			$sql="select Td$i as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
					and cod_epl_jefe='".$cod_epl_jefe."'"; 
					
			$rs = $conn->Execute($sql);
			$row=$rs->fetchrow();
		
			$sql3="update prog_mes_tur set  Td$i='".$row['turno']."' where ID=".$id."";
			$rs3 = $conn->Execute($sql3);	
							
		}
		
		
		if($fec_fin == 31){
			
			$s="select Td".$fec_fin." as turno from prog_mes_tur where ID=".$id."";
			$r= $conn->Execute($s);
			$f=$r->fetchrow();
			
		}else{
		
			$s="select Td".($fec_fin+1)." as turno from prog_mes_tur where ID=".$id."";
			$r= $conn->Execute($s);
			$f=$r->fetchrow();
		
		}
		
		
		if(@$f['turno']== NULL){
			
			for($j=$fec_fin+1; $j<=31; $j++){
		
				$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
				$rs3 = $conn->Execute($sql3);
		
			}	
		}
			

		contar_semana($id,$mes,$anio);
		
	}else if($ban==2){
	
		
		$sql="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";
		$find = $conn->Execute($sql);
		$row_find=$find->fetchrow();
		
		($find->RecordCount() > 0)? $v=0 :$v=1;
		
		
		if($v==1){
			
			
			for($j=1; $j<$fec_ini; $j++){
		
				if($flag==1){ // mejorar codigo
					
					$fec_ini_r=$fec_ini."-".$mes."-".$anio;
					
					$sql9="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".($mes)."-".$anio."'  )+1, 0))))as saber"; 
				    $rs9 = $conn->Execute($sql9);
				    $row=$rs9->fetchrow();
				    $saber2=(int)@$row['saber'];
				
				   $fec_fin_r=$saber2."-".$mes."-".$anio;
									
					
					
					$s3="SELECT cod_epl_reemp
						FROM supernumerario_nov 
						WHERE 
						(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
						AND cod_epl_super='".$reemplazo."'";
					//var_dump
						
						
					$r3= $conn->Execute($s3);
					
					if($r3->RecordCount() > 0){
					
						$sql2="insert into prog_mes_tur(cod_epl,Mes,Td$j,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$reemplazo."','".$mes."','N','".$anio."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";
							 
							$rs2 = $conn->Execute($sql2);
							$id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							$flag=2;
					
					
					}else{
					
						$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
						from  empleados_basic as bas, empleados_gral gral
						where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
						$reg= $conn->Execute($sql3);
						$fila=$reg->fetchrow();
						
						if($reg->RecordCount() > 0){
							
							$cod_cc2_2=$fila['cod_cc2'];
							$cod_car2=$fila['cod_car'];
							$cod_epl_jefe2=$fila['cod_jefe'];
							
							$sql="select ID, Td".$j." from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";
								

								$find = $conn->Execute($sql);
								$row_find=$find->fetchrow();
								$id=$row_find['ID'];
								
								($find->RecordCount() > 0)? $flag=2 :$flag=1;
							
						}else{
						
							$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
						
						}
						
						
						
						if($flag==1){
								
							$sql2="insert into prog_mes_tur(cod_epl,Mes,Td$j,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$reemplazo."','".$mes."','N','".$anio."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
							$rs2 = $conn->Execute($sql2);
							$id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							$flag=2;
						
						}else if($flag==2  && @$row_find['Td'.$j]== NULL){
						
							$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id."";
							$rs3 = $conn->Execute($sql3);
						
						}else if(@$row_find['Td'.$j] != NULL){
						
							 break;
							
						}
					
					}
					
					
				}else if($flag==2){
				
					$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id."";
					$rs3 = $conn->Execute($sql3);
				
				}
			}
			
			
		}
		
		
		
		(@$id!=NULL)? $id=$id : $id=$row_find['ID'];
		
		$sql8="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$mes."-".$anio."'  )+1, 0))))as saber"; 
		$rs8 = $conn->Execute($sql8);
		$row=$rs8->fetchrow();
		$saber=(int)@$row['saber'];
		
		for($j=$fec_ini; $j<=$saber; $j++){
			
			$sql="select Td$j as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
				and cod_epl_jefe='".$cod_epl_jefe."'";
				
			$rs = $conn->Execute($sql);
			$row=$rs->fetchrow();
			
			$sql3="update prog_mes_tur set  Td$j='".$row['turno']."' where ID=".$id."";
			$rs3 = $conn->Execute($sql3);	
		
		}
		
		
		for($p=$saber +1; $j<=31; $j++){
			
			$s="update prog_mes_tur set  Td$j='X' where ID=".$id."";
			$r = $conn->Execute($s);
		
		}
		
		contar_semana($id,$mes,$anio);
		
		//$mes_fin,$ano_fin
		
		//die("hola");
		$flag=1;
		if(($mes +1)== (int)$mes_fin && ((int)$ano_fin==(int)$anio)){//el año inical es igual al año fin
		
			
			$sql1="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".($mes+1)."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";
			$find2 = $conn->Execute($sql1);
			$row_find2=$find2->fetchrow();
			
			($find2->RecordCount() > 0)? $v=0 :$v=1;
			
			
			if($v==1){
				
			
				$sql10="select Td1 as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".($mes+1)."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
					and cod_epl_jefe='".$cod_epl_jefe."'";	
				//var_dump($sql10); die();
				$rs10 = $conn->Execute($sql10);
				
				if($rs10->RecordCount() > 0){ // sie el otro mes tiene turnos si no retorne 1
					
					$row=$rs10->FetchRow();
						
				}else{
				
					return 1;
				}
				
				
				$fec_ini_r=$fec_ini."-".$mes."-".$anio;
				
				$sql9="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".($mes)."-".$anio."'  )+1, 0))))as saber"; 
				$rs9 = $conn->Execute($sql9);
				$row=$rs9->fetchrow();
				$saber2=(int)@$row['saber'];
				
				$fec_fin_r=$saber2."-".$mes."-".$anio;
					
				$s3="SELECT cod_epl_reemp
					FROM supernumerario_nov 
					WHERE 
					(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
					AND cod_epl_super='".$reemplazo."'";

				$r3= $conn->Execute($s3);
				
				if($r3->RecordCount() > 0){
					
					$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$reemplazo."','".($mes+1)."','N','".$anio."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";
						$rs2 = $conn->Execute($sql2);
						$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
						
					
				
				
				}else{//inicio else
					
					$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
						from  empleados_basic as bas, empleados_gral gral
						where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
						$reg= $conn->Execute($sql3);
						$fila=$reg->fetchrow();
						
						if($reg->RecordCount() > 0){
									
							$cod_cc2_2=$fila['cod_cc2'];
							$cod_car2=$fila['cod_car'];
							$cod_epl_jefe2=$fila['cod_jefe'];
							
							$sql="select ID, Td1 from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".($mes+1)."' and Ano='".$anio."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";
								

							$find = $conn->Execute($sql);
							$row_find=$find->fetchrow();
							$id2=$row_find['ID'];
							
							($find->RecordCount() > 0)? $flag=2 :$flag=1;
									
						}else{
						
							$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
							
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
						
						}

						if($flag==1){
								
							$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$reemplazo."','".($mes+1)."','N','".$anio."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
							
							$rs2 = $conn->Execute($sql2);
							$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							$flag=2;
							
						}else if($flag==2  && @$row_find['Td'.$j]== NULL){
						
						
							$sql3="update prog_mes_tur set  Td1='N' where ID=".$id2."";

							$rs3 = $conn->Execute($sql3);
						
						}

					}// fin else
				
			}	
			
				/*	}else{ // retorno 1 porque no tiene turnos el mes anterior entonces no hay nada que copiar
						
						return 1;
					}*/
			
			(@$id2!=NULL)? $id=$id2 : $id=$row_find2['ID'];
			
			for($i=1; $i<=$fec_fin; $i++){
				
				$sql="select Td$i as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".($mes+1)."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
					and cod_epl_jefe='".$cod_epl_jefe."'";
				$rs = $conn->Execute($sql);
				$row=$rs->fetchrow();
				
				$sql3="update prog_mes_tur set  Td$i='".$row['turno']."' where ID=".$id."";
				$rs3 = $conn->Execute($sql3);
				
			
			}
			
			
			
			if($fec_fin == 31){
			 
				
				$s="select Td".$fec_fin." as turno from prog_mes_tur where ID=".$id."";
				$r= $conn->Execute($s);
				$f=$r->fetchrow();
				
			}else{
				
				
				$s="select Td".($fec_fin+1)." as turno from prog_mes_tur where ID=".$id."";
				$r= $conn->Execute($s);
				$f=$r->fetchrow();
			
			}
			
			if(@$f['turno'] ==NULL){
				
				for($j=$fec_fin +1; $j<= 31; $j++){
			
					$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
					$rs3 = $conn->Execute($sql3);
			
				}
				
			
			}else{
			
				$sql9="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".($mes+1)."-".$anio."'  )+1, 0))))as saber"; 
				$rs9 = $conn->Execute($sql9);
				$row=$rs9->fetchrow();
				$saber2=(int)@$row['saber'];
				
				for($j=$saber2 +1; $j<= 31; $j++){
				
					$sql3="update prog_mes_tur set  Td$j='X' where ID=".$id."";
					$rs3 = $conn->Execute($sql3);
				
				}
				
			}
			
			contar_semana($id,($mes+1),$anio);
			
			
			
			
		
		}else if((int)$ano_fin > (int)$anio){ // el año fin es mayor al año ininicial
		
			
			for($m=($mes+1); $m<=12; $m++){ //inicio for
				
				$sql1="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$m."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";
				$find2 = $conn->Execute($sql1);
				$row_find2=$find2->fetchrow();
				
				
				($find2->RecordCount() > 0)? $v=0 :$v=1;
				
				
				if($v==1){
				
					$sql10="select Td1 as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$m."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
						and cod_epl_jefe='".$cod_epl_jefe."'";	
					//var_dump($sql10); die();
					$rs10 = $conn->Execute($sql10);
					$row=$rs10->FetchRow();
					
					
					$fec_ini_r=$fec_ini."-".$mes."-".$anio;
					$fec_fin_r=$fec_fin."-".$mes_fin."-".$ano_fin;
						
					$s3="SELECT cod_epl_reemp
						FROM supernumerario_nov 
						WHERE 
						(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
						AND cod_epl_super='".$reemplazo."'";
						
					$r3= $conn->Execute($s3);
					
					if($r3->RecordCount() > 0){
						
						$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$reemplazo."','".$m."','N','".$anio."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";
							$rs2 = $conn->Execute($sql2);
							$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							
					
					}else{//inicio else
						
						$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
							from  empleados_basic as bas, empleados_gral gral
							where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
							$reg= $conn->Execute($sql3);
							$fila=$reg->fetchrow();
							
							if($reg->RecordCount() > 0){
										
								$cod_cc2_2=$fila['cod_cc2'];
								$cod_car2=$fila['cod_car'];
								$cod_epl_jefe2=$fila['cod_jefe'];
								
								$sql="select ID, Td1 from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";
								

								$find = $conn->Execute($sql);
								$row_find=$find->fetchrow();
								$id2=$row_find['ID'];
								
								($find->RecordCount() > 0)? $flag=2 :$flag=1;
										
							}else{
							
								$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
							
							}
							
						
							if($flag==1){
								
								$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$reemplazo."','".$mes."','N','".$anio."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
								$rs2 = $conn->Execute($sql2);
								$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
								$flag=2;
							
							}else if($flag==2  && @$row_find['Td1']== NULL){
							
							
								$sql3="update prog_mes_tur set  Td1='N' where ID=".$id2."";
								$rs3 = $conn->Execute($sql3);
							
							}

					}// fin else
					
				}
				
				
				(@$id2!=NULL)? $id=$id2 : $id=$row_find2['ID'];
					
				$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$anio."')+1, 0))))as saber";
				$r = $conn->Execute($s);
				$dia_fin=$r->fetchrow();
				
				for($i=1; $i<=$dia_fin['saber']; $i++){
					 
					$sql="select Td$i as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$m."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
						and cod_epl_jefe='".$cod_epl_jefe."'";
					$rs = $conn->Execute($sql);
					$row=$rs->fetchrow();
					
					$sql3="update prog_mes_tur set  Td$i='".$row['turno']."' where ID=".$id."";
					$rs3 = $conn->Execute($sql3);
			
				}
				
			}//fin for
			
			//pasar al otro año
			if( $anio +1 == $ano_fin && $mes_fin==01 ){ // si termino en enero
			
				$sql1="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes_fin."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";
				$find2 = $conn->Execute($sql1);
				$row_find2=$find2->fetchrow(); // para saber si el reemplazo tiene turnos, si no tiene entonces creamos un id
			
				($find2->RecordCount() > 0)? $v=0 :$v=1;
				
				
				if($v==1){
			
					$sql10="select Td1 as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes_fin."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
						and cod_epl_jefe='".$cod_epl_jefe."'";
					$rs10 = $conn->Execute($sql10);
					
					if($rs10->RecordCount() > 0){ // sie el otro mes tiene turnos si no retorne 1
						$row=$rs10->FetchRow();
						
					}else{
					
						return 1;
					} 
					
					$fec_ini_r=$fec_ini."-".$mes."-".$anio;
					$fec_fin_r=$fec_fin."-".$mes_fin."-".$ano_fin;
						
					$s3="SELECT cod_epl_reemp
						FROM supernumerario_nov 
						WHERE 
						(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
						AND cod_epl_super='".$reemplazo."'";
						
					$r3= $conn->Execute($s3);
					
					if($r3->RecordCount() > 0){
						
						$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$reemplazo."','".$mes_fin."','".$row['turno']."','".$ano_fin."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";
							$rs2 = $conn->Execute($sql2);
							
						$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
						
					
					
					}else{//inicio else
						
						$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
							from  empleados_basic as bas, empleados_gral gral
							where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
							$reg= $conn->Execute($sql3);
							$fila=$reg->fetchrow();
							
							if($reg->RecordCount() > 0){
										
								$cod_cc2_2=$fila['cod_cc2'];
								$cod_car2=$fila['cod_car'];
								$cod_epl_jefe2=$fila['cod_jefe'];
								
								
								$sql="select ID, Td1 from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes_fin."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";


								$find = $conn->Execute($sql);
								$row_find=$find->fetchrow();
								$id2=$row_find['ID'];
								
								($find->RecordCount() > 0)? $flag=2 :$flag=1;
										
							}else{
							
								$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
							
							}
							
						
							if($flag==1){
								
								$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$reemplazo."','".$mes_fin."','N','".$ano_fin."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
								$rs2 = $conn->Execute($sql2);
								$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
								$flag=2;
							
							}else if($flag==2  && @$row_find['Td1']== NULL){
							
							
								$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id2."";
								$rs3 = $conn->Execute($sql3);
							
							}

					
					}// fin else
				
				}
				
				
				
				
				(@$id2!=NULL)? $id=$id2 : $id=$row_find2['ID'];
				
					
			
				for($i=1; $i<=$fec_fin; $i++){
			
					$sql="select Td$i as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes_fin."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
						and cod_epl_jefe='".$cod_epl_jefe."'";
					$rs = $conn->Execute($sql);
					$row=$rs->fetchrow();
					
					if(@$row['turno']== NULL){
						return 1;
					}
					
					$sql3="update prog_mes_tur set  Td$i='".$row['turno']."' where ID=".$id."";
					$rs3 = $conn->Execute($sql3);
				
				}
				
				if($fec_fin == 31){
			
					$s="select Td".$fec_fin." as turno from prog_mes_tur where ID=".$id."";
					$r= $conn->Execute($s);
					$f=$r->fetchrow();
					
				}else{
				
					$s="select Td".($fec_fin+1)." as turno from prog_mes_tur where ID=".$id."";
					$r= $conn->Execute($s);
					$f=$r->fetchrow();
				
				}
				
				
				if(@$f['turno']== NULL){
					
					for($j=$fec_fin+1; $j<=31; $j++){
				
						$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
						$rs3 = $conn->Execute($sql3);
				
					}	
				}else{ //para llenar el ultimo 
				
					$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$mes_fin."-".$ano_fin."')+1, 0))))as saber";
					$r = $conn->Execute($s);
					$ro=$r->fetchrow();
					
					for($j=(int)$ro['saber']; $j<=31; $j++){
					
						$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
						$rs3 = $conn->Execute($sql3);
					}
				}
				
				contar_semana($id,$mes_fin,$ano_fin);
				
			}else{
				
				
				
				for($m=1; $m<=($mes_fin-1); $m++){ //inicio for
				
					$sql1="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$m."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";
					$find2 = $conn->Execute($sql1);
					$row_find2=$find2->fetchrow();
					
					($find2->RecordCount() > 0)? $v=0 :$v=1;
					
					if($v==1){
						$sql10="select Td1 as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$m."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
							and cod_epl_jefe='".$cod_epl_jefe."'";	
						//var_dump($sql10); die();
						$rs10 = $conn->Execute($sql10);
						$row=$rs10->FetchRow();
						
						
						$fec_ini_r=$fec_ini."-".$mes."-".$anio;
						$fec_fin_r=$fec_fin."-".$mes_fin."-".$ano_fin;
							
						$s3="SELECT cod_epl_reemp
							FROM supernumerario_nov 
							WHERE 
							(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
							AND cod_epl_super='".$reemplazo."'";
							
						$r3= $conn->Execute($s3);
						
						if($r3->RecordCount() > 0){
							
							$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$reemplazo."','".$m."','".$row['turno']."','".$anio."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";
								$rs2 = $conn->Execute($sql2);
								$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
								
						
						
						}else{//inicio else
							
							$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
								from  empleados_basic as bas, empleados_gral gral
								where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
								$reg= $conn->Execute($sql3);
								$fila=$reg->fetchrow();
								
								if($reg->RecordCount() > 0){
											
									$cod_cc2_2=$fila['cod_cc2'];
									$cod_car2=$fila['cod_car'];
									$cod_epl_jefe2=$fila['cod_jefe'];
									
								$sql="select ID, Td1 from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";
								

								$find = $conn->Execute($sql);
								$row_find=$find->fetchrow();
								$id2=$row_find['ID'];
								
								($find->RecordCount() > 0)? $flag=2 :$flag=1;
											
								}else{
								
									$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
								
								}
								
							
								if($flag==1){
								
									$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
									 values('".$reemplazo."','".$mes."','N','".$anio."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
									$rs2 = $conn->Execute($sql2);
									$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
									$flag=2;
								
								}else if($flag==2  && @$row_find['Td1']== NULL){
								
								
									$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id2."";
									$rs3 = $conn->Execute($sql3);
								
								}


						
						}// fin else
				
					}
					
					(@$id2!=NULL)? $id=$id2 : $id=$row_find2['ID'];
					
					$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$ano_fin."')+1, 0))))as saber";
					$r = $conn->Execute($s);
					$dia_fin=$r->fetchrow();
					
					for($i=1; $i<=$dia_fin['saber']; $i++){
						 
						$sql="select Td$i as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$m."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
							and cod_epl_jefe='".$cod_epl_jefe."'";
						$rs = $conn->Execute($sql);
						$row=$rs->fetchrow();
						
						$sql3="update prog_mes_tur set  Td$i='".$row['turno']."' where ID=".$id."";
						$rs3 = $conn->Execute($sql3);
				
					}
					
					contar_semana($id,$m,$ano_fin);
						
				}//fin for
				
				
				$sql1="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes_fin."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";
				$find2 = $conn->Execute($sql1);
				$row_find2=$find2->fetchrow();
				
			   ($find2->RecordCount() > 0)? $v=0 :$v=1;
			   
			   
				if($v==1){
			   
					$sql10="select Td1 as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes_fin."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
						and cod_epl_jefe='".$cod_epl_jefe."'";	
					//var_dump($sql10); die();
					$rs10 = $conn->Execute($sql10);
					$row=$rs10->FetchRow();
					
					
					$fec_ini_r=$fec_ini."-".$mes."-".$anio;
					$fec_fin_r=$fec_fin."-".$mes_fin."-".$ano_fin;
						
					$s3="SELECT cod_epl_reemp
						FROM supernumerario_nov 
						WHERE 
						(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
						AND cod_epl_super='".$reemplazo."'";
						
					$r3= $conn->Execute($s3);
					
					if($r3->RecordCount() > 0){
						
						$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$reemplazo."','".$mes_fin."','".$row['turno']."','".$ano_fin."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";
							$rs2 = $conn->Execute($sql2);
							$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
							
					
					}else{//inicio else
						
						$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
							from  empleados_basic as bas, empleados_gral gral
							where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
							$reg= $conn->Execute($sql3);
							$fila=$reg->fetchrow();
							
							if($reg->RecordCount() > 0){
										
								$cod_cc2_2=$fila['cod_cc2'];
								$cod_car2=$fila['cod_car'];
								$cod_epl_jefe2=$fila['cod_jefe'];
								
								
								$sql="select ID, Td1 from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";
								

								$find = $conn->Execute($sql);
								$row_find=$find->fetchrow();
								$id2=$row_find['ID'];
								
								($find->RecordCount() > 0)? $flag=2 :$flag=1;
										
							}else{
							
							
								$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
							
							}
							
						
							
							if($flag==1){
								
								$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$reemplazo."','".$mes."','N','".$anio."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
								$rs2 = $conn->Execute($sql2);
								$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
								$flag=2;
							
							}else if($flag==2  && @$row_find['Td1']== NULL){
							
							
								$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id2."";
								$rs3 = $conn->Execute($sql3);
							
							}

					
					}// fin else
			
				}
					
					
				(@$id2!=NULL)? $id=$id2 : $id=$row_find2['ID'];
				
				for($m2=1; $m2<=$fec_fin;$m2++){
					
					$sql="select Td$m2 as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes_fin."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
						and cod_epl_jefe='".$cod_epl_jefe."'";
						
					$rs = $conn->Execute($sql);
					$row=$rs->fetchrow();
					
					$sql3="update prog_mes_tur set  Td$m2='".$row['turno']."' where ID=".$id."";
					$rs3 = $conn->Execute($sql3);
					
						
				}
				
				
				if($fec_fin == 31){
			
					$s="select Td".$fec_fin." as turno from prog_mes_tur where ID=".$id."";
					$r= $conn->Execute($s);
					$f=$r->fetchrow();
					
				}else{
				
					$s="select Td".($fec_fin+1)." as turno from prog_mes_tur where ID=".$id."";
					$r= $conn->Execute($s);
					$f=$r->fetchrow();
				
				}
				
				
				if(@$f['turno']== NULL){
					
					for($j=$fec_fin+1; $j<=31; $j++){
				
						$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
						$rs3 = $conn->Execute($sql3);
				
					}	
				}else{ //para llenar el ultimo 
				
					$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$mes_fin."-".$ano_fin."')+1, 0))))as saber";
					$r = $conn->Execute($s);
					$ro=$r->fetchrow();
					
					for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
					
						$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
						$rs3 = $conn->Execute($sql3);
					}

				}
				
				contar_semana($id,$mes_fin,$ano_fin);
			}
			
			
			
		}else if($mes_fin >($mes +1)  && ($anio==$ano_fin)){
			
			
			
			for($m=($mes +1); $m<=($mes_fin - 1); $m++){ //inicio for
				
				$sql1="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$m."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";
				
				$find2 = $conn->Execute($sql1);
				$row_find2=$find2->fetchrow();
					
				($find2->RecordCount() > 0)? $v=0 :$v=1;
				
				if($v==1){
				
					$sql10="select Td1 as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$m."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
						and cod_epl_jefe='".$cod_epl_jefe."'";	
					
					$rs10 = $conn->Execute($sql10);
					$row=$rs10->FetchRow();
					
					
					if($rs10->RecordCount() > 0){ // sie el otro mes tiene turnos si no retorne 1
					
					$row=$rs10->FetchRow();
						
					}else{
					
						return 1;
					}
					
					
					$fec_ini_r=$fec_ini."-".$mes."-".$anio;
					$fec_fin_r=$fec_fin."-".$mes_fin."-".$ano_fin;
						
					$s3="SELECT cod_epl_reemp
						FROM supernumerario_nov 
						WHERE 
						(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
						AND cod_epl_super='".$reemplazo."'";
						
					$r3= $conn->Execute($s3);
					
					if($r3->RecordCount() > 0){
						
						$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
							 values('".$reemplazo."','".$m."','N','".$anio."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";
							$rs2 = $conn->Execute($sql2);
							$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
					
					}else{//inicio else
						
						$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
							from  empleados_basic as bas, empleados_gral gral
							where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
							$reg= $conn->Execute($sql3);
							$fila=$reg->fetchrow();
							
							if($reg->RecordCount() > 0){
										
								$cod_cc2_2=$fila['cod_cc2'];
								$cod_car2=$fila['cod_car'];
								$cod_epl_jefe2=$fila['cod_jefe'];
								
								$sql="select ID, Td1 from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$m."' and Ano='".$anio."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";
								

								$find = $conn->Execute($sql);
								$row_find=$find->fetchrow();
								$id2=$row_find['ID'];
								
								($find->RecordCount() > 0)? $flag=2 :$flag=1;
										
							}else{
							
								$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
							
							}
							
						
							if($flag==1){
								
								$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$reemplazo."','".$m."','N','".$anio."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
								$rs2 = $conn->Execute($sql2);
								$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
								$flag=2;
							
							}else if($flag==2  && @$row_find['Td1']== NULL){
							
							
								$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id2."";
								$rs3 = $conn->Execute($sql3);
							
							}

							
					
					}// fin else
					
				}
				
				(@$id2!=NULL)? $id=$id2 : $id=$row_find2['ID'];
				
				
				/*$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$m."-".$anio."')+1, 0))))as saber";
				$r = $conn->Execute($s);
				$ro=$r->fetchrow();  (int)$ro['saber']; */
				
				for($j=1; $j<=31; $j++){
				
					$sql="select Td$j as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$m."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
					and cod_epl_jefe='".$cod_epl_jefe."'";
					$rs = $conn->Execute($sql);
					$row=$rs->fetchrow();
				
					
					$sql3="update prog_mes_tur set  Td$j='".$row['turno']."' where ID=".$id."";
					$rs3 = $conn->Execute($sql3);
				}
				
				contar_semana($id,$m,$anio);
	
			}// fin for
			
			
			$sql1="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes_fin."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";
			$find2 = $conn->Execute($sql1);
			$row_find2=$find2->fetchrow();
			
			if($v==1){
				
				$sql10="select Td1 as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes_fin."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
					    and cod_epl_jefe='".$cod_epl_jefe."'";	
				
				$rs10 = $conn->Execute($sql10);
				$row=$rs10->FetchRow();
				
				
				$fec_ini_r=$fec_ini."-".$mes."-".$anio;
				$fec_fin_r=$fec_fin."-".$mes_fin."-".$ano_fin;
					
				$s3="SELECT cod_epl_reemp
					FROM supernumerario_nov 
					WHERE 
					(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
					AND cod_epl_super='".$reemplazo."'";
					
				$r3= $conn->Execute($s3);
				
				if($r3->RecordCount() > 0){
					
					$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
						 values('".$reemplazo."','".$mes_fin."','N','".$anio."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";
						$rs2 = $conn->Execute($sql2);
					   $id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
				
				}else{//inicio else
					
					$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
						from  empleados_basic as bas, empleados_gral gral
						where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
						$reg= $conn->Execute($sql3);
						$fila=$reg->fetchrow();
						
						if($reg->RecordCount() > 0){
									
							$cod_cc2_2=$fila['cod_cc2'];
							$cod_car2=$fila['cod_car'];
							$cod_epl_jefe2=$fila['cod_jefe'];
							
							$sql="select ID, Td1 from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes_fin."' and Ano='".$anio."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";
								

								$find = $conn->Execute($sql);
								$row_find=$find->fetchrow();
								$id2=$row_find['ID'];
								
								($find->RecordCount() > 0)? $flag=2 :$flag=1;
									
						}else{
						
							$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
						
						}
						
							if($flag==1){
								
								$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$reemplazo."','".$mes_fin."','N','".$anio."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
								$rs2 = $conn->Execute($sql2);
								$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
								$flag=2;
							
							}else if($flag==2  && @$row_find['Td1']== NULL){
							
							
								$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id2."";
								$rs3 = $conn->Execute($sql3);
							
							}

						
				}// fin else
					
		    }
			
			
			
			(@$id2!=NULL)? $id=$id2 : $id=$row_find2['ID'];
			
			for($j=1; $j<=$fec_fin; $j++){
				
				$sql="select Td$j as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes_fin."' and Ano='".$ano_fin."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
				and cod_epl_jefe='".$cod_epl_jefe."'";
				$rs = $conn->Execute($sql);
				$row=$rs->fetchrow();
				
				$sql3="update prog_mes_tur set  Td$j='".$row['turno']."' where ID=".$id."";
				$rs3 = $conn->Execute($sql3);
			}
			
			
			if($fec_fin == 31){
			
				$s="select Td".$fec_fin." as turno from prog_mes_tur where ID=".$id."";
				$r= $conn->Execute($s);
				$f=$r->fetchrow();
					
			}else{
			
				$s="select Td".($fec_fin+1)." as turno from prog_mes_tur where ID=".$id."";
				$r= $conn->Execute($s);
				$f=$r->fetchrow();
			
			}
				
				
			if(@$f['turno']== NULL){
				
				for($j=$fec_fin+1; $j<=31; $j++){
			
					$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
					$rs3=$conn->Execute($sql3);
			
				}	
			}else{ //para llenar el ultimo 
				
				$s="SELECT DAY((dateadd(ms,-3,DATEADD(mm, DATEDIFF(m,0,'1-".$mes_fin."-".$ano_fin."')+1, 0))))as saber";
				$r = $conn->Execute($s);
				$ro=$r->fetchrow();
				
				for($j=(int)$ro['saber']+ 1; $j<=31; $j++){
				
					$sql3="update prog_mes_tur set  Td$j='N', sem1=0, sem2=0, sem3=0, sem4=0, sem5=0, sem6=0 where ID=".$id."";
					$rs3 = $conn->Execute($sql3);
				}
				

			}
	
			contar_semana($id,$mes_fin,$anio);

		}
		
	}else if($ban==3){
	
	
		$sql="select ID from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$cod_epl_jefe."'";
		$find = $conn->Execute($sql);
		$row_find=$find->fetchrow();
		
		($find->RecordCount() > 0)? $v=0 :$v=1;
		
		if($v==1){
		
			$sql10="select Td1 as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
				and cod_epl_jefe='".$cod_epl_jefe."'";	
			$rs10 = $conn->Execute($sql10);
			$row=$rs10->FetchRow();
			
			
			$fec_ini_r=$fec_ini."-".$mes."-".$anio;
			$fec_fin_r=$fec_fin."-".$mes."-".$anio;
		
			$s3="SELECT cod_epl_reemp
				FROM supernumerario_nov 
				WHERE 
				(convert(date,'".$fec_ini_r."',105) BETWEEN fec_ini AND FEC_FIN  OR convert(date,'".$fec_fin_r."',105) BETWEEN FEC_INI AND fec_fin)   
				AND cod_epl_super='".$reemplazo."'";
				
			$r3= $conn->Execute($s3);
			
			if($r3->RecordCount() > 0){
			
				$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
					 values('".$reemplazo."','".$mes."','".$row['turno']."','".$anio."','".$cod_cc2."','".$cod_car."','".$cod_epl_jefe."')";
				$rs2 = $conn->Execute($sql2);
				$id=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
				
			
			}else{ //inicio else
				
					$sql3="select bas.cod_car, bas.cod_cc2, gral.cod_jefe
				    from  empleados_basic as bas, empleados_gral gral
				    where bas.cod_epl='".$reemplazo."' and gral.cod_epl=bas.cod_epl";
					$reg= $conn->Execute($sql3);
					$fila=$reg->fetchrow();
					
				if($reg->RecordCount() > 0){
							
					$cod_cc2_2=$fila['cod_cc2'];
					$cod_car2=$fila['cod_car'];
					$cod_epl_jefe2=$fila['cod_jefe'];
					
						$sql="select ID, Td1 from prog_mes_tur where cod_epl='".$reemplazo."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2_2."' and cod_car='".$cod_car2."' and cod_epl_jefe='".$cod_epl_jefe2."'";
								

								$find = $conn->Execute($sql);
								$row_find=$find->fetchrow();
								$id2=$row_find['ID'];
								
								($find->RecordCount() > 0)? $flag=2 :$flag=1;
					
				}else{
				
					$s2="select cod_car, cod_cc2, cod_epl_jefe from supernumerario_tmp where Id='".$reemplazo."'";
									$r2= $conn->Execute($s2);
									$f2=$r2->fetchrow();
									
									if($r2->RecordCount() > 0){
										$cod_cc2_2=$f2['cod_cc2'];
										$cod_car2=$f2['cod_car'];
										$cod_epl_jefe2=$f2['cod_epl_jefe'];
										
									}else{
										$cod_cc2_2=$cod_cc2;
										$cod_car2=$cod_car;
										$cod_epl_jefe2=$cod_epl_jefe;
									
									}
									
				
				}
				
							if($flag==1){
								
								$sql2="insert into prog_mes_tur(cod_epl,Mes,Td1,Ano,cod_cc2,cod_car,cod_epl_jefe)
								 values('".$reemplazo."','".$mes."','N','".$anio."','".$cod_cc2_2."','".$cod_car2."','".$cod_epl_jefe2."')";
								$rs2 = $conn->Execute($sql2);
								$id2=$conn->GetOne("SELECT LAST_INSERT_ID=@@IDENTITY");
								$flag=2;
							
							}else if($flag==2  && @$row_find['Td1']== NULL){
							
							
								$sql3="update prog_mes_tur set  Td$j='N' where ID=".$id2."";
								$rs3 = $conn->Execute($sql3);
							
							}

			
			}//fin else
			
			
		
		}
		
		
		
		(@$id!=NULL)? $id=$id : $id=$row_find['ID'];
		
		for($j=1; $j<= $fec_fin; $j++){
			
			$sql10="select Td$j as turno from prog_mes_tur where cod_epl='".$cod_epl."' and Mes='".$mes."' and Ano='".$anio."' and cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."'
				and cod_epl_jefe='".$cod_epl_jefe."'";	
			$rs10 = $conn->Execute($sql10);
			$row=$rs10->FetchRow();
		
			$sql3="update prog_mes_tur set  Td$j='".$row['turno']."' where ID=".$id."";
			$rs3 = $conn->Execute($sql3);
		
		}
		
		
		for($j=$fec_fin +1; $j<= 31; $j++){
		
			$sql7="update prog_mes_tur set  Td$j='N' where ID=".$id."";
			$conn->Execute($sql7);
		
		}
		
		contar_semana($id,($mes+1),$anio);
	
	}
	
 }
	

/*funcion para saber en que semana cae un dia*/
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
	
	if($con_sem==0){
		
		$con_sem=1;
	
	}
	
	return $con_sem;
}


function contar_semana($id,$mes,$anio){

	global $conn;

	$sql4="select * from prog_mes_tur where ID=".$id;
	
	
	$rs4=$conn->Execute($sql4);
	/*definir semanas*/
	$s1=0; $s2=0; $s3=0; $s4=0; $s5=0; $s6=0;
	
	while($row=$rs4->fetchrow()){ // inicio del while
		
		for($i=1;$i<=31;$i++){ //inicio  del for
			
			$turno=strip_tags(@$row["Td".$i]);
	
		
			if($turno !='V' AND $turno!='X'  AND $turno!='N' AND $turno!='LM' AND $turno!='VD'){
			
				$sql5="select horas from turnos_prog where cod_tur='".$turno."'";
				$rs5=$conn->Execute($sql5); 
				
				if($rs5->RecordCount() > 0){
					$row5= $rs5->fetchrow();
					$hora=(int)$row5['horas'];
				}else{
					$sql6="select horas from turnos_prog_tmp where cod_tur='".$turno."' and cod_cc2 in (select cod_cc2 from empleados_basic where cod_epl='".$_POST['cod_epl_jefe']."')and cod_cargo='".$_POST['cod_epl_jefe']."'";					
					
					$rs6=$conn->Execute($sql6);
					$row6= $rs6->fetchrow();
					$hora=(int)$row6['horas'];
				}
				
				$semana=semana($i,$mes,$anio);
				
				
				//var_dump($semana); die();
				switch($semana):
					case 1:
						$s1+=$hora;
					break;
					case 2:
						$s2+=$hora;
					break;
					case 3:
						$s3+=$hora;
					break;
					case 4:
						$s4+=$hora;
					break;
					case 5:
						$s5+=$hora;
						
					break;
					case 6:
						$s6+=$hora;
					break;
				
				endswitch;
				
			}else{ continue;}
			
		}	// fin del for			
		
	}// fin del while

	$sql7="update prog_mes_tur set  sem1=".$s1.", sem2=".$s2.", sem3=".$s3.", sem4=".$s4.", sem5=".$s5.", sem6=".$s6." where ID=".$id."";

	$rs7=$conn->Execute($sql7);
	if($rs7){return  1;}else{return 2;}
}
?>