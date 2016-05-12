<?php 
	session_start();
	include_once("class_turnos.php");
	
	$info=0;
	
	if(isset($_GET["info"])){
		$info=1;
	}
	$param=@$_GET["param"];
	
	
	if(isset($_GET["id"]) && isset($_GET["input"])){
		$id=@$_GET["id"];
		$input=@$_GET["input"];
		$input2=@$_GET["input2"];
		
	}
	$turnos = new turnos();
	$turnos->set_empleado(@$_SESSION['cod_epl']);
	
	$tabla="";
	
	
	if($info==1){
	
		$tablas=$turnos->fusion_turnos2($_SESSION['cod_epl']);
	}else{
		
		$tablas=$turnos->fusion_turnos($_SESSION['cod_epl']);
	
	}
	
		$tabla .= "<table class='tableone table-bordered' border='0' id='ciclos_new' style=' width: 100%;  border:2px solid rgb(41, 76, 139) !important;'>";
		
        $tabla .= "<thead>";
		$tabla .= "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'>";
		$tabla .= "<th  scope='col' style='overflow: hidden;'>C&oacute;d. Turno</th>";
		$tabla .= "<th  scope='col' style='overflow: hidden;'>Hora ini</th>";
		$tabla .= "<th scope='col' style='overflow: hidden;'>Hora Fin</th>";
		$tabla .= "<th scope='col' style='overflow: hidden;'>Horas</th>";
		$tabla .= "</tr>";		
		$tabla .= "</thead>";
		
		$tabla .= "<tbody id='tur'>";
			$i=1;
			
/*
$tabla .= "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'>";
		$tabla .= "<th><input style='width:40px;' type='text'></th>";
		$tabla .= "<th>";
		$tabla .="<input style='width:40px;'  type='text' class='letras' id='sies'  name='hora_ini' onclick=\"filtros_new(event)\">";
		$tabla .="</th>";
		$tabla .= "<th><input  style='width:40px;' class='xlarge' type='text' class='input'  name='hora_fin' ></th>";
		$tabla .= "<th><input  style='width:40px;'  type='text' class='input'  name='horas' ></th>";
		$tabla .= "</tr>";
*/


			
			foreach($tablas as $value){
			
						if($i % 2){                             
                             $tabla .= "<tr class='si' style='cursor:pointer; background-color: #FFF;' onMouseOver='this.style.background=\"rgb(175, 203, 238)\"' onMouseOut='this.style.background=\"#FFF\"'>";
                        }else{
                             $tabla .= "<tr class='si' style='cursor:pointer; background-color: #eee;' onMouseOver='this.style.background=\"rgb(175, 203, 238)\"' onMouseOut='this.style.background=\"#eee\"'>"; 
							 
                        }			
				if(isset($id)){
					$tabla  .= "<td id='tur$i' onclick=\"return copiar_turn('".$value["codigo_turno"]."','".$param."','".$id."','".$input."','".$input2."',".$value["horas"].")\">".$value["codigo_turno"]."</td>";
				}else{
					$tabla  .= "<td id='tur$i' onclick=\"return copiar_turn('".$value["codigo_turno"]."','".$param."',".$value["horas"].")\">".$value["codigo_turno"]."</td>";
				}
				$tabla  .= "<td  style='overflow: hidden;'>".$value["hora_ini"]."</td>";
				$tabla  .= "<td  style='overflow: hidden;'>".$value["hora_fin"]."</td>";
				$tabla  .= "<td  style='overflow: hidden;'>".$value["horas"]."</td>";
				$tabla .= "</tr>";
				
				$i++;
			}

		$tabla .= "</tbody>";
		$tabla .= "</table>";
	
	echo $tabla;
?>