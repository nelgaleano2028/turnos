<?php include_once("../librerias/lib/connection.php");

global $conn;

if(@$_POST['contenido']==1){
    
     $sql="select b.cod_car, b.cod_cc2, g.cod_jefe
      from empleados_basic as b, empleados_gral as g 
      where b.cod_epl=g.cod_epl and b.cod_epl='".$_POST['cod_epl']."'";
    
    $rs = $conn->Execute($sql);


    while($fila=$rs->FetchRow()){

        $lista=array("cod_cc2"   => $fila["cod_cc2"],
                     "cod_car"   => $fila["cod_car"],
                     "cod_jefe"  => $fila["cod_jefe"],
                    );
    }
        echo json_encode($lista);  
    
    
}else{
    
    $sql="select b.cod_car, b.cod_cc2, g.cod_jefe,(select Td".$_POST['dia']." from prog_mes_tur where cod_epl='".$_POST['cod_epl']."' and Mes=".$_POST['mes']." and Ano=".$_POST['anio'].") as turno
      from empleados_basic as b, empleados_gral as g 
      where b.cod_epl=g.cod_epl and b.cod_epl='".$_POST['cod_epl']."'";

    $rs = $conn->Execute($sql);


    while($fila=$rs->FetchRow()){
        
        if(@$fila["turno"]==NULL){
            
           json_encode($lista=array('datos'=>1));  break;
        }  

        $lista=array("cod_cc2"   => $fila["cod_cc2"],
                     "cod_car"   => $fila["cod_car"],
                     "cod_jefe"  => $fila["cod_jefe"],
                     "turno"    =>  @$fila["turno"]
                    );
    }
        echo json_encode($lista);  
    
}
?>