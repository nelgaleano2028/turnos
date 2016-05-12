<?php include_once("../librerias/lib/connection.php");

//Recibe los valores de ingreso de login.js
date_default_timezone_set("America/Bogota");	
$usuario = $_POST["usuario"];
$pass = $_POST["clave"];


/*Si el usuario esta creado en la base de datos pero no tiene ni usuario ni contraseña en t_nuevo_pass*/


$sql="select email from empleados_gral where email='".$_POST["usuario"]."'";
//var_dump($sql); die();
$rs = $conn->Execute($sql);
$row = $rs->fetchrow();



if($rs->RecordCount() > 0){
	
	$sql2="select * from t_nuevo_pass where USUARIO='".$row['email']."' and PASS='".$pass."'";
	//var_dump($sql2); die();
	$rs2 = $conn->Execute($sql2);
	$row = $rs2->fetchrow();
	
	if($rs2->RecordCount() == 0){
		
		$bandera=7;
	
	}

}



//Selecciona el usuario y el password de t_nuevo_pass
$query = "SELECT C.COD_EPL, C.NOM_EPL, C.APE_EPL, C.CEDULA, B.EMAIL, A.PASS, A.USUARIO
		FROM EMPLEADOS_BASIC C, T_NUEVO_PASS A, EMPLEADOS_GRAL B 
		WHERE C.COD_EPL = B.COD_EPL AND A.USUARIO = B.EMAIL AND A.USUARIO = '$usuario'";

		
		$rs = $conn->Execute($query);
		$row3 = $rs->fetchrow();
        $correopass = $row3['USUARIO'];
		$contrasenapass = $row3['PASS'];
	

	
//Usuario y Contraseña por defecto de la tabla acc_usuarios ingresando por primera vez al aplicativo (TURNOSJEFE - TURNOSHE - ADMINTURNOS) 		
$query1 = "select top(1) usuario, cod_epl, cod_gru_prg from acc_usuarios where usuario = '$usuario' and cod_gru_prg in('TURNOS','TURNOSJEFE','TURNOSHE','GHUMANA') order  by cod_gru_prg desc";

//var_dump($query1); die();		
		$rs1 = $conn->Execute($query1);
		$row1 = $rs1->fetchrow();
        $correopass1 = $row1['usuario']; //Usuario
		$contrasenapass1 = $row1['cod_epl']; //Contraseña
		$privi = $row1['cod_gru_prg']; //Privilegio segun(RHERRERA - TURNOSHE - ADMINTURNOS)
		
		//ECHO $privi; die();
		

//Usuario y Contraseña de la tabla t_admin para RHERRERA - TURNOSHE - ADMINTURNOS con su contraseña cambiada		
$query2 = "select nom_admin, contrasena, privilegio, cod_epl from t_admin where nom_admin = '$usuario'";
		
		$rs2 = $conn->Execute($query2);
		$row2 = $rs2->fetchrow();
        $correopass2 = $row2['nom_admin']; //Usuario
		$contrasenapass2 = $row2['contrasena']; //Contraseña
		$privi = $row2['privilegio']; //Privilegio segun(RHERRERA - TURNOSHE - ADMINTURNOS)
		$cod_epl = $row2['cod_epl']; //codigo segun(RHERRERA - TURNOSHE - ADMINTURNOS)
		
		
		//VAR_DUMP($privi);die();
		

if ($correopass == $usuario && $contrasenapass == $pass ) { //Validacion empleado a su Main  con la nueva contraseña cambiada en el aplicativo

		
		session_start();
		
                $_SESSION['cod'] = $row3['COD_EPL'];
                $_SESSION['cor'] = $row3['EMAIL'];
                $_SESSION['ced'] = $row3['CEDULA'];
                $_SESSION['nom'] = $row3['NOM_EPL'];
		$_SESSION['ape'] = $row3['APE_EPL'];
		$_SESSION['privi']= "EMPLEADO";
		$_SESSION['time']=date('Y-n-j H:i:s');
		
		
		echo 1;
}

elseif ($correopass1 == $usuario && $contrasenapass1 == $pass && empty($contrasenapass2)) { //Validacion PERFILES a su respectivo Main si no ha cambiado su password por primera vez

		
		session_start();
		
		$_SESSION['usuario'] = $row1['usuario'];
        $_SESSION['cod_epl'] = $row1['cod_epl'];
        $_SESSION['privi'] = $row1['cod_gru_prg'];
		$_SESSION['nom'] = $row1['usuario'];
		$_SESSION['time'] = date('Y-n-j H:i:s');
		
		echo 2;		
}

elseif ($correopass2 == $usuario && $contrasenapass2 == $pass && $privi=='TURNOSJEFE') { // Validacion de RHERRERA
		
		session_start();
        
		$_SESSION['nom'] = $row2['nom_admin'];
		$_SESSION['pas'] = $row2['contrasena'];
     	$_SESSION['privi'] = $row2['privilegio'];
		$_SESSION['cod_epl'] = $row2['cod_epl'];
		$_SESSION['usuario'] = $row2['nom_admin'];
		$_SESSION['time'] = date('Y-n-j H:i:s');
		echo 3;		
}elseif ($correopass2 == $usuario && $contrasenapass2 == $pass && $privi=='TURNOSHE') {  //Validacion de TURNOSHE
		
		session_start();
        
		$_SESSION['nom'] = $row2['nom_admin'];
		$_SESSION['pas'] = $row2['contrasena'];      
		$_SESSION['privi'] = $row2['privilegio'];
		$_SESSION['cod_epl'] = $row2['cod_epl'];
		$_SESSION['usuario'] = $row2['nom_admin'];
		$_SESSION['time'] = date('Y-n-j H:i:s');
		echo 4;
}

elseif ($correopass2 == $usuario && $contrasenapass2 == $pass && $privi=='TURNOS') { // Validacion de ADMINTURNOS 
		
		session_start();
        
		$_SESSION['nom'] = $row2['nom_admin'];
		$_SESSION['pas'] = $row2['contrasena'];
       	$_SESSION['privi'] = $row2['privilegio'];
		$_SESSION['cod_epl'] = $row2['cod_epl'];
		$_SESSION['usuario'] = $row2['nom_admin'];
		$_SESSION['time'] = date('Y-n-j H:i:s');
		echo 5;
}

elseif ($correopass2 == $usuario && $contrasenapass2 == $pass && $privi=='GHUMANA') { // Validacion de GHUMANA 
		
		session_start();
        
		$_SESSION['nom'] = $row2['nom_admin'];
		$_SESSION['pas'] = $row2['contrasena'];
       	$_SESSION['privi'] = $row2['privilegio'];
		$_SESSION['cod_epl'] = $row2['cod_epl'];
		$_SESSION['usuario'] = $row2['nom_admin'];
		$_SESSION['time'] = date('Y-n-j H:i:s');
		echo 6;

}else if($bandera==7){
	
	echo 7;
	
}else{

	echo "El usuario no existe en el momento";
}





$conn->Close();
?>
	
	
