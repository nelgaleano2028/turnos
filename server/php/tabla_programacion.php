<?php
require_once("class_superquery.php");


$obj= new  Superquery();
$lista=$obj->tabla($anio,$mes,$cargo,$centro_costo,$perfil);


 
$formato_texto="\@";

		
if (!isset($_GET["fecha"])) 
			{
				$mesactual=intval(date("m"));
				if ($mesactual<10) $elmes="0".$mesactual;
				else $elmes=$mesactual;
				$elanio=date("Y");
			} 
			else 
			{
				$cortefecha=explode("-",$_GET["fecha"]);
				$mesactual=intval($cortefecha[1]);
				if ($mesactual<10) $elmes="0".$mesactual;
				else $elmes=$mesactual;
				$elanio=$cortefecha[0];
			}
			
			$primeromes=date("N",mktime(0,0,0,$mesactual,1,$elanio));
			
			if (!isset($_GET["mes"])) $hoy=date("Y-m-d"); 
			else $hoy=$_GET["anio"]."-".$_GET["mes"]."-01";
			
			if (($elanio % 4 == 0) && (($elanio % 100 != 0) || ($elanio % 400 == 0))) $dias=array("","31","29","31","30","31","30","31","31","30","31","30","31");
			else $dias=array("","31","28","31","30","31","30","31","31","30","31","30","31");
			
			
			$eventos=array();
			
			
		
			
			
			$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$diasantes=$primeromes-1;
			$diasdespues=42;
			$tope=$dias[$mesactual]+$diasantes;
			if ($tope%7!=0) $totalfilas=intval(($tope/7)+1);
			else $totalfilas=intval(($tope/7));
			
			$letras = array();
				
			
			/*inicio de letras dias*/
			$p=1;
			$filita2=0;
			for ($v=1;$v<=$diasdespues;$v++)
			{
				if ($filita2<$totalfilas)
				{
				  
				if ($v>=$primeromes && $v<=$tope) 
				{
					
					if ($p<10) $dd="0".$p;else $dd=$p;
					
					date_default_timezone_set('America/Bogota');
				    $prueba="$dd-$elmes-".$elanio;
					$prueba=strtotime($prueba);
					$prueba2=date('l',$prueba);
					$prueba3=get_dias($prueba2);
					$compuesta=$elanio."-$elmes-$dd";
					
					if (count($eventos)>0) {$noagregar=true;}
					else {$noagregar=false;}
					
					array_push($letras,$prueba3);
					$p+=1;
				}
			}
			}
			/*fin de letras dias*/
			
			
			
			$numeros = array();
			/*inicio de numeros dias*/
			$j=1;
			$filita=0;
			
			for ($i=1;$i<=$diasdespues;$i++)
			{
				if ($filita<$totalfilas)
				{
				if ($i>=$primeromes && $i<=$tope) 
				{
					
			
				
					if ($j<10) $dd="0".$j;else $dd=$j;
					$compuesta=$elanio."-$elmes-$dd";
					
					if (count($eventos)>0) {$noagregar=true;}
					else {$noagregar=false;}
					array_push($numeros,$j);

					$j+=1;
				}
				
				
				}
			}
			$filita+=1;
			
		
	   $html='<table border="1"><thead><tr><th scope="col" rowspan="2" align="center" width="110px">Empleado</th>';
		
		for($j=0; $j < count($numeros); $j++){
			
			$html.='<th scope="col" align="center" width="27px" style="mso-number-format:General" >'.$numeros[$j].'</th>';
		}
		
		$html.='</tr><tr>';
		
		for($i=0; $i < count($letras); $i++){
			
			$html.='<th scope="col" align="center" width="27px" style="mso-number-format:General" >'.$letras[$i].'</th>';
		}
			
			
		$html.='</tr></thead>';
		
	
		$cont=count(@$lista);
	
		$html.= '<tbody >';
		
		for($p=0; $p<$cont; $p++){
			
			$html.='<tr>';
				
			$html.='<td width="110px">'.@$lista[$p]['empleado'].'</td>';
			
			
			for($l=1; $l <=count($numeros); $l++){
			
			
			   $sql1="select * from feriados where fec_fer='$anio-$l-$mes'";
					
					$rs1=$conn->Execute($sql1);
					
					$row11 = $rs1->FetchRow();
					
					$res=$row11["fec_fer"];
					
					//METODO IMPORTANTE que segun la fecha ingresada te dice que dia es. 0="sunday", 1="monday"...etc
					$fecha_l= "$anio/$mes/$l";
					$a = strtotime($fecha_l);
					$validar=jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$a),date("d",$a), date("Y",$a)) , 0 );
					//FIN METODO
					
					
					if($res or $validar==0){
										
					$html.= '<td align="center" bgcolor="#A0A0A0" width="27px" style="mso-number-format:$formato_texto">&nbsp;'.strval(@$lista[$p][$l]).'</td>';
					
					}else{
				
						$html.= '<td align="center" width="27px" style="mso-number-format:$formato_texto">&nbsp;'.strval(@$lista[$p][$l]).'</td>';
					}
			
				//$html.= '<td align="center" width="27px" >'.@$lista[$p][$l].'</td>';
			}
					
				$html .= '</tr>';
		
		}
		
		$html.= '</tbody></table>';
		
		
		
		
		
		
		function get_dias($prueba2){
			
			$dia=$prueba2;
			$return="";
		
			switch ($dia){

				case 'Monday':
					$return='L';
				break;
				case 'Tuesday':
					$return='M';
				break;
				case 'Wednesday':
					$return='M';
				break;
				case 'Thursday':
					$return='J';
				break;
				case 'Friday':
					$return='V';
				break;
				case 'Saturday':
					$return='S';
				break;
				case 'Sunday':
					$return='D';
				break;
				
			}
			
			return $return;
			
		}
?>