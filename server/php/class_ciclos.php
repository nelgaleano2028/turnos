<?php
require_once("../librerias/lib/connection.php");

class ciclos{
    
	private $lista1=array();
	private $lista2=array();
   	
	public function ciclos_query($cod_epl){
		
		global $conn;
		
		
		$sql="SELECT cod_ciclo,dias_ciclo, td1, td2, td3, td4, td5, td6, td7, total_horas, descripcion, cod_ocup 
		FROM PROG_CICLO_TURNO
		where cod_epl='".$cod_epl."' and cod_ocup=(select cod_cc2 from empleados_basic where cod_epl='".$cod_epl."')";
		
			 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){

				while($row = $res->FetchRow()){
				
				

					$this->lista1[] =  array("codigo_ciclo"=>mb_convert_encoding($row["cod_ciclo"],'HTML-ENTITIES', 'UTF-8'),
											"dias"=>utf8_encode($row["dias_ciclo"]),
											"uno"=>utf8_encode($row["td1"]),
											"dos"=>utf8_encode($row["td2"]),											
											"tres"=>utf8_encode($row["td3"]),
											"cuatro"=>utf8_encode($row["td4"]),
											"cinco"=>utf8_encode($row["td5"]),
											"seis"=>utf8_encode($row["td6"]),
											"siete"=>utf8_encode($row["td7"]),
											"horas"=>utf8_encode($row["total_horas"]),
											"observacion"=>utf8_encode($row["descripcion"]),
											"area"=>utf8_encode($row["cod_ocup"]));	
				}
							
		 	
			}else{
				$this->lista1 = NULL;
			}	
	
