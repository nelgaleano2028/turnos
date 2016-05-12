<?php

require_once 'lib/connection.php';

  global $conn, $is_connect;


			


$sql1 = "delete from prog_reloj_he";
$conn->Execute($sql);

$sql2 = "delete from colores";
$conn->Execute($sql2);

$sql3 = "delete from NOVEDADES_RMTO";
$conn->Execute($sql3);



 ?>


