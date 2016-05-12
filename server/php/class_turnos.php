<?php
require_once("../librerias/lib/connection.php");

class turnos{
    
	private $lista=array();
    private $cod_epl=null;	
	
	
	public function set_empleado($cod_epl){
	
		$this->cod_epl=$cod_epl;
	
	}
	
	
	private	function get_empleado(){

		return $this->cod_epl;
	}
	
	private function area_turnosJefe(){
	
		global $conn;
		
		$sql="select cod_cc2 as CC2 from empleados_basic where cod_epl ='".$this->cod_epl."'";
		$res=$conn->Execute($sql);
		$row=$res->FetchRow();
		
		return $row['CC2'];
	}
	
	
	private function cargo_turnosJefe(){
	
		global $conn;
		
		$sql="select cod_car as car from empleados_basic where cod_epl ='".$this->cod_epl."'";
		$res=$conn->Execute($sql);
		$row=$res->FetchRow();
		
		return $row['car'];
	
	}
	
	public function turnos_predeterminados(){
		
		global $conn;
		
		
		$sql="SELECT COD_TUR, CAST(HORAS AS INT) as HORAS, convert(varchar(5),HOR_INI,108) as HOR_INI, convert(varchar(5),HOR_FIN,108) as HOR_FIN, COD_CARGO 
	  	      FROM TURNOS_PROG WHERE COD_TUR <> 'N'  AND COD_TUR <> 'SP' AND COD_TUR <> 'VCTO' AND COD_TUR <> 'IG' AND COD_TUR <> 'VD' AND COD_TUR <> 'V' AND COD_TUR <> 'R'
			  AND COD_TUR <> 'LN' AND COD_TUR <> 'LM' AND COD_TUR <> 'AT' AND COD_TUR <> 'LP' AND COD_TUR <> 'EP' AND COD_TUR <> 'LR'";
						 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){
			 
				while($row = $res->FetchRow()){

					$this->lista[] =  array("codigo_turno"=>$row["COD_TUR"],
											"horas"=>$row["HORAS"],
											"hora_ini"=>$row["HOR_INI"],
											"hora_fin"=>$row["HOR_FIN"],
											"cod_cargo"=>$row["COD_CARGO"]);	
				}
							
		 	
			}else{
				$this->lista = NULL;
			}	
	
