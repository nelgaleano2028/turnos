<?php require_once("../librerias/lib/connection.php");


 global $conn;

 $mes=$_POST['mes'];
 $anio=$_POST['anio'];
 

 /*Para los supernumerarios que estan haciendo cubrimiento de area y solo se hace la programacion en el tiempo que se ha asignado en gestion humana*/
 $sqlSuper_ini="
	select TOP(1) DATEPART(day, fec_ini) as dia_inicio,DATEPART(month, fec_ini) as mes_inicio, DATEPART(year, fec_ini) as anio_inicio 
	from supernumerario_nov 
	where cod_epl_super='".$_POST['cod_epl']."' and DATEPART(month, fec_ini)='".$mes."' and DATEPART(year, fec_ini)='".$anio."'
	and cod_epl_reemp is null";

	
	
 $resSuper_ini=$conn->Execute($sqlSuper_ini);
 $rowSup_ini=$resSuper_ini->FetchRow();
 
 
 $sqlSuper_fin="
	select TOP(1) DATEPART(day, fec_fin) as dia_fin ,DATEPART(month, fec_fin) as mes_fin, DATEPART(year, fec_fin) as anio_fin 
	from supernumerario_nov 
	where cod_epl_super='".$_POST['cod_epl']."' and DATEPART(month, fec_fin)='".$mes."' and DATEPART(year, fec_fin)='".$anio."'
	and cod_epl_reemp is null";
	
	
 $resSuper_fin=$conn->Execute($sqlSuper_fin);
 $rowSup_fin=$resSuper_fin->FetchRow();
 
 /*fin  de consultas de supernumerario*/
 
 
 if( $resSuper_ini->RecordCount() > 0 && $resSuper_fin->RecordCount() > 0){

		
		$semana_inicio=semana($rowSup_ini['dia_inicio'],$rowSup_ini['mes_inicio'],$rowSup_ini['anio_inicio']);
		
		$dia_inicio=array('semana'=>$semana_inicio,   
						  'dia_numero'=>(int)date('N',strtotime($rowSup_ini['dia_inicio']."-".$rowSup_ini['mes_inicio']."-".$rowSup_ini['anio_inicio'])), 
						  'inicia'=>2,
						  'dia_mes1'=>(int)date('N',strtotime("1-".$mes."-".$anio)),
						  'dia_mes2'=>(int)date('N',strtotime($rowSup_ini['dia_inicio']."-".$rowSup_ini['mes_inicio']."-".$rowSup_ini['anio_inicio']))
						  
						  );
						  
		
		$semana_fin=semana($rowSup_fin['dia_fin'],$rowSup_fin['mes_fin'],$rowSup_fin['anio_fin']);
						  
	    $dias_fin=array('semana'=>$semana_fin,
						 'dia_numero'=>(int)date('N',strtotime($rowSup_fin['dia_fin']."-".$rowSup_fin['mes_fin']."-".$rowSup_fin['anio_fin'])),
						'inicia'=>2,
						'retiro'=>3,
						'ret'=>'super'
						);
		
		
 
 

}else if($resSuper_ini->RecordCount() < 0 && $resSuper_fin->RecordCount() == 0 ){

	
	/*$dia_inicio=array('semana'=>$semana_inicio,   
							 'dia_numero'=>(int)date('N',strtotime($dia_inicio[0]."-".$mes."-".$anio)), 
							 'inicia'=>1,
							 'dia_mes'=>(int)date('N',strtotime("1-".$mes."-".$anio)));*/



		$semana_inicio=semana($rowSup_ini['dia_inicio'],$rowSup_ini['mes_inicio'],$rowSup_ini['anio_inicio']);
		
		$dia_inicio=array('semana'=>$semana_inicio,   
						  'dia_numero'=>(int)date('N',strtotime($rowSup_ini['dia_inicio']."-".$rowSup_ini['mes_inicio']."-".$rowSup_ini['anio_inicio'])), 
						  'inicia'=>2,
						   'dia_mes1'=>(int)date('N',strtotime("1-".$mes."-".$anio)),
						  'dia_mes2'=>(int)date('N',strtotime($rowSup_ini['dia_inicio']."-".$rowSup_ini['mes_inicio']."-".$rowSup_ini['anio_inicio']))
						  );
		
		$dia_fin=date("d",mktime(0,0,0,$mes+1,0,$anio));	
		
		
		$semana_fin=semana($dia_fin,$mes,$anio);
						  
	    $dias_fin=array('semana'=>$semana_fin,
						 'dia_numero'=>(int)date('N',strtotime($dia_fin."-".$mes."-".$anio)),
						'retiro'=>0
						);


}else if($resSuper_fin->RecordCount() > 0 && $resSuper_ini->RecordCount() == 0 ){


		
		$dia_inicio=array('semana'=>1,   
						  'dia_numero'=>(int)date('N',strtotime("1-".$mes."-".$anio)), 
						  'inicia'=>0,
						  );

		
		$semana_fin=semana($rowSup_fin['dia_fin'],$rowSup_fin['mes_fin'],$rowSup_fin['anio_fin']);
						  
	    $dias_fin=array('semana'=>$semana_fin,
						 'dia_numero'=>(int)date('N',strtotime($rowSup_fin['dia_fin']."-".$rowSup_fin['mes_fin']."-".$rowSup_fin['anio_fin'])),
						'inicia'=>2,
						'retiro'=>3,
						'ret'=>'super'
						);
		


}else{

		 //Consulta SQL para inicio de contrato y terminacion de contrato
		$sql="select ini_cto,vto_cto,fec_ret from empleados_basic where cod_epl='".$_POST['cod_epl']."'";
		$res=$conn->Execute($sql);
		$row=$res->FetchRow();


		//validacion de inicio de contrato del empleado

		//$row['ini_cto']='2013-08-02 00:00:00.000';

		$mes_inicio_cto=explode("-",@$row['ini_cto']);

		 
		 if($mes==@$mes_inicio_cto[1] && $anio==@$mes_inicio_cto[0]){
		 
			$dia_inicio=explode(" ",$mes_inicio_cto[2]);
			
			$semana_inicio=semana($dia_inicio[0],$mes,$anio);

			$dia_inicio=array('semana'=>$semana_inicio,   
							 'dia_numero'=>(int)date('N',strtotime($dia_inicio[0]."-".$mes."-".$anio)), 
							 'inicia'=>1,
							 'dia_mes'=>(int)date('N',strtotime("1-".$mes."-".$anio)));

		}else{
			$dia_inicio=array('semana'=>1,
							 'dia_numero'=>(int)date('N',strtotime("1-".$mes."-".$anio)), 
							 'inicia'=>0);
		}
	
	//print_r($dia_inicio); die();

		//$row['vto_cto']='2013-10-23 00:00:00.000';
		//$row['fec_ret']='2013-10-23 00:00:00.000';

		$mes_retiro_cto=explode("-",@$row['vto_cto']);
		
	
		if(@$row['vto_cto']==NULL){
		@$flag==2;
		}
		$mes_retiro_ret=explode("-",@$row['fec_ret']);

		if(@$row['fec_ret']==NULL){
		@$flago==3;
		}

		//echo $mes_retiro_cto[1]; die();



		//validacion fin del contrato
		if((@$row['vto_cto']==NULL && @$row['fec_ret']==NULL)){
			
			$dia_mes=date("d",mktime(0,0,0,$mes+1,0,$anio));// me arroja los dias que tiene un mes				
						
			$semana_fin=semana($dia_mes,$mes,$anio);

			$dias_fin=array('semana'=>$semana_fin,
							'dia_numero'=>(int)date('N',strtotime($dia_mes."-".$mes."-".$anio)),
							'retiro'=>0);

		}else if( $mes != @$mes_retiro_cto[1] && @$flag==1 ){ //|| $mes != @$mes_retiro_ret[1]
			
			//die("hola 1");	
				$dia_mes=date("d",mktime(0,0,0,$mes+1,0,$anio));// me arroja los dias que tiene un mes				
						
				$semana_fin=semana($dia_mes,$mes,$anio);

				$dias_fin=array('semana'=>$semana_fin,
								'dia_numero'=>(int)date('N',strtotime($dia_mes."-".$mes."-".$anio)),
								'retiro'=>0);
							
		}else if( $mes != @$mes_retiro_ret[1]  && @$flago==1){ //|| $mes != @$mes_retiro_ret[1]
			//die("hola 2");	
				
				$dia_mes=date("d",mktime(0,0,0,$mes+1,0,$anio));// me arroja los dias que tiene un mes				
						
				$semana_fin=semana($dia_mes,$mes,$anio);

				$dias_fin=array('semana'=>$semana_fin,
							'dia_numero'=>(int)date('N',strtotime($dia_mes."-".$mes."-".$anio)),
							'retiro'=>0);
							
		}else if($mes== @$mes_retiro_ret[1] and $anio== $mes_retiro_ret[0]){
		//die("hola 3"); entro en hola 3
			$dia_retiro=explode(" ",$mes_retiro_ret[2]);
			
			$semana_fin=semana($dia_retiro[0],$mes,$anio);
			
			
			$dias_fin=array('semana'=>$semana_fin,
							'dia_numero'=>(int)date('N',strtotime($dia_retiro[0]."-".$mes."-".$anio)),
							'ret'=>'fec_ret',
							'retiro'=>1);

		}else if($mes== @$mes_retiro_cto[1] ){
         //die("hola 4");
			$dia_retiro=explode(" ",$mes_retiro_cto[2]);
			
			$semana_fin=semana($dia_retiro[0],$mes,$anio);
			
			
			$dias_fin=array('semana'=>$semana_fin,
							'dia_numero'=>(int)date('N',strtotime($dia_retiro[0]."-".$mes."-".$anio)),
							'ret'=>'vto_cto',
							'retiro'=>1);

		}else{ // arreglar esto hay un bug cuando encuentra una fecha de vencimiento de contraro o de retiro
           //die("hola 5");
			$dia_mes=date("d",mktime(0,0,0,$mes+1,0,$anio));// me arroja los dias que tiene un mes				
						
				$semana_fin=semana($dia_mes,$mes,$anio);

				$dias_fin=array('semana'=>$semana_fin,
							'dia_numero'=>(int)date('N',strtotime($dia_mes."-".$mes."-".$anio)),
							'retiro'=>0);

		}
		



}
	

  //die();

			
echo json_encode(array('dia_inicio'=>$dia_inicio,'dia_fin'=>$dias_fin));

function semana($dia_mes,$mes,$anio){

    $con_sem=0;
	
	for ($j=1;$j<=$dia_mes;$j++){
		
		$domingo=(int)date('N',strtotime($j."-".$mes."-".$anio));
		
		if($domingo==7 && $j != $dia_mes){
			$con_sem++;
		}else if($j==$dia_mes && $j != $domingo){
			$con_sem++;	
		}
	}
	
	if($con_sem==0){
		
		$con_sem=1;
	
	}
	
	return $con_sem;
}					
?>