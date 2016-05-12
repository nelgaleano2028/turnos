<?php
require_once("class_empleado.php");

$obj= new empleado($_POST['cod_epl_actual']);

if($_POST['info']==1){
    
    
    $obj= new empleado($_POST['cod_epl_actual']);
    
    $datos=$obj->add_inter_turnos($_POST['cod_epl_actual'],$_POST['cod_epl_cambio'],$_POST['turno_actual'],$_POST['turno_cambio'],$_POST['fecha_ini'],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['cod_jefe']);

    
    //$datos=1;
    
    if($datos==1){

        /*$sql="select email, (select (nom_epl+' '+ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_actual']."') as empleado 
            from empleados_gral where cod_jefe='".$_POST['cod_jefe']."'";*/
        
      $sql="select email, (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) from empleados_basic where cod_epl='".$_POST['cod_epl_actual']."') as empleado_actual, 
            (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) from empleados_basic where cod_epl='".$_POST['cod_epl_cambio']."') as empleado_cambio,
            (select email from empleados_gral where cod_epl='".$_POST['cod_epl_cambio']."') as email_empleado_cambio,
            (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) from empleados_basic where cod_epl='".$_POST['cod_jefe']."') as jefe,
            (select email from empleados_gral where cod_epl='".$_POST['cod_jefe']."') as email_jefe   
            from empleados_gral where cod_jefe='".$_POST['cod_jefe']."' and cod_epl='".$_POST['cod_epl_actual']."'";
        
        //var_dump($sql); die();
        $rs=$conn->Execute($sql);
        $row=$rs->FetchRow();
        
        $fecha=explode("-",$_POST['fecha_ini']);
                            
        $sql2="insert into prog_novedades values('".$_POST['cod_epl_actual']."','".$fecha[2]."','".$fecha[1]."','El empleado ".$row['empleado_actual']." solicita un intercambio de turno con el empleado ".$row['empleado_cambio']." el turno ".$_POST['turno_actual']." al ".$_POST['turno_cambio']." de la fecha= ".$_POST['fecha_ini']."','".$_POST['cod_jefe']."',getdate(),7 )";
        $conn->Execute($sql2);
        
        $dato=enviar_correo_inter($row['email'],$row['empleado_actual'],$row['email_empleado_cambio'],$row['empleado_cambio'],$row['email_jefe'],$row['jefe'],$_POST['turno_actual'],$_POST['turno_cambio']);
        
        if($dato==1){
            echo 1;
            
        }else{
            echo 3;
        }

    }else{

        echo 2;
    }
       
}else if($_POST['info']==2){
   
    
     $datos=$obj->add_solicitud_turnos($_POST['cod_epl_actual'],$_POST['turno_solicitud'],$_POST['fecha_solicitud'],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['cod_jefe']);
     
    //$datos=1;
     if($datos==1){

        $sql="select email, (select (RTRIM(nom_epl)+' '+RTRIM(ape_epl)) as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_actual']."') as empleado from empleados_gral where cod_jefe='".$_POST['cod_jefe']."'";
        $rs=$conn->Execute($sql);
        $row=$rs->FetchRow();
        
        $fecha=explode("-",$_POST['fecha_solicitud']);
        $sql2="insert into prog_novedades values('".$_POST['cod_epl_actual']."','".$fecha[2]."','".$fecha[1]."','El empleado ".$row['empleado']." solicita  el turno ".$_POST['turno_solicitud']."  de la fecha= ".$_POST['fecha_solicitud']."','".$_POST['cod_jefe']."',getdate(),7)";
        $conn->Execute($sql2);
        
        $dato=enviar_correo($row['email'],$row['empleado']);
        
        if($dato==1){
            echo 1;
            
        }else{
            echo 3;
        }

    }else{

        echo 2;
    }
}

 function enviar_correo($email,$empleado){
     
    include_once("class_mailer.php");
	 
    $mail= new mailer();
    $destinatario='rober.ospina@talentsw.com';  //$row['email'];


     $mail->IsHTML(true);
     $mail->Subject = "Solcitud de  cambio de Turnos"; // Este es el titulo del email.
       //-----FIN EMAIL-----
	   	
     $mail->addAddress($destinatario); 
	 

     $mail->Body = "Se ha solcitado un cambio de turno del empleado ".$empleado.""; // Mensaje a enviar
     $exito = $mail->Send(); // Envía el correo.

    if($exito){
            return  1;
    }else{
            return 3;
    }
     
 }
 
 function enviar_correo_inter($email,$empleado_actual,$email_empleado_cambio,$empleado_cambio,$email_jefe,$jefe,$turno_actual,$turno_cambio){
     

     $email='rober.ospina@talentsw.com';
     $email_empleado_cambio='steven.morales@talentsw.com';
     $email_jefe='quake2600@hotmail.com';
     $jefe=""; //viene como paramaetro
     
      include_once("class_mailer.php");
    $mail= new mailer();
    //$destinatario='rober.ospina@talentsw.com';  //$row['email'];


     $mail->IsHTML(true);
     $mail->Subject = "Solcitud de  cambio de Turnos"; // Este es el titulo del email.
       //-----FIN EMAIL-----
     $mail->addAddress($email); 
     $mail->addAddress($email_empleado_cambio);
     $mail->addAddress($email_jefe);
     

     $mail->Body = "Se ha solcitado un cambio de turno del empleado ".$empleado_actual."  del turno actual ".$turno_actual." al turno ".$turno_cambio." pendiente por confirmar por empleado".$empleado_cambio.""; // Mensaje a enviar
     $exito = $mail->Send(); 

    if($exito){
            return  1;
    }else{
            return 3;
    }
     
 }

?>