			return $this->lista;	
	}
	
	public function turnos_creados_admin(){
	
		global $conn;
		
		
		$sql="SELECT COD_TUR, CAST(HORAS AS INT) as HORAS, convert(varchar(5),HOR_INI,108) as HOR_INI, 		  convert(varchar(5),HOR_FIN,108) as HOR_FIN FROM TURNOS_PROG";
	
						 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){
			 
				while($row = $res->FetchRow()){
				
					$fec_ini=explode(":",$row["HOR_INI"]);
					$fec_fin=explode(":",$row["HOR_FIN"]);
				
					$this->lista[] =  array("codigo_turno"=>$row["COD_TUR"],
											"horas"=>$row["HORAS"],
											"hora_ini"=>$fec_ini[0],
											"hora_fin"=>$fec_fin[0]);	
				}
							
		 	
			}else{
				$this->lista = NULL;
			}	
	
			return $this->lista;	

	
	}
	
	public function turnos_creados($cod_epl){
		
		global $conn;
		
		
		$sql="SELECT COD_TUR, CAST(HORAS AS INT) as HORAS, convert(varchar(5),HOR_INI,108) as HOR_INI, convert(varchar(5),HOR_FIN,108) as HOR_FIN, tur_tip FROM TURNOS_PROG_TMP WHERE cod_cargo='".$cod_epl."' AND cod_cc2=(select cod_cc2 from empleados_basic where cod_epl='".$cod_epl."');";
	
						 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){
			 
				while($row = $res->FetchRow()){
				
					$fec_ini=explode(":",$row["HOR_INI"]);
					$fec_fin=explode(":",$row["HOR_FIN"]);
				
					$this->lista[] =  array("codigo_turno"=>$row["COD_TUR"],
											"horas"=>$row["HORAS"],
											"hora_ini"=>$fec_ini[0],
											"hora_fin"=>$fec_fin[0],
											"tur_tip"=>$row["tur_tip"]);	
				}
							
		 	
			}else{
				$this->lista = NULL;
			}	
	
			return $this->lista;	
	}
		
			
	public function fusion_turnos($cod_epl){

		global $conn;
		
		$area=$this->area_turnosJefe();
		
		$sql="select cod_tur, convert(varchar(5),hor_ini,108) as hor_ini,convert(varchar(5),hor_fin,108) as hor_fin,horas 
				from TURNOS_PROG_TMP  where  cod_tur <> 'VCTO' AND cod_tur <> 'R' AND cod_tur <> 'AT' AND cod_tur <> 'EP' AND cod_tur <> 'IG' AND cod_tur <> 'LM' AND cod_tur <> 'LN'
				AND cod_tur <> 'LP' AND cod_tur <> 'SP' AND cod_tur <> 'VD' AND cod_tur <> 'V' AND cod_tur <> 'N' AND COD_TUR <> 'LR' and cod_cargo='".$cod_epl."'
				union
				select cod_tur, convert(varchar(5),hor_ini,108) as hor_ini,convert(varchar(5),hor_fin,108) as hor_fin,horas
				from TURNOS_PROG where cod_tur <> 'VCTO' AND cod_tur <> 'R' AND cod_tur <> 'AT' AND cod_tur <> 'EP' AND cod_tur <> 'IG' AND cod_tur <> 'LM' AND cod_tur <> 'LN'
				AND cod_tur <> 'LP' AND cod_tur <> 'SP' AND cod_tur <> 'VD' AND cod_tur <> 'V' AND cod_tur <> 'N' AND COD_TUR <> 'LR' and (cod_cargo='AA70030110' or cod_cargo='')
				order by hor_ini, hor_fin asc"; // los cod_tur N, VCTO, R son turnos especiales, estos turnos pertenecen a vencimiento de contrato
		
		
		$res=$conn->Execute($sql);
		
		if($res){
			 
				while($row = $res->FetchRow()){
				
					@$fec_ini=explode(":",$row["hor_ini"]);
					@$fec_fin=explode(":",$row["hor_fin"]);
				
					$this->lista[] =  array("codigo_turno"=>$row["cod_tur"],
											"horas"=>$row["horas"],
											"hora_ini"=>$fec_ini[0].':00',
											"hora_fin"=>$fec_fin[0].':00');	
				}
							
		 	
			}else{
				$this->lista = NULL;
			}	
	
			return $this->lista;

	}
	
	public function fusion_turnos2($codigo){
	
		global $conn;
		
		$area=$this->area_turnosJefe();
		
		$sql="select cod_tur, convert(varchar(5),hor_ini,108) as hor_ini,convert(varchar(5),hor_fin,108) as hor_fin,horas 
				from TURNOS_PROG_TMP  where  cod_tur <> 'VCTO' AND cod_tur <> 'R' AND cod_tur <> 'AT' AND cod_tur <> 'EP' AND cod_tur <> 'IG' AND cod_tur <> 'LM' AND cod_tur <> 'LN' AND cod_tur <> 'V'
				AND cod_tur <> 'LP' AND cod_tur <> 'SP' AND cod_tur <> 'VD' AND cod_tur <> 'N' AND COD_TUR <> 'LR' and cod_cargo='".$codigo."'
				union
				select cod_tur, convert(varchar(5),hor_ini,108) as hor_ini,convert(varchar(5),hor_fin,108) as hor_fin,horas
				from TURNOS_PROG where cod_tur <> 'VCTO' AND cod_tur <> 'R' AND cod_tur <> 'AT' AND cod_tur <> 'EP' AND cod_tur <> 'IG' AND cod_tur <> 'LM' AND cod_tur <> 'LN' AND cod_tur <> 'V'
				AND cod_tur <> 'LP' AND cod_tur <> 'SP' AND cod_tur <> 'VD' AND cod_tur <> 'N' AND COD_TUR <> 'LR' and (cod_cargo='".$codigo."' OR cod_cargo='AA70030110' )
				order by hor_ini, hor_fin asc";				// los cod_tur N, VCTO, R son turnos especiales, estos turnos pertenecen a vencimiento de contrato
				
		
		$res=$conn->Execute($sql);
		
		if($res){
			 
				while($row = $res->FetchRow()){
				
					@$fec_ini=explode(":",$row["hor_ini"]);
					@$fec_fin=explode(":",$row["hor_fin"]);
				
					$this->lista[] =  array("codigo_turno"=>$row["cod_tur"],
											"horas"=>$row["horas"],
											"hora_ini"=>$fec_ini[0].':00',
											"hora_fin"=>$fec_fin[0].':00');	
				}
							
		 	
			}else{
				$this->lista = NULL;
			}	
	
			return $this->lista;

	}
	
	public function crear_turno($cod,$hor_ini,$hor_fin,$horas,$almuerzo,$cod_jefe){
	
		global $conn;
		
		$area=$area=$this->area_turnosJefe();
		
		$sql4="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG WHERE cod_tur='$cod'";
		$res4=$conn->Execute($sql4);
		$row4=$res4->FetchRow();
		

		$cuantos3=(int)$row4['CUANTOS'];
		
        if($cuantos3 > 0){
		
			return 6;
		}
		
		$sql5="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG_TMP WHERE cod_tur='$cod' and cod_cc2='".$area."' and cod_cargo='".$cod_jefe."'";
		
		$res5=$conn->Execute($sql5);
		$row5=$res5->FetchRow();
		
		$cuantos4=(int)$row5['CUANTOS'];
		
        if($cuantos4 > 0){
		
			return 5;
		}
		
		
		$sql3="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121) AND hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121)";
		
		
		$res3=$conn->Execute($sql3);
		$row3=$res3->FetchRow();
		$cuantos2=(int)$row3['CUANTOS'];
		
        if($cuantos2 > 0){
		
			return 4;
		}
		
		$sql2="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG_TMP WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121) and hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121) and  cod_cc2='".$area."' and cod_cargo='".$cod_jefe."'";
		
		$res=$conn->Execute($sql2);
		$row=$res->FetchRow();
		$cuantos=(int)$row['CUANTOS'];
		
        if($cuantos > 0){
		
			return 3;
		}
		
		$sql="insert into turnos_prog_tmp(cod_tur,horas,hor_ini,hor_fin,tur_tip,cod_cc2,cod_cargo) 
             values('".$cod."',$horas,convert(varchar,'1899-01-01 $hor_ini:00:00.000',121),convert(varchar,'1899-01-01 $hor_fin:00:00.000',121),'$almuerzo','$area','$cod_jefe')";
			 
		$rs=$conn->Execute($sql);
		if($rs)
			return 1;
		else
			return 2;
	}
	
	
	public function crear_turno_pre($cod,$hor_ini,$hor_fin,$horas){
	
		global $conn;
		
		$cod_car=$this->cargo_turnosJefe();
		
		
		$sql4="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG WHERE cod_tur='$cod'";
		$res4=$conn->Execute($sql4);
		$row4=$res4->FetchRow();
		

		$cuantos3=(int)$row4['CUANTOS'];
		
        if($cuantos3 > 0){
		
			return 6;
		}
		$sql5="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG_TMP WHERE cod_tur='$cod'";
		
		$res5=$conn->Execute($sql5);
		$row5=$res5->FetchRow();
		
		$cuantos4=(int)$row5['CUANTOS'];
		
        if($cuantos4 > 0){
		
			return 5;
		}
		
		
		$sql3="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121) AND hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121) ";
		
		
		$res3=$conn->Execute($sql3);
		$row3=$res3->FetchRow();
		$cuantos2=(int)$row3['CUANTOS'];
		
        if($cuantos2 > 0){
		
			return 4;
		}
		
		$sql2="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG_TMP WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121) and hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121)";
		
		$res=$conn->Execute($sql2);
		$row=$res->FetchRow();
		$cuantos=(int)$row['CUANTOS'];
		
        if($cuantos > 0){
		
			return 3;
		}
		
		$sql="insert into turnos_prog(cod_tur,horas,hor_ini,hor_fin,cod_cargo) 
             values('".$cod."',$horas,convert(varchar,'1899-01-01 $hor_ini:00:00.000',121),convert(varchar,'1899-01-01 $hor_fin:00:00.000',121),'$cod_car')";
		 
		$rs=$conn->Execute($sql);
		if($rs)
			return 1;
		else
			return 2;
	}
	
	public function editar_turno($cod,$cod_old,$hor_ini,$hor_fin,$horas,$almuerzo,$cod_epl){
			
		
		global $conn;
		
		$centro_costo=$this->area_turnosJefe();
		
		$sql4="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG WHERE cod_tur='$cod' and cod_tur <>'".$cod_old."'";
		
		$res4=$conn->Execute($sql4);
		$row4=$res4->FetchRow();
		

		$cuantos3=(int)$row4['CUANTOS'];
		
        if($cuantos3 > 0){
		
			return 6;
		}
		
		$sql5="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG_TMP WHERE cod_tur='$cod' and cod_tur <>'".$cod_old."' and cod_cc2='".$centro_costo."' and cod_cargo='".$cod_epl."'";
		
		$res5=$conn->Execute($sql5);
		$row5=$res5->FetchRow();
		
		$cuantos4=(int)$row5['CUANTOS'];
		
        if($cuantos4 > 0){
		
			return 5;
		}
		
		
		$sql7="SELECT count(cod_tur) as CUANTOS FROM TURNOS_PROG WHERE hor_ini=convert(varchar,'1899-01-01 ".$hor_ini.":00.000',121) AND hor_fin=convert(varchar,'1899-01-01 ".$hor_fin.":00.000',121)";
			
			
		$res7=$conn->Execute($sql7);
		$row7=$res7->FetchRow();
		$cuantos7=(int)$row7['CUANTOS'];
		
		if($cuantos7 > 0){
			return 4;
		}
			
			
	
		$sql3="SELECT cod_tur FROM TURNOS_PROG_TMP WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121) AND hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121) AND cod_cc2='".$centro_costo."' and cod_cargo='".$cod_epl."'";
				
		
		$res3=$conn->Execute($sql3);
		$row3=$res3->FetchRow();
		
			
		if($cod_old==$row3['cod_tur']){
		
			
			$sql6="update turnos_prog_tmp set cod_tur='".$cod."', tur_tip='".$almuerzo."', horas='".$horas."' where cod_tur='".$cod_old."' and  cod_cc2='".$centro_costo."' and cod_cargo='".$cod_epl."'";
				
				
			$rs6=$conn->Execute($sql6);
			if($rs6)
				return 1;
			else
				return 2;
				
			
		}else{
			/*$sql7="SELECT count(cod_tur) as CUANTOS FROM TURNOS_PROG WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00.000',121) AND hor_fin=convert(varchar,'1899-01-01 $hor_fin:00.000',121) and cod_tur='".$cod_old."'";*/
		
			
			
			
			$sql8="SELECT count(cod_tur) as CUANTOS FROM TURNOS_PROG_TMP WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00.000',121) AND hor_fin=convert(varchar,'1899-01-01 $hor_fin:00.000',121) AND cod_cc2='".$centro_costo."' and cod_cargo='".$cod_epl."'";
			
			$res8=$conn->Execute($sql8);
			$row8=$res8->FetchRow();
			$cuantos8=(int)$row8['CUANTOS'];
			
			if($cuantos8 > 0){
				return 3;
			}
			
			$sql="UPDATE  turnos_prog_tmp set cod_tur='".$cod."', horas='".$horas."', hor_ini=convert(varchar,'1899-01-01 $hor_ini:00.000',121), hor_fin=convert(varchar,'1899-01-01 $hor_fin:00.000',121), tur_tip='".$almuerzo."'
				WHERE cod_tur='".$cod_old."' AND cod_cc2='".$centro_costo."' and cod_cargo='".$cod_epl."'";
				
				var_dump($sql); die();

			$rs=$conn->Execute($sql);
			if($rs)
				return 1;
			else
				return 2;
			
		}
		
			
			
	}
	
	
	public function editar_turno_pre($cod,$cod_old,$hor_ini,$hor_fin,$horas){
		
		global $conn;
		
		$cod_car=$this->cargo_turnosJefe();
		
		$sql4="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG WHERE cod_tur='$cod' and cod_tur <>'".$cod_old."'";
		
		$res4=$conn->Execute($sql4);
		$row4=$res4->FetchRow();
		

		$cuantos3=(int)$row4['CUANTOS'];
		
        if($cuantos3 > 0){
		
			return 6;
		}
		
		$sql5="SELECT COUNT(*)as CUANTOS FROM TURNOS_PROG_TMP WHERE cod_tur='$cod' and cod_tur <>'".$cod_old."'";
		
		$res5=$conn->Execute($sql5);
		$row5=$res5->FetchRow();
		
		$cuantos4=(int)$row5['CUANTOS'];
		
        if($cuantos4 > 0){
		
			return 5;
		}
	
		$sql3="SELECT cod_tur FROM TURNOS_PROG WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121) AND hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121)
				UNION
				SELECT cod_tur FROM TURNOS_PROG_TMP WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121) AND hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121)";
		
		$res3=$conn->Execute($sql3);
		$row3=$res3->FetchRow();
		
			
		if($cod_old==$row3['cod_tur']){
		
			
			$sql6="update turnos_prog set cod_tur='".$cod."' where cod_tur='".$cod_old."'";  			
			$rs6=$conn->Execute($sql6);
			if($rs6)
				return 1;
			else
				return 2;
				
			
		}else{
		
			$sql7="SELECT count(cod_tur) as CUANTOS FROM TURNOS_PROG WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121) AND hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121)";
			$res7=$conn->Execute($sql7);
			$row7=$res7->FetchRow();
			$cuantos7=(int)$row7['CUANTOS'];
			
			if($cuantos7 > 0){
				return 4;
			}
			
			$sql8="SELECT count(cod_tur) as CUANTOS FROM TURNOS_PROG_TMP WHERE hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121) AND hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121)";
			$res8=$conn->Execute($sql8);
			$row8=$res8->FetchRow();
			$cuantos8=(int)$row8['CUANTOS'];
			
			if($cuantos8 > 0){
				return 3;
			}
			
			$sql="UPDATE  turnos_prog set cod_tur='".$cod."', horas='".$horas."', hor_ini=convert(varchar,'1899-01-01 $hor_ini:00:00.000',121), hor_fin=convert(varchar,'1899-01-01 $hor_fin:00:00.000',121)
				WHERE cod_tur='".$cod_old."' AND cod_cargo='".$cod_car."'";

			$rs=$conn->Execute($sql);
			if($rs)
				return 1;
			else
				return 2;
			
			}
	}
	
	public function eliminar_turno($cod,$cod_old,$cod_jefe){
		
		global $conn;
		
		$area=$this->area_turnosJefe();
		
		/*$sql2="select COUNT(*) as CUANTOS from prog_ciclo_turno WHERE  (td1='".$cod."' OR td2='".$cod."' OR td3='".$cod."'  OR td4='".$cod."' OR td5='".$cod."' OR td6='".$cod."' OR td7='".$cod."') AND cod_epl='".$cod_jefe."'";
		$res2=$conn->Execute($sql2);
		$row2=$res2->FetchRow();
		$cuantos2=(int)$row2['CUANTOS'];
			
		if($cuantos2 > 0){
			return 3;
		}*/
		
		$sql3="SELECT COUNT(*) as CUANTOS FROM PROG_MES_TUR WHERE (Td1='".$cod."' or Td2='".$cod."' or  Td3='".$cod."' or  Td4='".$cod."'
			or  Td5='".$cod."' or  Td6='".$cod."' or  Td7='".$cod."' or  Td8='".$cod."' or  Td9='".$cod."' or  Td10='".$cod."' 
			or  Td11='".$cod."' or  Td12='".$cod."' or  Td13='".$cod."' or  Td14='".$cod."' or  Td15='".$cod."' or  Td16='".$cod."' or  Td17='".$cod."' 
			or  Td18='".$cod."' or  Td19='".$cod."' or  Td20='".$cod."' or  Td21='".$cod."' or  Td22='".$cod."' or  Td23='".$cod."' or  Td24='".$cod."' 
			or  Td25='".$cod."' or  Td26='".$cod."' or  Td27='".$cod."' or  Td28='".$cod."' or  Td29='".$cod."' or  Td30='".$cod."' or  Td31='".$cod."') 
			AND cod_epl_jefe='".$cod_jefe."' and cod_cc2='".$area."' ";
			
			
		$res3=$conn->Execute($sql3);
		$row=$res3->FetchRow();
		$cantidad=(int)$row['CUANTOS'];

		if($cantidad > 0){
		
			return 4;
		}else{
			
			$sql="DELETE turnos_prog_tmp where cod_tur='".$cod."' and cod_cc2='".$area."' and cod_cargo='".$cod_jefe."'";
		
			$rs=$conn->Execute($sql);
			if($rs)
				return 1;
			else
				return 2;
			
		}
	}
	
	public function eliminar_turno_pre($cod,$cod_old){
		
		global $conn;
		
		$cod_car=$this->cargo_turnosJefe();
		
		$sql2="select COUNT(*) as CUANTOS from prog_ciclo_turno WHERE  td1='".$cod."' OR td2='".$cod."' OR td3='".$cod."'  OR td4='".$cod."' OR td5='".$cod."' OR td6='".$cod."' OR td7='".$cod."'";
		$res2=$conn->Execute($sql2);
		$row2=$res2->FetchRow();
		$cuantos2=(int)$row2['CUANTOS'];
			
		if($cuantos2 > 0){
			return 3;
		}
		
		$sql="DELETE turnos_prog where cod_tur='".$cod."' and cod_cargo='".$cod_car."'";
	
		$rs=$conn->Execute($sql);
		if($rs)
			return 1;
		else
			return 2;
	}


	public function correo_empleados(){
	
		global $conn;
		
		$sql="select gral.email,b.nom_epl+' '+b.ape_epl as nom_epl from empleados_gral as gral, empleados_basic as b where gral.cod_epl=b.cod_epl and b.estado='A' and gral.email <> ''";
		
		$res=$conn->Execute($sql);
		 
		 	if($res){
			 
				while($row = $res->FetchRow()){
				
					$this->lista[] =  array("nom_epl"=>utf8_encode($row["nom_epl"]),
											"email_epl"=>$row["email"]);	
				}	
			}
			
			return $this->lista;
	}
	
}