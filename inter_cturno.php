<?php
session_start();



require_once "cfg/conexion.php";
require_once "crud/crud.php";


$tn = $_POST['datos'];


$sup= $_POST['sup'];



$info = new crud();


if ($tn != '') {
    $result_tn = $info->update_turno($tn, $sup);
    //echo $sup;
    //echo $tn;
    echo 1;
 } else {
     echo 99;
 }



?>


