<?php
require_once "cfg/conexion.php";
require_once "crud/crud2.php";

$estado = $_POST['estado'];
$info = new crud2();

if ($estado == 'logearse') {
  $usuario = $_POST['username'];
  $pass = $_POST['password'];
  $exito = '';

  $result_validar = $info->validar_contra($usuario, $pass);
  if ($result_validar[0] == 1) {
    $exito = 1;
  } else {
    $exito = 99;
  }
  echo $exito;
}

if ($estado == 'buscar') {
  $badge = $_POST['badge'];
  $result_validar = $info->buscar($badge);
  if ($result_validar[0] != 0) {
    echo 1;
  } else {
    echo 0;
  }
}

if ($estado == 'actualizar') {
  $badge = $_POST['badge'];
  $user = $_POST['user'];
  $notag = $_POST['notag'];
  // if(isset($_POST['correlativo'])) $correlativo = $_POST['correlativo'];
  // else $correlativo = null;

  //Esto para la entrega de chompipollos, esto no lleva correlativo.
  $result_validar = $info->actualizar($badge, $user, $notag);
  echo $result_validar;

  //Snippet agregado para verificar si la persona tiene o no carné de uso de transporte empresarial. Se debe deshabilitar para la entrega de chompipollos
  // $result_validar = $info->VerificacionTransporte($badge);
  
  // if($result_validar == 1) echo $result_validar;
  // else $result_validar = $info->actualizar($badge, $user, $notag, $correlativo);

}

if ($estado == 'ingreso_correlativo') {
  $badge = $_POST['badge'];
  $user = $_POST['user'];
  $notag = $_POST['notag'];
  $correlativo = $_POST['correlativo'];

  //Verificar que no se haya utilizado ese mismo correlativo
  $result_validar = $info->ComprobarCorrelativo($correlativo);
  if($result_validar == 1) echo $result_validar;
  else {
        $result_validar = $info->actualizar($badge, $user, $notag, $correlativo);
        echo "";
       }

}

if ($estado == 'entregado') {
  $badge = $_POST['badge'];
  $result_validar = $info->entregado($badge);
  if ($result_validar[0] > 0) {
    echo 1;
  } else {
    echo 0;
  }
}

if ($estado == 'nombre') {
  $badge = $_POST['badge'];
  $result_A = $info->nombre($badge);
  foreach ($result_A as $row) {
    $areaactual = $row['NOMBRE'];
  }
  echo $areaactual;
}


if ($estado == 'data_graf') {

  $result_A = $info->data_graf();


  $resultado_log = [];



  foreach ($result_A as $row) {
    $pendiente =  $row['PENDIENTE'];
    $entregado =  $row['ENTREGADO'];
    $pen_entreg =  $row['PENENTREG'];
  }


  $resultado_log[0] = $pendiente;
  $resultado_log[1] = $entregado;
  $resultado_log[2] = $pen_entreg;

  echo json_encode($resultado_log);
}

if ($estado == 'graf_quiebre') {
  $tablita = '';
  $areadt = $_POST['areadt'];


  $result_perf = $info->graf_quiebre($areadt);


  $tablita .=  "<table id='table2' class='table table-striped table-dark table-bordered table-hover table-sm'>
  <tr class='bg-primary'>
 <th scope='col'>AREA</th>
 <th scope='col'>TURNO</th>
 <th scope='col' style='background-color:salmon'>PENDIENTE</th>
 <th scope='col' style='background-color:lightgreen'>ENTREGADO</th>
     </tr> ";

  foreach ($result_perf as $row) {
    $tablita .= "<tr>";
    $tablita .= "<td>" . $row['AREA'] . "</td>";
    $tablita .= "<td>" . $row['TURNO'] . "</td>";
    $tablita .= "<td>" . $row['PENDIENTE'] . "</td>";
    $tablita .= "<td >" . $row['ENTREGADO'] . "</td>";
    $tablita .= "</tr>";
  }

  $tablita .= "</table>";



  echo  $tablita;
}

if ($estado == 'graf_quiebre_area') {
  $tablita = '';
  $areadt = $_POST['areadt'];


  $result_perf = $info->graf_quiebre_area($areadt);


  $tablita .=  "<table id='table3' class='table table-striped table-dark table-bordered table-hover table-sm'>
  <tr class='bg-primary'>
 <th scope='col'>AREA</th>
 <th scope='col' style='background-color:salmon'>PENDIENTE</th>
 <th scope='col' style='background-color:lightgreen'>ENTREGADO</th>
     </tr> ";

  foreach ($result_perf as $row) {
    $tablita .= "<tr>";
    $tablita .= "<td>" . $row['AREA'] . "</td>";
    $tablita .= "<td>" . $row['PENDIENTE'] . "</td>";
    $tablita .= "<td>" . $row['ENTREGADO'] . "</td>";
    $tablita .= "</tr>";
  }

  $tablita .= "</table>";



  echo  $tablita;
}


if ($estado == 'graf_quiebre_turno') {
  $tablita = '';
  $areadt = $_POST['areadt'];


  $result_perf = $info->graf_quiebre_turno($areadt);


  $tablita .=  "<table id='table4' class='table table-striped table-dark table-bordered table-hover table-sm'>
  <tr class='bg-primary'>
 <th scope='col'>TURNO</th>
 <th scope='col' style='background-color:salmon'>PENDIENTE</th>
 <th scope='col' style='background-color:lightgreen'>ENTREGADO</th>
     </tr> ";

  foreach ($result_perf as $row) {
    $tablita .= "<tr>";
    $tablita .= "<td>" . $row['TURNO'] . "</td>";
    $tablita .= "<td>" . $row['PENDIENTE'] . "</td>";
    $tablita .= "<td>" . $row['ENTREGADO'] . "</td>";
    $tablita .= "</tr>";
  }

  $tablita .= "</table>";



  echo  $tablita;
}


if ($estado == 'verificar2') {
  $tablita = '';
  $badge = $_POST['badge'];

  $result_perf = $info->verificar($badge);


  foreach ($result_perf as $row) {

    if ($row['ESTADO'] == 'PENDIENTE') {
      $estilo =  "style='color:red'";
    } else {
      $estilo =  "style='color:green'";
    }

    $tablita .= "<b>BADGE : </b>" . $row['BADGE'] . "<br><b>NOMBRE : </b>" . $row['NOMBRE'] .  "<br><b>AREA : </b> " . $row['NOMAREA'] .  "<br><b>FECHA ENTREGA : </b> " . $row['FECHAHORA'] .  "<br><b>ESTADO : </b><b " . $estilo ." > " . $row['ESTADO'] .  "</b><br><b>ENTREGADO POR : </b> " . $row['ENTREGO'] .  "<br><b>NOTA : </b><b  style='color:blue'><br>" . $row['NOTA'] . " </b><br><img src='https://sistemas.avxslv.com/marcadas/ids/" . $row['BADGE'] . ".jpg' width='100px' height='100px'>";
  }


  echo $tablita;
}

if ($estado == 'update_oper') {
  $tablita = '';
  $badge = $_POST['badge'];


  $result_perf = $info->update_oper($badge);

  echo 1;



}

if ($estado == 'update_operN') {
  $tablita = '';
  $badge = $_POST['badge'];
  $nota= $_POST['nota'];


  $result_perf = $info->update_operN($badge,$nota);

  echo 1;



}