			return $this->lista1;	
	}
	
	
	public function get_cod_cc2($cod_epl){
		
		
		global $conn;
		
		
		$sql="select cod_cc2 from empleados_basic where cod_epl='".$cod_epl."' ";
		
			 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){

				while($row = $res->FetchRow()){
				
			
					$this->lista2[] =  array("cod_cc2"=>$row["cod_cc2"]);	
				}
							
		 	
			}else{
				$this->lista2 = NULL;
			}	
	
			return $this->lista2;	
	
	}
	
	public function crear_ciclo($cod,$obs,$td1,$td2,$td3,$td4,$td5,$td6,$td7,$hor,$cod_cc2,$cod_jefe){
	
		global $conn;
		
		$sql4="SELECT COUNT(*)as CUANTOS FROM prog_ciclo_turno where cod_ciclo='$cod' and  cod_ocup='$cod_cc2' and cod_epl='$cod_jefe'";
		
		
		$res4=$conn->Execute($sql4);
		$row4=$res4->FetchRow();
		

		$cuantos3=(int)$row4['CUANTOS'];
		
        if($cuantos3 > 0){
		
			return 6;
			
		}
		
		
		$sql3="SELECT COUNT(*)as CUANTOS FROM prog_ciclo_turno WHERE td1='$td1' and td2='$td2' and td3='$td3' and td4='$td4' and td5='$td5' and td6='$td6' and td7='$td7' and cod_ocup='".$cod_cc2."' and cod_epl='".$cod_jefe."'";
		
		$res3=$conn->Execute($sql3);
		$row3=$res3->FetchRow();
		$cuantos2=(int)$row3['CUANTOS'];
		
		
        if($cuantos2 > 0){
		
			return 4;
		}
				
		$sql="insert into prog_ciclo_turno(cod_ciclo,dias_ciclo,td1,td2,td3,td4,td5,td6,td7,total_horas,descripcion,cod_ocup,cod_epl) 
             values('".$cod."',7,'".$td1."','".$td2."','".$td3."','".$td4."','".$td5."','".$td6."','".$td7."','".$hor."','".$obs."','".$cod_cc2."','".$cod_jefe."')";
			 
		$rs=$conn->Execute($sql);
		if($rs)
			return 1;
		else
			return 2;
	}
	
	public function capatura_horas_tur($td1,$td2,$td3,$td4,$td5,$td6,$td7){
		
		global $conn;
		
		$horas=array('td1'=>$td1,'td2'=>$td2,'td3'=>$td3,'td4'=>$td4,'td5'=>$td5,'td6'=>$td6,'td7'=>$td7);
		
		foreach($horas as $key=>$value){
		
			$sql="select CAST(HORAS AS INT) as horas from  turnos_prog where cod_tur='".$value."'
					UNION
					select CAST(HORAS AS INT) as horas from  turnos_prog_tmp where cod_tur='".$value."'";
			$res=$conn->Execute($sql);
			$row = $res->FetchRow();
			
				
				$this->lista1[]=array($key=>$row['horas']);

		}
			return $this->lista1;

	}
	
	public function editar_ciclo($cod_old,$cod,$obs,$td1,$td2,$td3,$td4,$td5,$td6,$td7,$hor,$cod_cc2,$cod_jefe){
		
		
		global $conn;
		
		$sql4="SELECT COUNT(*)as CUANTOS FROM prog_ciclo_turno where cod_ciclo='$cod' and cod_ciclo <> '".$cod_old."' and cod_ocup='".$cod_cc2."' and cod_epl='".$cod_jefe."'";
		$res4=$conn->Execute($sql4);
		$row4=$res4->FetchRow();
		

		$cuantos3=(int)$row4['CUANTOS'];
		
        if($cuantos3 > 0){
		
			return 6;
			
		}
		
		
		$sql3="SELECT cod_ciclo FROM prog_ciclo_turno WHERE td1='$td1' and td2='$td2' and td3='$td3' and td4='$td4' and td5='$td5' and td6='$td6' and td7='$td7' and cod_ocup='".$cod_cc2."' and cod_epl='".$cod_jefe."'";
		
		$res3=$conn->Execute($sql3);
		$row3=$res3->FetchRow();
		$cuantos2=$row3['cod_ciclo'];
		
		
		
		if($cod_old==$row3['cod_ciclo']){
			
			
		
			$sql5="update prog_ciclo_turno set cod_ciclo='".$cod."', descripcion='".$obs."' where cod_ciclo='".$cod_old."' and cod_ocup='".$cod_cc2."' and cod_epl='".$cod_jefe."'";
			
			$rs5=$conn->Execute($sql5);
			if($rs5)
				return 1;
			else
				return 2;
		
		}else{
			
			$sql3="SELECT COUNT(*)as CUANTOS FROM prog_ciclo_turno WHERE td1='$td1' and td2='$td2' and td3='$td3' and td4='$td4' and td5='$td5' and td6='$td6' and td7='$td7' and cod_ocup='".$cod_cc2."' and cod_epl='".$cod_jefe."'";
			$res3=$conn->Execute($sql3);
			$row3=$res3->FetchRow();
			$cuantos2=(int)$row3['CUANTOS'];
			
			if($cuantos2 > 0){
		
				return 4;
			}
			
			$sql="update  prog_ciclo_turno set cod_ciclo='".$cod."',  td1='".$td1."', td2='".$td2."', td3='".$td3."', td4='".$td4."', td5='".$td5."', td6='".$td6."', td7='".$td7."', total_horas='".$hor."', descripcion='".$obs."' 
             where cod_ciclo='".$cod_old."' and cod_ocup='".$cod_cc2."' and cod_epl='".$cod_jefe."'";
			
			$rs=$conn->Execute($sql);
			if($rs)
				return 1;
			else
				return 2;
			}
	}
	
	public function eliminar_ciclo($cod_old,$cod_cc2,$cod_jefe){
	
		global $conn;
		
		$sql="DELETE prog_ciclo_turno WHERE cod_ciclo='".$cod_old."' and cod_ocup='".$cod_cc2."' and cod_epl='".$cod_jefe."'";
	
		$rs=$conn->Execute($sql);
		if($rs)
			return 1;
		else
			return 2;
	
	
	
	}
}
?>