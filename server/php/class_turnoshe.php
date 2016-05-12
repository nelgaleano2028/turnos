<?php

require_once("../librerias/lib/connection.php");

class Turnoshe{
    
	private $lista=null;
    private $cod_epl=null;
	
	
	public function usuarios_jefes(){
		
		global $conn;
		
		$sql="select cod_epl,usuario from acc_usuariosTurnosWeb where cod_gru_prg='TURNOSJEFE'";
						 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){
						 
				while($row = $res->FetchRow()){						

					$this->lista[] =  array("usuario"=>$row["usuario"],
											"cod_epl"=>$row["cod_epl"]);	
				}
							
		 	
			}else{
				$this->lista = NULL;
			}	
	
			return $this->lista;	
	}
	
	
	public function anio_programaciones_anteriores(){
		
		global $conn;
		
		$sql="select ano from prog_mes_tur group by ano";
						 
		 	$res=$conn->Execute($sql);
		 
		 	if($res){
						 
				while($row = $res->FetchRow()){						

					$this->lista1[] =  array("anio"=>$row["ano"]);	
				}
							
		 	
			}else{
				$this->lista1 = NULL;
			}	
	
			return $this->lista1;	
	}
	
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
									 "area"	  => utf8_encode($fila["NOM_CC2"]));
			}
			
			return $this->lista3;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		} 
	}
	
	
	public function consultar_turnos(){
	
		try { 
			global $conn;
			$sql="select cod_tur,horas, convert(varchar,hor_ini, 108 )as hor_ini,convert(varchar,hor_fin, 108 )as hor_fin, usuario
				  from turnos_prog_tmp, acc_usuariosTurnosWeb where cod_cargo=cod_epl and cod_gru_prg='turnosjefe'
				  union 
				  select  cod_tur,horas, convert(varchar,hor_ini, 108 )as hor_ini,convert(varchar,hor_fin, 108 )as hor_fin, usuario='Predeterminado' 
				  from turnos_prog ";
					
			$rs=$conn->Execute($sql);
			while($fila=$rs->FetchRow()){
				$this->lista3[]=array("cod_tur" => $fila["cod_tur"],
									  "horas"	=> $fila["horas"],
									  "hor_ini" => $fila["hor_ini"],
									  "hor_fin" => $fila["hor_fin"],
									  "usuario" => $fila["usuario"]
									  
									 );
			}
			
			return $this->lista3;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		} 

	}
	
	public function consultar_novedades(){
	
		try { 
			global $conn;
			$sql="SELECT n.COD_EPL as codigo, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado, VLR_NOV as valor, USUARIO_DIG as usuario, convert(varchar,FECHA_DIG, 103) as fecha, ESTADO_APR as estado
				FROM novedades_rmto n, empleados_basic b where n.cod_epl=b.cod_epl";
					
			$rs=$conn->Execute($sql);
			while($fila=$rs->FetchRow()){
				$this->lista3[]=array("codigo" => @$fila["codigo"],
									  "empleado" => @$fila["empleado"],
									  "valor" => @$fila["valor"],
									  "usuario" => @$fila["usuario"],
									  "fecha" => @$fila["fecha"],
									  "estado" => @$fila["estado"]
									 );
			}
			
			//var_dump($this->lista3); die();
			return @$this->lista3;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		} 

	}
	
	public function consultar_aprobacion(){
	
		try { 
			global $conn;
			//$sql="SELECT p.cod_epl, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado, convert(varchar,p.fecha, 103) as fecha, hed_rel, hen_rel, hedf_rel, henf_rel, hfd_rel, rno_rel, rnf_rel, hed_apr, hen_apr, hedf_apr
			//	 henf_apr, hfd_apr, rno_apr, rnf_apr, p.estado, a.usuario   FROM prog_reloj_he p, acc_usuariosTurnosWeb a, empleados_basic b WHERE  p.cod_epl_jefe=a.cod_epl and p.cod_epl=b.cod_epl  and p.estado='Aprobado'";
			
$sql="SELECT p.cod_epl, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado, convert(varchar,p.fecha, 103) as fecha, 

hed_rel, hen_rel, hedf_rel, henf_rel, hfd_rel, rno_rel, rnf_rel, hed_apr, hen_apr, hedf_apr, henf_apr, hfd_apr, rno_apr, rnf_apr, 

p.estado, a.usuario   FROM prog_reloj_he p, acc_usuariosTurnosWeb a, empleados_basic b WHERE  p.cod_epl_jefe=a.cod_epl and p.cod_epl=b.cod_epl  and p.estado='Aprobado'";

			
			$rs=$conn->Execute($sql);
			while($fila=$rs->FetchRow()){
				$this->lista3[]=array("codigo" => @$fila["cod_epl"],
									  "empleado" => @$fila["empleado"],
									  "fecha" => @$fila["fecha"],
									  "hed_rel" => number_format(@$fila["hed_rel"],2,",","."),
									  "hen_rel" => number_format(@$fila["hen_rel"],2,",","."),
									  "hedf_rel" => number_format(@$fila["hedf_rel"],2,",","."),
									  "henf_rel" => number_format(@$fila["henf_rel"],2,",","."),
									  "hfd_rel" => number_format(@$fila["hfd_rel"],2,",","."),
									  "rno_rel" => number_format(@$fila["rno_rel"],2,",","."),
									  "rnf_rel" => number_format(@$fila["rnf_rel"],2,",","."),
									  "hed_apr" => number_format(@$fila["hed_apr"],2,",","."),
									  "hen_apr" => number_format(@$fila["hen_apr"],2,",","."),
									  "hedf_apr" => number_format(@$fila["hedf_apr"],2,",","."),
									  "henf_apr" => number_format(@$fila["henf_apr"],2,",","."),
									  "hfd_apr" => number_format(@$fila["hfd_apr"],2,",","."),
									  "rno_apr" => number_format(@$fila["rno_apr"],2,",","."),
									  "rnf_apr" => number_format(@$fila["rnf_apr"],2,",","."),
									  "estado" => @$fila["estado"],
									  "usuario" => @$fila["usuario"]

									 );
			}
			
			//var_dump($this->lista3); die();
			return @$this->lista3;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		} 

	}
	
	
	public function consultar_ciclos(){
	
		try { 
			global $conn;
			$sql=" select cod_ciclo, td1 as L, td2 as M, td3 as MI, td4 as J, td5 as V, td6 as S, td7 as D, p.descripcion, usuario
					from prog_ciclo_turno p, acc_usuariosTurnosWeb a where p.cod_epl=a.cod_epl";
					
			$rs=$conn->Execute($sql);
			while($fila=$rs->FetchRow()){
				$this->lista3[]=array("cod_ciclo" => $fila["cod_ciclo"],
									  "L"	=> $fila["L"],
									  "M" => $fila["M"],
									  "MI" => $fila["MI"],
									  "J" => $fila["J"],
									  "V" => $fila["V"],
									  "S" => $fila["S"],
									  "D" => $fila["D"],
									  "descripcion" => $fila["descripcion"],
									  "usuario" => $fila["usuario"] 
									 
									  
									 );
			}
			
			return $this->lista3;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		} 

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
	
	
	
}


?>