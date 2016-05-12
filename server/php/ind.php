<?php
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);

//TABLA DE ROVER CALENDARIO DINAMICO

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
			else $hoy=$_GET["ano"]."-".$_GET["mes"]."-01";
			
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
			
		/*fin de numeros dias*/
			$resultado=array();
			$resultado[]=array("calendario1" => array("numeros" => $numeros),
							   "calendario2" => array("dias" => $letras));
			//echo json_encode(array_combine($numeros,$letras));
			
			echo json_encode($resultado);
			
		

	
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
