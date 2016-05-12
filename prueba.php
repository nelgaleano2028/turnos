<?php

require_once 'lib/connection.php';

  global $conn, $is_connect;


//$sql="select * FROM prog_mes_tur_ini  WHERE cod_epl='1151938335'";


//$sql="select tabla from conceptos_ayu c, conceptos con where con.cod_con = c.cod_con  and nom_con='LICENCIA REMUNERADA'";


//$sql="select * from prog_mes_tur where cod_epl_jefe='29127151'";

//$sql="select * from prog_mes_tur where cod_epl='67026322' and Mes=9 ";


/*$sql="update PROG_CICLO_TURNO  set cod_ciclo='MAÑANA 1.1' where dias_ciclo='7' and td1='6/3' and td2='6/3' and td3='6/3' and td4='6/3' and td5='6/3' and td6='6/3' and td7='L' and cod_ocup='70040102' and cod_epl='17331515'";*/


/*$sql="select cod_ciclo from PROG_CICLO_TURNO where dias_ciclo='7' and td1='6/3' and td2='6/3' and td3='6/3' and td4='6/3' and td5='6/3' and td6='6/3' and td7='L' and cod_ocup='70040102' and cod_epl='17331515'";*/

//$sql="select * from turnos_prog_TMP where cod_tur='M3' AND cod_cargo ='45453931'";

//$sql="select * from prog_mes_tur where cod_epl='14799046' and mes='9' and Ano='2014'";

/*$sql="select cod_tur, convert(varchar(5),hor_ini,108) as hor_ini,convert(varchar(5),hor_fin,108) as hor_fin,horas from TURNOS_PROG_TMP where cod_tur <> 'VCTO' AND cod_tur <> 'R' AND cod_tur <> 'AT' AND cod_tur <> 'EP' AND cod_tur <> 'IG' AND cod_tur <> 'LM' AND cod_tur <> 'LN' AND cod_tur <> 'LP' AND cod_tur <> 'SP' AND cod_tur <> 'VD' AND cod_tur <> 'N' AND COD_TUR <> 'LR' and cod_cargo='17331515' union select cod_tur, convert(varchar(5),hor_ini,108) as hor_ini,convert(varchar(5),hor_fin,108) as hor_fin,horas from TURNOS_PROG where cod_tur <> 'VCTO' AND cod_tur <> 'R' AND cod_tur <> 'AT' AND cod_tur <> 'EP' AND cod_tur <> 'IG' AND cod_tur <> 'LM' AND cod_tur <> 'LN' AND cod_tur <> 'LP' AND cod_tur <> 'SP' AND cod_tur <> 'VD' AND cod_tur <> 'N' AND COD_TUR <> 'LR' and cod_cargo='17331515' order by hor_ini, hor_fin asc";
*/

/*$sql="select cod_tur, convert(varchar(5),hor_ini,108) as hor_ini,convert(varchar(5),hor_fin,108) as hor_fin,horas from TURNOS_PROG_TMP where cod_tur <> 'VCTO' AND cod_tur <> 'R' AND cod_tur <> 'AT' AND cod_tur <> 'EP' AND cod_tur <> 'IG' AND cod_tur <> 'LM' AND cod_tur <> 'LN' AND cod_tur <> 'LP' AND cod_tur <> 'SP' AND cod_tur <> 'VD' AND cod_tur <> 'V' AND cod_tur <> 'N' AND COD_TUR <> 'LR' and cod_cargo='17331515' union select cod_tur, convert(varchar(5),hor_ini,108) as hor_ini,convert(varchar(5),hor_fin,108) as hor_fin,horas from TURNOS_PROG where cod_tur <> 'VCTO' AND cod_tur <> 'R' AND cod_tur <> 'AT' AND cod_tur <> 'EP' AND cod_tur <> 'IG' AND cod_tur <> 'LM' AND cod_tur <> 'LN' AND cod_tur <> 'LP' AND cod_tur <> 'SP' AND cod_tur <> 'VD' AND cod_tur <> 'V' AND cod_tur <> 'N' AND COD_TUR <> 'LR' and (cod_cargo='AA70030110' or cod_cargo='17331515') order by hor_ini, hor_fin asc";*/

