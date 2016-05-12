<?php
require_once("../librerias/lib/connection.php");
		
		global $conn;				
		
		$centro_costo=$_POST['cod_cc2'];		
		$codigo_jefe=$_POST['usuario_dig'];
		$conteo_epl=$_POST['conta_epl'];		
		$id_autorizacion_post=$_POST['clave_autorizacion'];		
		
		
		
		//PARA UNIR 2 VARIABLES EN UNA SOLA DINAMICAMENTE ES MEJOR POR ARRAYS
		for($i=0;$i<$conteo_epl;$i++){
			$cod_epl[$i]=$_POST['cod_epl_'.$i];
		}
		
		for($i=0;$i<$conteo_epl;$i++){
			$cod_con_nom[$i]=$_POST['cod_con_'.$i];
		}
		
		for($i=0;$i<$conteo_epl;$i++){
			$vlr_nov[$i]=$_POST['vlr_nov_'.$i];
		}
		

		//var_dump($cod_con);die();

$sql0="SELECT usuario FROM acc_usuariosTurnosWeb where cod_epl='".$codigo_jefe."'";

$rs0=$conn->Execute($sql0);

$row0 = $rs0->fetchrow();

$usuario=$row0['usuario'];	


//Para saber si hay filas con estado pendiente y no autorice
$sql5="select * FROM prog_reloj_he where estado='Validada'";

		$rs15=$conn->Execute($sql5);

		$row15 = $rs15->fetchrow();

		$fila=$row15['estado'];	

		
	if($fila == null){	
		
		echo "3"; 
		exit;
	}

	
$sql="SELECT id FROM ACC_USUARIOSTUR where usuario='".$usuario."'";

$rs=$conn->Execute($sql);

$row = $rs->fetchrow();

$id_autorizacion=$row['id'];

if($id_autorizacion==NULL){

	echo "4"; 
	exit;

}


if($id_autorizacion==$id_autorizacion_post){

	

for($i=0;$i<$conteo_epl;$i++){

	$sql1="update prog_reloj_he set estado='Aprobado' where estado='Validada'";
	
	//var_dump($sql1);die();
	
	$conn->Execute($sql1);
		
	
		
   $sql3="select cod_con FROM CONCEPTOS c  where c.cod_con in (4,5,6,7,8,9,10) and nom_con='".$cod_con_nom[$i]."' order by cod_con asc";
		
   $rs3=$conn->Execute($sql3);
   
   $row3 = $rs3->fetchrow();

   $cod_con=$row3['cod_con'];	

   

	
	
	$fecha_dig=date("d/m/Y");
  

	$sql2="insert into NOVEDADES_RMTO values('$cod_epl[$i]', '$cod_con', '$vlr_nov[$i]','C', 0,'".$centro_costo."', '".$usuario."', '".$fecha_dig."', null, null, '', null)";
	
	
	
	//SEGUIMIENTO-------------------
	/*
	if($i==0){
		var_dump($sql2);die();
	}
	*/
	
	$conn->Execute($sql2);
	
	
	
	
	
}

	//$sql4="update  prog_reloj_he set estado='Aprobado'";
	
	//$conn->Execute($sql4);
	
	
	
	//ENVIO EMAIL
	include_once("class_mailer.php");
	$mail= new mailer();
	
	
	
	
	

         $mail->IsHTML(true);
		 
		 /*Parametros administrador*/
		$sql2="select correo_tiempo_extra from turnos_parametros";
		$rs=$conn->Execute($sql2);
		$fila=$rs->FetchRow();
		
		$mail->AddAddress($fila['correo_tiempo_extra']);		
		
        $mail->Subject = "Autorizacion de Tiempo Extra"; // Este es el titulo del email.
          
         
         $mail->Body = "El Jefe $usuario ha realizado la autorización de tiempo extra para ser cargado en la NOMINA.<br><br>"; // Mensaje a enviar
         $exito = $mail->Send(); // Envía el correo.
		
        	
	//FIN EMAIL
	
	
	echo "1";

}else{
		
		echo "2"; 
	
	
}





?>