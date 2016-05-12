<?php
require_once("class_novedades.php");


$obj= new novedades();
if(@$_POST['info']==1){
    
        
       $datos=$obj->verifi_soli_inter($_POST['fecha'],$_POST['cod_epl_cambio'],$_POST['cod_epl_actual'],$_POST['ta'],$_POST['tc'],$_POST['jefe']);
       
       if($datos==2){
           
           echo 2; 
       }else if ($datos==1){
           
           $dato=$obj->aceptar_soli_inter($_POST['id']);
          
           //$dato=1;
           if($dato==1){
               
               //$sql="select email, (select (nom_epl+' '+ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_actual']."') as empleado from empleados_gral where cod_jefe='".$_POST['jefe']."'";
               //var_dump($sql); die();
               
                $sql="select email, (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_actual']."') as empleado_actual, 
                (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_cambio']."') as empleado_cambio,
                (select email from empleados_gral where cod_epl='".$_POST['cod_epl_cambio']."') as email_empleado_cambio,
                (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['jefe']."') as jefe,
                (select email from empleados_gral where cod_epl='".$_POST['jefe']."') as email_jefe   
                from empleados_gral where cod_jefe='".$_POST['jefe']."' and cod_epl='".$_POST['cod_epl_actual']."'";
                
               $rs=$conn->Execute($sql);
               $row=$rs->FetchRow();
               $info=1;
              
                /*auditoria*/
               $fecha=explode("-",$_POST['fecha']);
               
                $sql2="insert into prog_novedades values('".$_POST['cod_epl_actual']."','".$fecha[2]."','".$fecha[1]."','El empleado ".$row['empleado_actual']." solicita un intercambio de turno con el empleado ".$row['empleado_cambio']." el turno ".$_POST['ta']." al ".$_POST['tc']." de la fecha= ".$_POST['fecha']." la solcitud ha sido aprobada  por el jefe ".$row['jefe']."','".$_POST['jefe']."',getdate(),8)";
                $conn->Execute($sql2);
               
              echo $devolver= correo($row['email'],$row['empleado_actual'],$info);
               
           }else if($dato==5){
               
              echo  5;
               
           }

           
       }else{
           
           echo 3;
       }
        

	

}else if(@$_POST['info']==2){

	$datos=$obj->rechazar_soli_inter($_POST['id']);
        
        
        //$datos=1;
        
        if($datos==1){
            
             $sql="select email, (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_actual']."') as empleado_actual, 
                (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_cambio']."') as empleado_cambio,
                (select email from empleados_gral where cod_epl='".$_POST['cod_epl_cambio']."') as email_empleado_cambio,
                (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['jefe']."') as jefe,
                (select email from empleados_gral where cod_epl='".$_POST['jefe']."') as email_jefe   
                from empleados_gral where cod_jefe='".$_POST['jefe']."' and cod_epl='".$_POST['cod_epl_actual']."'";
             
             
               $rs=$conn->Execute($sql);
               $row=$rs->FetchRow();
               $info=2;
               
               /*auditoria*/
                $fecha=explode("-",$_POST['fecha']);
                $sql2="insert into prog_novedades values('".$_POST['cod_epl_actual']."','".$fecha[2]."','".$fecha[1]."','El empleado ".$row['empleado_actual']." solicita un intercambio de turno con el empleado ".$row['empleado_cambio']." el turno ".$_POST['turno_actual']." al ".$_POST['turno_cambiar']." de la fecha= ".$_POST['fecha']." se rechaza la solicitud por el jefe ".$row['jefe']."','".$_POST['jefe']."',getdate(),8)";
                $conn->Execute($sql2);
                echo enviar_correo_inter($row['email'],$row['empleado_actual'],$row['email_empleado_cambio'],$row['empleado_cambio'],$row['email_jefe'],$row['jefe'],$_POST['turno_actual'],$_POST['turno_cambiar'],$info);
 
        }else{
            
            echo 2;
        }


}else if(@$_POST['info']==3){
    
            $datos=$obj->verifi_soli_aus($_POST['cod_epl'],$_POST['fecha_ini'],$_POST['fecha_fin'],$_POST['cod_cc2'],$_POST['cod_con']);
           
            
            if($datos==1){
                
                 $dato=$obj->aceptar_soli_aus($_POST['id']);
                 
                 if($dato==1){
                     
                          $sql="select email, (select RTRIM(nom_epl)+' '+RTRIM(ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['cod_epl']."') as empleado,
                                (select RTRIM(nom_epl)+' '+RTRIM(ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['jefe']."') as jefe from empleados_gral where cod_jefe='".$_POST['jefe']."' and cod_epl='".$_POST['cod_epl']."'";
                           $rs=$conn->Execute($sql);
                           $row=$rs->FetchRow();
                           $info=1;

                           ($_POST['cod_con']=='540')? $ausencia='Licencia no remunerada':$ausencia='vacaciones';

                           /*auditoria*/
                            $fecha=explode("-",$_POST['fecha_ini']);
                            $sql2="insert into prog_novedades values('".$_POST['cod_epl']."','".$fecha[2]."','".$fecha[1]."','Se acepta la solocitud de ".$ausencia."  del El empleado ".$row['empleado']." por el jefe ".$row['jefe']."','".$_POST['jefe']."',getdate(),6)";
                            $conn->Execute($sql2);


                            echo $devolver= correo($row['email'],$row['empleado'],$info);
                     
                     
                 }else{
                     
                     echo 3;
                 }
                 
                  
                 
            }else if ($datos==2){
                
                echo 2;
            }

	   

}else if(@$_POST['info']==4){

        $datos=$obj->rechazar_soli_aus($_POST['id']);
        
        if($datos==1){
             
                $sql="select email, (select RTRIM(nom_epl)+' '+RTRIM(ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['cod_epl']."') as empleado,
                    (select RTRIM(nom_epl)+' '+RTRIM(ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['jefe']."') as jefe from empleados_gral where cod_jefe='".$_POST['jefe']."' and cod_epl='".$_POST['cod_epl']."'";
               $rs=$conn->Execute($sql);
               $row=$rs->FetchRow();
               
               $info=2;
               
               ($_POST['cod_con']=='540')? $ausencia='Licencia no remunerada':$ausencia='vacaciones';

                /*auditoria*/
                 $fecha=explode("-",$_POST['fecha_ini']);
                 $sql2="insert into prog_novedades values('".$_POST['cod_epl']."','".$fecha[2]."','".$fecha[1]."','Se rechaza la solocitud de ".$ausencia."  El empleado ".$row['empleado']." por el jefe ".$row['jefe']."','".$_POST['jefe']."',getdate(),6)";
                 $conn->Execute($sql2);
            
             echo $devolver= correo($row['email'],$row['empleado'],$info);
            
        }else{
            
            echo 2;
        }

}else if(@$_POST['info']==5){
    
    
    $datos=$obj->verifi_soli_turno($_POST['fecha_solicitud'],$_POST['cod_epl'],$_POST['turno_solicitud'],$_POST['jefe']);
      
     //$datos=1;
     
       if($datos==2){
           
           echo 2; 
       }else if ($datos==1){
           
           $dato=$obj->aceptar_soli_turnos($_POST['id']);
          
          // $dato=1;
           if($dato==1){
               
               $sql="select email, (select RTRIM(nom_epl)+' '+RTRIM(ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['cod_epl']."') as empleado,
                    (select RTRIM(nom_epl)+' '+RTRIM(ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['jefe']."') as jefe from empleados_gral where cod_jefe='".$_POST['jefe']."' and cod_epl='".$_POST['cod_epl']."'";
               $rs=$conn->Execute($sql);
               $row=$rs->FetchRow();
               $info=1;
               
               
               /*auditoria*/
                $fecha=explode("-",$_POST['fecha_solicitud']);
                $sql2="insert into prog_novedades values('".$_POST['cod_epl']."','".$fecha[2]."','".$fecha[1]."','El empleado ".$row['empleado']." solicita un cambio de turno  de la fecha= ".$_POST['fecha_solicitud']." se acepta la solicitud por el jefe ".$row['jefe']."','".$_POST['jefe']."',getdate(),8)";
                $conn->Execute($sql2);
                
              echo $devolver= correo($row['email'],$row['empleado'],$info);
               
           }else if($dato==5){
               
              echo  5;
               
           }
       }
    
    
    
}else if(@$_POST['info']==6){
    
    $datos=$obj->rechazar_soli_turno($_POST['id']);
    
    //$datos=1;
        
        if($datos==1){
             
               $sql="select email, (select RTRIM(nom_epl)+' '+RTRIM(ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['cod_epl']."') as empleado,
                    (select RTRIM(nom_epl)+' '+RTRIM(ape_epl)as empleado from empleados_basic where cod_epl='".$_POST['jefe']."') as jefe from empleados_gral where cod_jefe='".$_POST['jefe']."' and cod_epl='".$_POST['cod_epl']."'";
               $rs=$conn->Execute($sql);
               $row=$rs->FetchRow();
               $info=2;
               
               /*auditoria*/
                $fecha=explode("-",$_POST['fecha_solicitud']);
                $sql2="insert into prog_novedades values('".$_POST['cod_epl']."','".$fecha[2]."','".$fecha[1]."','El empleado ".$row['empleado']."  la solicitud de  un cambio de turno  de la fecha= ".$_POST['fecha_solicitud'].". ha sido rechazada por el jefe ".$row['jefe']."','".$_POST['jefe']."',getdate(),8)";
                $conn->Execute($sql2);
            
             echo $devolver= correo($row['email'],$row['empleado'],$info);
            
        }else{
            
            echo 2;
        }
    
}else if(@$_POST['info']==7){
    
    $datos=$obj->aceptar_soli_inter_emp($_POST['id']);
    
    //$datos=1;
       
        if($datos==1){
             
             
             $sql="select email, (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_actual']."') as empleado_actual, 
                (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_cambio']."') as empleado_cambio,
                (select email from empleados_gral where cod_epl='".$_POST['cod_epl_cambio']."') as email_empleado_cambio,
                (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['jefe']."') as jefe,
                (select email from empleados_gral where cod_epl='".$_POST['jefe']."') as email_jefe   
                from empleados_gral where cod_jefe='".$_POST['jefe']."' and cod_epl='".$_POST['cod_epl_actual']."'";

               $rs=$conn->Execute($sql);
               $row=$rs->FetchRow();
               $info=1;
               
                 $fecha=explode("-",$_POST['fecha']);
                 
                  /*auditoria*/
                $sql2="insert into prog_novedades values('".$_POST['cod_epl_actual']."','".$fecha[2]."','".$fecha[1]."','El empleado ".$row['empleado_actual']." solicita un intercambio de turno con el empleado ".$row['empleado_cambio']." el turno ".$_POST['turno_actual']." al ".$_POST['turno_cambiar']." de la fecha= ".$_POST['fecha']." se acepta la solicitud por el empleado ".$row['empleado_cambio']."','".$_POST['jefe']."',getdate(),8)";
                $conn->Execute($sql2);
               
                echo enviar_correo_inter($row['email'],$row['empleado_actual'],$row['email_empleado_cambio'],$row['empleado_cambio'],$row['email_jefe'],$row['jefe'],$_POST['turno_actual'],$_POST['turno_cambiar'],$info);
 
        }else{
            
            echo 2;
        }
    
}else if(@$_POST['info']==8){
    
    $datos=$obj->rechazar_soli_inter_emp($_POST['id']);
       
        if($datos==1){
             
             
             $sql="select email, (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_actual']."') as empleado_actual, 
                (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['cod_epl_cambio']."') as empleado_cambio,
                (select email from empleados_gral where cod_epl='".$_POST['cod_epl_cambio']."') as email_empleado_cambio,
                (select RTRIM(nom_epl)+' '+RTRIM(ape_epl) as empleado from empleados_basic where cod_epl='".$_POST['jefe']."') as jefe,
                (select email from empleados_gral where cod_epl='".$_POST['jefe']."') as email_jefe   
                from empleados_gral where cod_jefe='".$_POST['jefe']."' and cod_epl='".$_POST['cod_epl_actual']."'";

               $rs=$conn->Execute($sql);
               $row=$rs->FetchRow();
               $info=3;
               
               $fecha=explode("-",$_POST['fecha']);
               
                /*auditoria*/
               $sql2="insert into prog_novedades values('".$_POST['cod_epl_actual']."','".$fecha[2]."','".$fecha[1]."','El empleado ".$row['empleado_actual']." solicita un intercambio de turno con el empleado ".$row['empleado_cambio']." el turno ".$_POST['turno_actual']." al ".$_POST['turno_cambiar']." de la fecha= ".$_POST['fecha']." la solcitud ha sido rechazada por el empleado ".$row['empleado_cambio']."','".$_POST['jefe']."',getdate(),8)";
               
               $conn->Execute($sql2);
                
                echo enviar_correo_inter($row['email'],$row['empleado_actual'],$row['email_empleado_cambio'],$row['empleado_cambio'],$row['email_jefe'],$row['jefe'],$_POST['turno_actual'],$_POST['turno_cambiar'],$info);
 
        }else{
            
            echo 2;
        }
    
}

function correo($email,$empleado,$info){
	
	//echo $email; die();
    
	
	global $conn;
    
   
    $email='rober.ospina@talentsw.com';
	
	include_once("class_mailer.php");
	
    $mail= new mailer();
	

    $mail->addAddress($email);      
	

     $mail->IsHTML(true);

     if($info==1){

           $mail->Subject = "Solicitud de cambio aceptada"; // Este es el titulo del email.

          $mail->Body = "Solicitud de cambio aceptada del empleado ".$empleado."";

     }else{

          $mail->Subject = "Solicitud de cambio ha sido rechazada"; // Este es el titulo del email.
          $mail->Body = "Solicitud de cambio ha sido rechazada del empleado ".$empleado."";
     }
     // Mensaje a enviar
     $exito = $mail->Send(); // Envía el correo.
	 
	 

    if($exito){
           return 1;
    }else{
            return 4;
    }
}

function enviar_correo_inter($email,$empleado_actual,$email_empleado_cambio,$empleado_cambio,$email_jefe,$jefe,$turno_actual,$turno_cambio,$info){
     
     $email='rober.ospina@talentsw.com';
     $email_empleado_cambio='steven.morales@talentsw.com';
	 $email_jefe="quake2400@gmail.com";
	 
	
     
    include_once("class_mailer.php");
	 
    $mail= new mailer();
    //$destinatario='rober.ospina@talentsw.com';  //$row['email'];


     $mail->IsHTML(true);
    
       //-----FIN EMAIL-----
     $mail->addAddress($email); 
     $mail->addAddress($email_empleado_cambio);
     $mail->addAddress($email_jefe);
      $mail->Subject = "Solcitud de  cambio de Turnos"; // Este es el titulo del email
     
     if($info==2){
         
         $mail->Body = "Se ha rechazado la solicitud de un cambio de turno del empleado ".$empleado_actual."  el turno actual ".$turno_actual." al turno ".$turno_cambio.""; // Mensaje envia jefe
         
     }else if($info==1){
 
          $mail->Body = "La solicitud de un cambio de turno del empleado ".$empleado_actual."  el turno actual ".$turno_actual." al turno ".$turno_cambio." ha sido confirmada por el empleado ".$empleado_cambio." "; // Mensaje envia colaborador 
   
     }else if ($info==3){
         
         $mail->Body = "La solicitud de un cambio de turno del empleado ".$empleado_actual."  el turno actual ".$turno_actual." al turno ".$turno_cambio." ha sido rechazada por el empleado ".$empleado_cambio." ";
         
     }
     
     $exito = $mail->Send(); 

    if($exito){
            return  1;
    }else{
            return 3;
    }
     
 }
?>