/*
@fecha_inicial='12-19-2014 00:00:00.000'
@fecha_final='12-21-2014 00:00:00.000'


Set @fechaini  = convert(varchar,@fecha_inicial,103)
Set @fechafin  = convert(varchar,@fecha_final,103)
*/



/*$sql="insert into ausencias(cod_con,cod_epl,fec_ini,fec_fin,estado,cnsctvo) 
values(4,3,10-10-14,10-10-14,'P',1)";*/
	
	
	
//$sql="select * from ausencias";	


/*$sql="insert into ausencias(cod_con,cod_epl,fec_ini,fec_fin,estado,cod_cc2,dias,cod_aus,fec_ini_r,fec_fin_r,cnsctvo)
	values(48,'38640858','4-11-2014 00:00:00.000','12-11-2014 00:00:00.000',121),
	'P','70010104',9,4,convert(varchar,'4-11-2014 00:00:00.000',121),convert(varchar,'12-11-2014 00:00:00.000',121),23161)";*/	

/*$sql="insert into ausencias(cod_con,cod_epl,fec_ini,fec_fin,estado,cod_cc2,dias,cod_aus,fec_ini_r,fec_fin_r,cnsctvo)
	values(540,'38640858',convert(varchar,'1-11-2014 00:00:00.000',121),convert(varchar,'09-11-2014 00:00:00.000',121),
	'P','70010104',9,2,convert(varchar,'1-11-2014 00:00:00.000',121),convert(varchar,'09-11-2014 00:00:00.000',121),23162)";*/



//$sql="delete from ausencias where cnsctvo=23162 ";


//$sql="select horas from turnos_prog_tmp where cod_tur='6/2' and cod_cargo='17331515' ";

$sql="select * from  t_admin";
	 






//$sql="select * from turnos_prog_TMP";

/*$sql="update TURNOS_PROG set horas='12', hor_ini=convert(varchar,'1899-01-01 7:00:00.000',121), hor_fin=convert(varchar,'1899-01-01 19:00:00.000',121) where cod_tur='C' AND cod_cargo='AA70030110'";*/






//$sql="select * from colores where cod_epl='67031752' and cod_cc2='70030304' and cargo='300003' and mes='4' and anio='2014'";

//$sql="select * from colores where posicion=16 and cod_epl='67031752'";

//select * from colores where posicion=4 and cod_epl='10545616' and cod_cc2='70030304' and cargo='300003' and mes='4' and anio='2014'

//$sql="select * from t_nuevo_pass where usuario='caracolies@hotmail.com'";

//$sql="update t_nuevo_pass set usuario='caracolies@hotmail.com' where usuario='selfie@hotmail.com'";

//$sql="DELETE FROM colores where mes='4' and anio='2014' and posicion=20 and color <> '#6D87DA' and cod_epl='31582523'";

//$sql="insert into t_nuevo_pass values('12345','selfie@hotmail.com')";


//$sql="delete FROM t_nuevo_pass where usuario='alusaso0118@yahoo.es' and pass='12345'";

/*
$sql1="delete from colores";

$sql2="delete from prog_reloj_he";

$sql3="delete from NOVEDADES_RMTO";

$conn->Execute($sql1);
$conn->Execute($sql2);
$conn->Execute($sql3);
*/

$res=$conn->Execute($sql);


echo "<table border='1'>";

while($reg= $res->FetchRow())
{
	echo "<tr>";
	foreach($reg as $key => $value){ 
		
			echo '<td>'.$value.'</td>';
		
	}
	echo "</tr>";
}

echo "</table>";


 ?>


