<?php
require_once("../librerias/lib/connection.php");

class programacion{
    
	//ojo cree dos porque me salio error
	private $lista1=array();
	private $lista2=array();
	private $lista3=array();
	private $lista4=array();
    private $lista5=array();
   	
	public function anio_programaciones_anteriores(){
		
		global $conn;
		
		$sql="select ano from prog_mes_tur group by ano order by ano asc";
						 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){
				
				$row = $res->FetchRow();			
					
				if(@$row["ano"] == NUll){
						$this->lista1[] =  array("anio"=>date("Y")-1);	
				}else{
				
						$res2=$conn->Execute($sql);							
						
						//ojo quitar esto es una prueba para que salga el 2013
						//$this->lista1[] =  array("anio"=>date("Y")-1);
						
						while($row2 = $res2->FetchRow()){						

							$this->lista1[] =  array("anio"=>$row2["ano"]);	
						}
				}			
		 	
			}else{
				$this->lista1 = NULL;
			}	
	
			return $this->lista1;	
	}
	
	public function anio_max_programacion(){
		
			global $conn;		
		
			$sql="select MAX(ano)+1 as ano from prog_mes_tur";		
						 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){			
			 
				    $row = $res->FetchRow();			
					if(@$row["ano"] == NUll){
						$this->lista2[] =  array("ano"=>date("Y"));	
					}else{
					$this->lista2[] =  array("ano"=>$row["ano"]);	
					}					
		 	
			}else{
				$this->lista2 = NULL;
			}	
	
			return $this->lista2;	
	}
	
	/* 	----------------------------------------------------- METODOS ---------------------------------------------------------------------- 
		Lista_centroCosto() 	: retorna los centros de costo que un jefe tiene al mando.
		lista_cargos($area) 	: se debe ingresar un centro de costo para retornar los cargos que posee.
		lista_empleados($cargo) : Se debe ingresar el cargo para retornar los empleados que están en el cargo.
	*/
	public function lista_centroCosto($codigo){
		try { 
			global $conn;
			$sql="SELECT distinct AREA.COD_CC2,   AREA.NOM_CC2 FROM  CENTROCOSTO2 AREA, EMPLEADOS_BASIC EPL, EMPLEADOS_GRAL GRAL
					WHERE EPL.COD_EPL = GRAL.COD_EPL
					AND EPL.COD_CC2=AREA.COD_CC2
					and GRAL.COD_JEFE = '".$codigo."'
					and AREA.estado='A'
					and EPL.estado='A'
					";
					
			$rs=$conn->Execute($sql);
			while($fila=$rs->FetchRow()){
				$this->lista3[]=array("codigo" => $fila["COD_CC2"],
                                      "area"   => utf8_encode($fila["NOM_CC2"]));
			}
			
			return $this->lista3;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		} 
	}
	/*
	public function lista_cargos($area, $codigo){
		try { 
			global $conn;
			$sql="SELECT distinct c.cod_car, C.NOM_CAR  FROM CARGOS C, CENTROCOSTO2 AREA, EMPLEADOS_BASIC EPL, EMPLEADOS_GRAL GRAL
					WHERE EPL.COD_EPL = GRAL.COD_EPL
					AND EPL.COD_CC2='".$area."'
					AND EPL.COD_CAR=C.COD_CAR
					and gral.COD_JEFE  = '".$codigo."'";
					
					
			$rs=$conn->Execute($sql);
			while($fila=$rs->FetchRow()){
				$this->lista4[]=array("codigo" => $fila["cod_car"],
									 "cargo"  => utf8_encode($fila["NOM_CAR"]));
			}
			
			return $this->lista4;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		}
	}*/
	
	public function lista_empleados($cargo){
		try { 
			global $conn;
			$sql="SELECT epl.cod_epl, epl.nom_epl,epl.ape_epl FROM  EMPLEADOS_BASIC EPL, EMPLEADOS_GRAL GRAL
					WHERE EPL.COD_EPL = GRAL.COD_EPL
					AND EPL.COD_CAR='".$cargo."'
					and gral.COD_JEFE = '".$this->cod_epl."'
					and (epl.estado = 'A' OR
					(datepart(yy,epl.fec_ing) = '2013' and datepart(mm,epl.fec_ing)='02') OR
					(datepart(yy,epl.fec_ret) = '2013' and datepart(mm,epl.fec_ret)='02') )";
					
			$rs=$conn->Execute($sql);
			
			while($fila=$rs->FetchRow()){
				$this->lista[]=array("codigo"   => $fila["cod_epl"],
									 "nombre"   =>utf8_encode($fila["nom_epl"]),
									 "apellido" =>utf8_encode($fila["ape_epl"]));
			}
			
			return $this->lista;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		}	
	}

	public function insertar_programacion($codigo, $mes, $T1, $T2, $T3, $T4, $T5, $T6, $T7, $T8, $T9, $T10, $T11, $T12, $T13, $T14, $T15, $T16, $T17, $T18, $T19, $T20, $T21, $T22, $T23, $T24, $T25, $T26, $T27, $T28, $T29, $T30, $T31, $ano, $cod_ciclo, $cod_ciclo2, $cod_ciclo3, $cod_ciclo4, $cod_ciclo5, $cod_ciclo6, $sem1, $sem2, $sem3, $sem4 ,$sem5, $sem6,$cod_cc2,$cod_car,$cod_jefe){	
				
				global $conn;
				
				
				$sql0="insert into prog_mes_tur_ini(cod_epl,mes,Td1,Td2,Td3,Td4,Td5,Td6,Td7,Td8,Td9,Td10,Td11,Td12,Td13,Td14,Td15,Td16,Td17,Td18,Td19,Td20,Td21,Td22,Td23,Td24,Td25,Td26,Td27,Td28,Td29,Td30,Td31, Ano, cod_ciclo, cod_ciclo2, cod_ciclo3, cod_ciclo4, cod_ciclo5, cod_ciclo6, sem1, sem2, sem3, sem4 ,sem5, sem6, cod_cc2, cod_car, cod_epl_jefe) 
				      values('".$codigo."',".$mes.",'".$T1."','".$T2."','".$T3."','".$T4."','".$T5."','".$T6."','".$T7."','".$T8."','".$T9."','".$T10."','".$T11."','".$T12."','".$T13."','".$T14."','".$T15."','".$T16."','".$T17."','".$T18."','".$T19."','".$T20."','".$T21."','".$T22."','".$T23."','".$T24."','".$T25."','".$T26."','".$T27."','".$T28."','".$T29."','".$T30."','".$T31."',".$ano.",'".$cod_ciclo."','".$cod_ciclo2."','".$cod_ciclo3."','".$cod_ciclo4."','".$cod_ciclo5."' , '".$cod_ciclo6."', '".$sem1."', '".$sem2."', '".$sem3."', '".$sem4."' ,'".$sem5."', '".$sem6."', '".$cod_cc2."','".$cod_car."','".$cod_jefe."')";
					 
				
				
				$conn->Execute($sql0);
				
				
				$sql1="insert into prog_mes_tur(cod_epl,mes,Td1,Td2,Td3,Td4,Td5,Td6,Td7,Td8,Td9,Td10,Td11,Td12,Td13,Td14,Td15,Td16,Td17,Td18,Td19,Td20,Td21,Td22,Td23,Td24,Td25,Td26,Td27,Td28,Td29,Td30,Td31, Ano, cod_ciclo, cod_ciclo2, cod_ciclo3, cod_ciclo4, cod_ciclo5, cod_ciclo6, sem1, sem2, sem3, sem4 ,sem5, sem6, cod_cc2, cod_car, cod_epl_jefe) 
				      values('".$codigo."',".$mes.",'".$T1."','".$T2."','".$T3."','".$T4."','".$T5."','".$T6."','".$T7."','".$T8."','".$T9."','".$T10."','".$T11."','".$T12."','".$T13."','".$T14."','".$T15."','".$T16."','".$T17."','".$T18."','".$T19."','".$T20."','".$T21."','".$T22."','".$T23."','".$T24."','".$T25."','".$T26."','".$T27."','".$T28."','".$T29."','".$T30."','".$T31."',".$ano.",'".$cod_ciclo."','".$cod_ciclo2."','".$cod_ciclo3."','".$cod_ciclo4."','".$cod_ciclo5."', '".$cod_ciclo6."', '".$sem1."', '".$sem2."', '".$sem3."', '".$sem4."' ,'".$sem5."', '".$sem6."', '".$cod_cc2."','".$cod_car."','".$cod_jefe."')";
			
				
				$rs1=$conn->Execute($sql1);
				
				if($rs1){
					
					$respuesta="<span class='mensajes_success'>Se ingreso correctamente.</span>";
				}else{
					
					$respuesta="<span class='mensajes_error'>Error al Ingresar los registros.</span>";
				}
				
				return $respuesta;	
	
	}
	
	public function eliminar_prog_ini($id){
		
		global $conn;
		
		$sql0 = "delete from prog_mes_tur_ini where id ='$id'";
		
		$rs0=$conn->Execute($sql0);
		
		
		$sql1 = "delete from prog_mes_tur where id ='$id'";
		
		$rs1=$conn->Execute($sql1);
		
		if($rs1){
			$respuesta="<span style='text-align:center;'>Se Elimino el registro satisfactoriamente.</span>";
		}else{
			$respuesta="<span style='text-align:center;'>Error al Eliminar el registro.</span>";
		}
		return $respuesta;
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
	
	
	public function ciclos_programacion($cod_cc,$cod_jefe){
		
		global $conn;
		
		
		$sql="SELECT cod_ciclo, td1, td2, td3, td4, td5, td6, td7, total_horas, descripcion, cod_ocup FROM PROG_CICLO_TURNO where cod_ocup='".$cod_cc."' and cod_epl='".$cod_jefe."'";
		 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){
				
				
			 
				while($row = $res->FetchRow()){
				
				

					$this->lista1[] =  array("codigo_ciclo"=>mb_convert_encoding($row["cod_ciclo"],'HTML-ENTITIES', 'UTF-8'),						  "uno"=>utf8_encode($row["td1"]),
											"dos"=>utf8_encode($row["td2"]),											
											"tres"=>utf8_encode($row["td3"]),
											"cuatro"=>utf8_encode($row["td4"]),
											"cinco"=>utf8_encode($row["td5"]),
											"seis"=>utf8_encode($row["td6"]),
											"siete"=>utf8_encode($row["td7"]),
											"horas"=>utf8_encode($row["total_horas"]),											
											"area"=>utf8_encode($row["cod_ocup"]));	
				}
							
		 	
			}else{
				$this->lista1 = NULL;
			}	
	
			return $this->lista1;	
	}
	
	public function find_bs_ausencias_vac($ano,$mes,$area,$codigo){
	
		global $conn;
		
		/*verficar el estado de las ausencias*/
		$sql2="select * from bs_ausencias_vac where DATEPART(month, fec_ini_r)='".$mes."' and DATEPART(year, fec_ini_r)='".$ano."' and cod_epl='".$codigo."' and cod_cc2='".$area."' and estado <> 'P'";
		//var_dump($sql2); die(" consulta");
		
		$rs2=$conn->Execute($sql2);
		
		if($rs2->RecordCount() > 0){
			return 1;	
		}else{
		
			$sql3="select estado from ausencias where DATEPART(month, fec_ini_r)='".$mes."' and DATEPART(year, fec_ini_r)='".$ano."' and cod_epl='".$codigo."' and cod_cc2='".$area."'";
			//var_dump($sql3); die(" consulta");
			$rs3=$conn->Execute($sql3);
			
			if($rs3->RecordCount() > 0){
				
				$row = $rs3->FetchRow();
				
				if($row['estado']=='P'){
					
					return 2;
				
				}if($row['estado']=='V'){
					
					return 3;
						
				}else{
					return 4;
				}
				
			}else{
			
				return 5;
			}

		}
	
	}
	
	public function find_ausencias_vac($ano,$mes,$area,$codigo){
		
		global $conn;

		$sql3="select estado from ausencias where DATEPART(month, fec_ini_r)='".$mes."' and DATEPART(year, fec_ini_r)='".$ano."' and cod_epl='".$codigo."' and cod_cc2='".$area."'";
		$rs3=$conn->Execute($sql3);
		
		if($rs3->RecordCount() > 0){
			
			$row = $rs3->FetchRow();
			
			if($row['estado']=='P' || $row['estado']=='V'){
				
				return 2;
			
			}else{
				return 3;
			}
			
		}else{
		
			return 4;
		}

		
	}
	
	public function find_ausencias_vigentes($ano,$mes,$area,$codigo){
		
		global $conn;

		$sql3="select estado from ausencias where DATEPART(month, fec_ini_r)='".$mes."' and DATEPART(year, fec_ini_r)='".$ano."' and cod_epl='".$codigo."' and cod_cc2='".$area."'";
		
		$rs3=$conn->Execute($sql3);
		
		if($rs3->RecordCount() > 0){
			
			$row = $rs3->FetchRow();
			
			if($row['estado']=='V'){
				
				return 1;
			
			}else{
				return 2;
			}
			
		}else{
		
			return 3;
		}

		
	}
	
	public function eliminar_programacion($ano,$mes,$area,$cargo,$codigo,$nombre,$jefe){
		
		global $conn;
		
		$sql2="select * from bs_ausencias_vac where DATEPART(month, fec_ini_r)='".$mes."' and DATEPART(year, fec_ini_r)='".$ano."' and cod_epl='".$codigo."' and cod_cc2='".$area."' and estado='C'";
		$rs2=$conn->Execute($sql2);
		
		$flag=0;
		
		if($rs2->RecordCount() > 0){
			
			$sql3="delete from bs_ausencias_vac where DATEPART(month, fec_ini_r)='".$mes."' and DATEPART(year, fec_ini_r)='".$ano."' and cod_epl='".$codigo."' and cod_cc2='".$area."'";
			$conn->Execute($sql3);
			$flag=1;
			
		}else{
			
			$sql3="select estado from ausencias where DATEPART(month, fec_ini_r)='".$mes."' and DATEPART(year, fec_ini_r)='".$ano."' and cod_epl='".$codigo."' and cod_cc2='".$area."' and estado='P'";
			$rs3=$conn->Execute($sql3);
			
			if($rs3->RecordCount() > 0){
				
				$sql3="delete from ausencias where DATEPART(month, fec_ini_r)='".$mes."' and DATEPART(year, fec_ini_r)='".$ano."' and cod_epl='".$codigo."' and cod_cc2='".$area."'";
				$conn->Execute($sql3);
				$flag=1;
				
			}
		}
				
		$sql1 = "begin delete from prog_mes_tur where Ano='$ano' and Mes= '$mes' and cod_cc2='$area' and cod_car='$cargo' and cod_epl='$codigo';
				delete from prog_mes_tur_ini where Ano='$ano' and Mes= '$mes' and cod_cc2='$area' and cod_car='$cargo' and cod_epl='$codigo';
				end";
				
		$rs1=$conn->Execute($sql1);
		
		if($rs1 && $flag==0){
			$sql="insert into prog_novedades (cod_epl,ano,mes,detalle,cod_epl_jefe,fecha,tip_novedades) values('$codigo','$ano','$mes','Se elimino la programacion del empleado $nombre','$jefe',getdate(),1)";
			$rs=$conn->Execute($sql);
			$respuesta="<span style='text-align:center;'>Se Elimino el registro satisfactoriamente.</span>";
		}else if($flag==1){
			$sql="insert into prog_novedades (cod_epl,ano,mes,detalle,cod_epl_jefe,fecha,tip_novedades) values('$codigo','$ano','$mes','Se elimino la programacion con ausencias del empleado $nombre ','$jefe',getdate(),2)";
			$rs=$conn->Execute($sql);
			$respuesta="<span style='text-align:center;'>Se Elimino el registro satisfactoriamente.</span>";
		}else{
			$respuesta="<span style='text-align:center;'>Error al Eliminar el registro.</span>";
		}
		return $respuesta;
	}
	
	public function copiar_programacion($id){
		global $conn;
		
		$sql="select * from prog_mes_tur where id='".$id."'";
		$res=$conn->Execute($sql);
		if($res){
				
				
			 
				while($row = $res->FetchRow()){
					$this->lista1[] =  array("mes"=>utf8_encode($row["Mes"]),											
											"uno"=>utf8_encode($row["Td1"]),
											"dos"=>utf8_encode($row["Td2"]),											
											"tres"=>utf8_encode($row["Td3"]),
											"cuatro"=>utf8_encode($row["Td4"]),
											"cinco"=>utf8_encode($row["Td5"]),
											"seis"=>utf8_encode($row["Td6"]),
											"siete"=>utf8_encode($row["Td7"]),
											"ocho"=>utf8_encode($row["Td8"]),
											"nueve"=>utf8_encode($row["Td9"]),											
											"diez"=>utf8_encode($row["Td10"]),
											"once"=>utf8_encode($row["Td11"]),
											"doce"=>utf8_encode($row["Td12"]),
											"trece"=>utf8_encode($row["Td13"]),
											"catorce"=>utf8_encode($row["Td14"]),
											"quince"=>utf8_encode($row["Td15"]),
											"dieciseis"=>utf8_encode($row["Td16"]),											
											"diecisiete"=>utf8_encode($row["Td17"]),
											"dieciocho"=>utf8_encode($row["Td18"]),
											"diecinueve"=>utf8_encode($row["Td19"]),
											"veinte"=>utf8_encode($row["Td20"]),
											"veintiuno"=>utf8_encode($row["Td21"]),
											"veintidos"=>utf8_encode($row["Td22"]),
											"veintitres"=>utf8_encode($row["Td23"]),											
											"veinticuatro"=>utf8_encode($row["Td24"]),
											"veinticinco"=>utf8_encode($row["Td25"]),
											"ventiseis"=>utf8_encode($row["Td26"]),
											"veintisiete"=>utf8_encode($row["Td27"]),
											"veintiocho"=>utf8_encode($row["Td28"]),
											"veintinueve"=>utf8_encode($row["Td29"]),
											"treinta"=>utf8_encode($row["Td30"]),
											"treintaiuno"=>utf8_encode($row["Td31"]),
											"ano"=>utf8_encode($row["Ano"]),											
											"ciclo1"=>$row["cod_ciclo"],
											"ciclo2"=>$row["cod_ciclo2"],						
											"ciclo3"=>$row["cod_ciclo3"],
											"ciclo4"=>$row["cod_ciclo4"],					
											"ciclo5"=>$row["cod_ciclo5"],
											"ciclo6"=>$row["cod_ciclo6"],
											"sem1"=>utf8_encode($row["sem1"]),
											"sem2"=>utf8_encode($row["sem2"]),											
											"sem3"=>utf8_encode($row["sem3"]),
											"sem4"=>utf8_encode($row["sem4"]),											
											"sem5"=>utf8_encode($row["sem5"]),
											"sem6"=>utf8_encode($row["sem6"]),
											"cod_cc2"=>utf8_encode($row["cod_cc2"]),											
											"cod_car"=>utf8_encode($row["cod_car"]),
											"cod_epl_jefe"=>utf8_encode($row["cod_epl_jefe"]),);	
				}
							
		 	
			}else{
				$this->lista1 = NULL;
			}	
	
			return $this->lista1;
	}
	
	public function pegar_programacion($programacion,$cod_epl,$anio,$mes,$area,$cargo,$cod_jefe,$id){
	global $conn;
		$sql="select count(*)as cantidad from prog_mes_tur where cod_epl='".$cod_epl."' and Ano='".$anio."' and Mes='".$mes."'";
		$rs=$conn->Execute($sql);
		$fila=$rs->FetchRow();
		if($fila["cantidad"] > 0){
		
			$sql="update prog_mes_tur set mes=".$mes.", Td1='".$programacion[0]["uno"]."',Td2='".$programacion[0]["dos"]."',Td3='".$programacion[0]["tres"]."',
							Td4='".$programacion[0]["cuatro"]."',Td5='".$programacion[0]["cinco"]."',Td6='".$programacion[0]["seis"]."',
							Td7='".$programacion[0]["siete"]."',Td8='".$programacion[0]["ocho"]."',Td9='".$programacion[0]["nueve"]."',
							Td10='".$programacion[0]["diez"]."',Td11='".$programacion[0]["once"]."',Td12='".$programacion[0]["doce"]."',
							Td13='".$programacion[0]["trece"]."',Td14='".$programacion[0]["catorce"]."',Td15='".$programacion[0]["quince"]."',
							Td16='".$programacion[0]["dieciseis"]."',Td17='".$programacion[0]["diecisiete"]."',Td18='".$programacion[0]["dieciocho"]."',
							Td19='".$programacion[0]["diecinueve"]."',Td20='".$programacion[0]["veinte"]."',Td21='".$programacion[0]["veintiuno"]."',
							Td22='".$programacion[0]["veintidos"]."',Td23='".$programacion[0]["veintitres"]."',Td24='".$programacion[0]["veinticuatro"]."',
							Td25='".$programacion[0]["veinticinco"]."',Td26='".$programacion[0]["ventiseis"]."',Td27='".$programacion[0]["veintisiete"]."',
							Td28='".$programacion[0]["veintiocho"]."',Td29='".$programacion[0]["veintinueve"]."',Td30='".$programacion[0]["treinta"]."',
							Td31='".$programacion[0]["treintaiuno"]."',
							Ano='".$anio."', cod_ciclo='".$programacion[0]["ciclo1"]."', cod_ciclo2='".$programacion[0]["ciclo2"]."', 
							cod_ciclo3='".$programacion[0]["ciclo3"]."', cod_ciclo4='".$programacion[0]["ciclo4"]."', 
							cod_ciclo5='".$programacion[0]["ciclo5"]."', cod_ciclo6='".$programacion[0]["ciclo6"]."',
							sem1='".$programacion[0]["sem1"]."', sem2='".$programacion[0]["sem2"]."', sem3='".$programacion[0]["sem3"]."', 
							sem4='".$programacion[0]["sem4"]."' ,sem5='".$programacion[0]["sem5"]."', sem6='".$programacion[0]["sem6"]."'
							where id='".$id."'";
					  
			$rs=$conn->Execute($sql);
			if($rs){
				return "Se ha pegado la programación satisfactoriamente";
			}else{
				return "No se ha pegado la programación";
			}
		}else{
			
			$sql="insert into 
				prog_mes_tur(cod_epl,mes,Td1,Td2,Td3,Td4,Td5,Td6,Td7,Td8,Td9,Td10,Td11,Td12,Td13,Td14,Td15,Td16,Td17,Td18,Td19,Td20,Td21,Td22,Td23,Td24,Td25,Td26,Td27,Td28,Td29,Td30,Td31, Ano, cod_ciclo, cod_ciclo2, cod_ciclo3, cod_ciclo4, cod_ciclo5, cod_ciclo6, sem1, sem2, sem3, sem4 ,sem5, sem6, cod_cc2, cod_car, cod_epl_jefe) 
				      values('".$cod_epl."',".$mes.",'".$programacion[0]["uno"]."','".$programacion[0]["dos"]."','".$programacion[0]["tres"]."',
					  '".$programacion[0]["cuatro"]."','".$programacion[0]["cinco"]."','".$programacion[0]["seis"]."','".$programacion[0]["siete"]."',
					  '".$programacion[0]["ocho"]."','".$programacion[0]["nueve"]."','".$programacion[0]["diez"]."','".$programacion[0]["once"]."',
					  '".$programacion[0]["doce"]."','".$programacion[0]["trece"]."','".$programacion[0]["catorce"]."','".$programacion[0]["quince"]."',
					  '".$programacion[0]["dieciseis"]."','".$programacion[0]["diecisiete"]."','".$programacion[0]["dieciocho"]."','".$programacion[0]["diecinueve"]."',
					  '".$programacion[0]["veinte"]."','".$programacion[0]["veintiuno"]."','".$programacion[0]["veintidos"]."',
					  '".$programacion[0]["veintitres"]."','".$programacion[0]["veinticuatro"]."','".$programacion[0]["veinticinco"]."','".$programacion[0]["ventiseis"]."',
					  '".$programacion[0]["veintisiete"]."','".$programacion[0]["veintiocho"]."','".$programacion[0]["veintinueve"]."',
					  '".$programacion[0]["treinta"]."','".$programacion[0]["treintaiuno"]."',".$anio.",'".$programacion[0]["ciclo1"]."',
					  '".$programacion[0]["ciclo2"]."','".$programacion[0]["ciclo3"]."','".$programacion[0]["ciclo4"]."',
					  '".$programacion[0]["ciclo5"]."', '".$programacion[0]["ciclo6"]."',
					  '".$programacion[0]["sem1"]."', '".$programacion[0]["sem2"]."', '".$programacion[0]["sem3"]."',
					  '".$programacion[0]["sem4"]."' ,'".$programacion[0]["sem5"]."', '".$programacion[0]["sem6"]."',
					  '".$area."','".$cargo."','".$cod_jefe."')";
					  
			$rs=$conn->Execute($sql);
			if($rs){
				return "Se ha pegado la programación satisfactoriamente";
			}else{
				return "No se ha pegado la programación";
			}
			
		}
		//return $programacion[0]["dos"];
		
	}
	
		
	
	public function insertar_programacion_auditoria($turno_si,$horas,$mes, $T1, $T2, $T3, $T4, $T5, $T6, $T7, $T8, $T9, $T10, $T11, $T12, $T13, $T14, $T15, $T16, $T17, $T18, $T19, $T20, $T21, $T22, $T23, $T24, $T25, $T26, $T27, $T28, $T29, $T30, $T31, $ano, $sem1, $sem2, $sem3, $sem4 ,$sem5, $sem6,$cod_cc2,$cod_car,$codigo, $hor_ini, $hor_fin){	
				
				global $conn;
				
								
				$sql1="insert into prog_mes_tur_auditoria(cod_tur, horas, mes,Td1,Td2,Td3,Td4,Td5,Td6,Td7,Td8,Td9,Td10,Td11,Td12,Td13,Td14,Td15,Td16,Td17,Td18,Td19,Td20,Td21,Td22,Td23,Td24,Td25,Td26,Td27,Td28,Td29,Td30,Td31, Ano, sem1, sem2, sem3, sem4 ,sem5, sem6, cod_cc2, cod_car, cod_epl_jefe, hor_ini, hor_fin) 
				      values('".$turno_si."',".$horas.",".$mes.",'".$T1."','".$T2."','".$T3."','".$T4."','".$T5."','".$T6."','".$T7."','".$T8."','".$T9."','".$T10."','".$T11."','".$T12."','".$T13."','".$T14."','".$T15."','".$T16."','".$T17."','".$T18."','".$T19."','".$T20."','".$T21."','".$T22."','".$T23."','".$T24."','".$T25."','".$T26."','".$T27."','".$T28."','".$T29."','".$T30."','".$T31."',".$ano.",".$sem1.", ".$sem2.", ".$sem3.", ".$sem4." ,".$sem5.", ".$sem6.", '".$cod_cc2."','".$cod_car."','".$codigo."','".$hor_ini."','".$hor_fin."')";
					 
				
				//return $sql1;
				
				//var_dump($sql1);die();
				
				$rs1=$conn->Execute($sql1);
							
				
				if($rs1){
					
					$respuesta="<span class='mensajes_success'>Se ingreso correctamente.</span>";
				}else{
					
					$respuesta="<span class='mensajes_error'>Error al Ingresar los registros.</span>";
				}
				
				return 	$respuesta;
			
	
	}
	
	public function supernumerario_tmp($jefe){
		
		global $conn;
		
		unset($this->lista1);$this->lista1=array();
		
		$sql="select Id,nombre from supernumerario_tmp where cod_epl_jefe='".$jefe."'";
		$res=$conn->Execute($sql);
				
		while($row = $res->FetchRow()){
			
			$this->lista1[]=array("codigo" => $row["Id"],
								  "nombre" => utf8_encode($row["nombre"]));
		}
		
		return $this->lista1;
	}
	
	
	public function centro_costo_empleado($cod_epl){
                    
                    global $conn;
			
			try{
                            $sql="select cod_cc2 from empleados_basic  where cod_epl='".$cod_epl."'";
                            $rs=$conn->Execute($sql);
                            while($fila=$rs->FetchRow()){
                                $this->lista5[]=array("cod_cc2"   => $fila["cod_cc2"]);
				
                            }
                            return $this->lista5;
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}
                    
                    
                }
	
	
	
	
}