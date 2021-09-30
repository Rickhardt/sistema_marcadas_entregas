<?php
session_start();



require_once "cfg/conexion.php";
require_once "crud/crud.php";

$usuario= "RICARDOM";//$_POST['user1'];
$pass = "TEST20"; //$_POST['pass1'];


$info = new crud();

$result_validar = $info->validar_contra($usuario,$pass);


if ((int)$result_validar[0] == 1) {    
     $_SESSION['user1'] = $_POST['user1'];
     $_SESSION['pass1'] = $_POST['pass1'];
         
  echo 1;
} ELSE {
echo 99;   
}
