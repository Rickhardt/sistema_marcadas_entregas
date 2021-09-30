<style>
  .readOnly {
    background-color: lightgrey
  }
</style>



<?php


session_start();


require_once "cfg/conexion.php";
require_once "crud/crud.php";
$info = new crud();

$result_desc = $info->get_sup_name($_SESSION['user1']);
$result_desc2 = $info->get_sup_rol($_SESSION['user1']);

if ($result_desc[0] != '') {
  $var_desc = $result_desc[0];
  //   echo 1;
} else {
  // echo 99;   
}


if ($result_desc2[0] != '') {
  $var_desc2 = $result_desc2[0];
  //   echo 1;
} else {
  // echo 99;   
}

echo '<input type="hidden" id="var_desc" value="' . $var_desc . '"/>';

echo '<input type="hidden" id="rol" value="' . $var_desc2 . '"/>';

echo '<input type="hidden" id="supi" value="' . $_SESSION['user1'] . '"/>';





?>

<!DOCTYPE html>
<html lang="es-Es">
<style>
  body {
    background-image: url('img/human-resources-employment.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
  }
</style>

<head>
  <title>AVX-CONTROL DE MARCADAS</title>
  <meta meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-escale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="img/logoAVX.ico">

  <script src="jquery/jquery-3.4.1.min.js"></script>
  <script src="jquery/sweetalert2.all.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="shortcut icon" href="img/AVXW.ico">
  <script src="js/Chart.min.js"></script>

</head>


<body>

  <div class="container">

    <form id="FormLog" class="form-signin" method="POST">




      <?php
      //echo  $_SESSION['user1'];
      if (!isset($_SESSION['user1'])) {
        echo "<h1 class='text-center h3 mb-3 font-weight-normal'><label class='mb-1 bg-dark text-white'> NO LOG </label></h1>";

        echo "<script type='text/javascript'> 
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'No esta logeado!'
                    }).then(function() {
                        window.location = 'log_marcadas.php';
                        });
                    </script>";
      } else {
        if ($var_desc2 == 'I' || $var_desc2 == 'R') {
          echo "<nav class='navbar navbar-dark bg-primary'>";
          echo "<h1 class='text-center h3 mb-3 font-weight-normal'><label class='mb-1 text-white' title='BIENVENIDO AL USUARIO!'> HOLA " . $_SESSION['user1'] . " </label>";
          echo "&nbsp <a href='mi_perfil.php'> <img src='img/profile.png' alt='Mi perfil' height='42' width='42' title='Personal a Cargo'></a>";
          echo "&nbsp <a href='reports_marc.php'> <img src='img/chart.png' alt='Reports' height='42' width='42' title='Reports'></a>";
          echo "&nbsp <a href='log_hist.php'> <img src='img/log.png' alt='Log' height='42' width='42' title='Log'></a>";
          echo "&nbsp <img src='img/key.png' alt='cambiar' height='42' width='42' title='Cambiar Contraseña' onclick='cambio_pass()'> ";
            //if ($var_desc2 == 'A') {
          if ($var_desc2 == 'I') {
            echo "&nbsp <img src='img/listm.png' alt='Cambio Planta' height='42' width='42' title='Cambio Planta'>";
          }
          echo "&nbsp <a href='log_marcadas.php'> <img src='img/logout.png' alt='Logout' height='42' width='42' title='Logout'> </a></h1>";
        } else {
          echo "<nav class='navbar navbar-dark bg-primary'>";
          echo "<h1 class='text-center h3 mb-3 font-weight-normal'><label class='mb-1 text-white' title='BIENVENIDO AL USUARIO!'> HOLA " . $_SESSION['user1'] . " </label>";
          echo "&nbsp &nbsp <a href='main_marcadas.php'> <img src='img/searchi.png' alt='Mi perfil' height='42' width='42' title='Consulta...'></a>";
          echo "&nbsp <a href='mi_perfil.php'> <img src='img/profile.png' alt='Mi perfil' height='42' width='42' title='Personal a Cargo'></a>";
          echo "&nbsp <a href='reports_marc.php'> <img src='img/chart.png' alt='Reports' height='42' width='42' title='Reports'></a>";
          echo "&nbsp <a href='log_hist.php'> <img src='img/log.png' alt='Log' height='42' width='42' title='Log'></a>";

          echo "&nbsp <img src='img/key.png' alt='cambiar' height='42' width='42' title='Cambiar Contraseña' onclick='cambio_pass()'> ";
          echo "&nbsp <a href='log_marcadas.php'> <img src='img/logout.png' alt='Logout' height='42' width='42' title='Logout'> </a></h1>";
        }



        // $info2 = new crud();

        // $result_perf = $info2->($var_desc);


        // $info3 = new crud();

        // $result_perf2 = $info3->fill_oper_sup2($var_desc);

        // $turnoactual = $result_perf2[0];


        // echo 'TURNO : (' . $result_perf2[0] . ') TOTAL  : (' . count($result_perf) . ') PERSONAS </nav> ';


        echo '</nav>';


        if ($var_desc2[0] == 'A') {

          $info3 = new crud();

          $result_sups = $info3->get_personal($_SESSION['user1']);

          $tablita = '';



          $tablita .=    "<select name='sup' id='sup' autofocus autocomplete='false' >
          <option value=''></option> ";

          foreach ($result_sups as $row) {


            $tablita .=   "<option value='" . $row['SUPER'] . "'>" . $row['SUPER'] . "</option> ";
          }

          $tablita .=  "</select><br> ";

         // echo '<label class="p-1 mb-2 bg-dark text-white"> FILTRAR &nbsp SUPERVISOR : </label>&nbsp';
          echo $tablita;
        } else if ($var_desc2[0] != 'A') {
          echo "
          <select name='sup' id='sup' autofocus autocomplete='false' hidden>
          <option value=''></option>
             <option value='$var_desc'> $var_desc</option></select><br>";
        }
      }



      ?>

      <br>
      <!--Accordion wrapper-->
      <div class="bg-primary">
        <Label class="text-white"> BADGE : </Label>
        <input type="text" maxlength="5" size="10" id="badge" onchange="buscar_puesto()"><br>
        <Label class="text-white"> EMPLEADO : </Label>
        &nbsp&nbsp&nbsp&nbsp<input type="text" maxlength="40" size="40" id="oper" disabled><br>
        <Label class="text-white"> AREA ACTUAL : </Label>
        <input type="text" maxlength="30" size="30" id="areaact" disabled><br>
        <Label class="text-white"> TURNO : </Label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <input type="text" maxlength="30" size="1" id="tn" disabled><br>
        <br><br>
        <Label class="text-white"> CAMBIAR A : </Label> <br>


        <?php
        $info4 = new crud();

        $result_sups2 = $info4->get_areas();

        $tablita = '';

        $ct = 0;


        $tablita .=    "<select name='narea' id='narea' autofocus autocomplete='false' onchange='cambiar_area(this)'>";

        foreach ($result_sups2 as $row) {


          $tablita .=   "<option value='" . $row['nomarea'] . "' id='" . $ct . "'>" . $row['nomarea'] . "</option> ";
          $ct++;
        }

        $tablita .=  "</select> ";

        echo $tablita;

        $tablita = '';

        $ct = 0;

        $tablita .=    "<select name='narea2' id='narea2' autofocus autocomplete='false' readonly disabled>
        ";

        foreach ($result_sups2 as $row) {


          $tablita .=   "<option value='" . $row['areaempleado'] . "' id='" . $ct . "'>" . $row['areaempleado'] . "</option> ";
          $ct++;
        }

        $tablita .=  "</select><br> ";

        echo $tablita;
        if ($var_desc2[0] == 'I') {
          echo '</br><input class="btn btn-sm btn-success btn-block" type="button" name="cambiar" id="cambiar" class="btn btn-success form-control-file" value="CAMBIAR AREA" onclick="actua_area()"/></br>*ESTE CAMBIO SOLO AFECTA EL SISTEMA, NO AFECTA EL CRONOS</br>TODO CAMBIO ES MONITOREADO EN LA BITACORA DE LOGEOS</br>';
        } else {
          echo '<br><center><b class="bg-danger">ACCESO NO PERMITIDO - debe ser superintendente </b></center>';
        }
        ?>

        <!-- <button type="button" class="btn btn-success" name="EJECUTAR" id="EJECUTAR" onclick="graficar_todo()">EJECUTAR</button> -->


      </div><br>


      <script type='text/javascript'>
        function cambiar_area(x) {
          // var x;
          // console.log(x[x.selectedIndex].id)
          // console.log(x[x.selectedIndex].value)
          // x = document.getElementById('narea').value;
          // document.getElementById('narea2').value = x;
          document.getElementById('narea2').selectedIndex = x[x.selectedIndex].id;



        }

        function buscar_puesto() {
          $.ajax({
            type: "POST",
            url: "inter_borraroper.php",
            data: {
              badge: document.getElementById('badge').value,
              estado: 'BuscarPuesto'
            },
            beforeSend: function() {

            },
            success: function(r) {



              var res = r.split(",");

              document.getElementById('oper').value = res[0];
              document.getElementById('areaact').value = res[1];

              //  if (r == '')
              //  {
              //   document.getElementById('areaact').value = ''
              //  }


              if (document.getElementById('areaact').value == 'undefined') {
                document.getElementById('oper').value = '';
                document.getElementById('areaact').value = '';

              }
            }

          });


          $.ajax({
            type: "POST",
            url: "inter_borraroper.php",
            data: {
              badge: document.getElementById('badge').value,
              estado: 'Buscarturno'
            },
            beforeSend: function() {

            },
            success: function(r) {


              if (document.getElementById('areaact').value == '') {
                document.getElementById('tn').value = '';
              } else {
                document.getElementById('tn').value = r;

              }
            }

          });


        }


        function actua_area() {



          if (document.getElementById('areaact').value == '') {
            swal.fire({
              title: "Error!",
              text: "No hay nada que actualizar",
              showConfirmButton: true,
              icon: "error"
            })

          } else {
            $.ajax({
              type: "POST",
              url: "inter_borraroper.php",
              data: {
                badge: document.getElementById('badge').value,
                nomarea: document.getElementById('narea').value,
                areaempleado: document.getElementById('narea2').value,
                user: document.getElementById('var_desc').value,
                anterior: document.getElementById('areaact').value,
                estado: 'update_over'
              },
              beforeSend: function() {

              },
              success: function(r) {

                swal.fire({
                  title: "Exito!",
                  text: "Se actualizo el dato",
                  showConfirmButton: true,
                  icon: "success"
                })
                document.getElementById('oper').value = '';
                document.getElementById('areaact').value = '';
                document.getElementById('badge').value = '';

              }

            });






          }

        }


        /* CAMBIO PASSWORD */

        function cambio_pass() {
          $('#cambiarpass').modal('show')
          document.getElementById('USUARIO').value = ''
          document.getElementById('pass1').value = ''
          document.getElementById('pass2').value = ''
          document.getElementById('USUARIO').value = document.getElementById('supi').value

        }

        function pass_change() {
          x = document.getElementById('USUARIO').value
          y = document.getElementById('pass1').value
          z = document.getElementById('pass2').value
          console.log(x);
          console.log(y);

          if (y == '' || z == '') {
            swal.fire({
              title: "Error!",
              text: "la contraseña no puede estar vacia",
              showConfirmButton: true,
              icon: "error"
            })
          } else if (y.length <= 8 || z.length <= 8) {
            swal.fire({
              title: "Error!",
              text: "la contraseña debe ser al menos de 8 caracteres o numeros",
              showConfirmButton: true,
              icon: "error"
            })

          } else if (y == z) {
            $.ajax({
              type: "POST",
              url: "inter_borraroper.php",
              data: {
                usuario: x,
                contra: y,
                estado: 'cambiar_contra'
              },
              beforeSend: function() {

              },
              success: function(r) {

                swal.fire({
                  title: "Exito!",
                  text: "Contraseña cambiada",
                  showConfirmButton: true,
                  icon: "success"
                })
                document.getElementById('pass1').value = '';
                document.getElementById('pass2').value = '';


              }

            });



          } else {
            swal.fire({
              title: "Error!",
              text: "las contraseñas no coinciden",
              showConfirmButton: true,
              icon: "error"
            })


          }




        }
      </script>




      <div class="modal fade" id="cambiarpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div id="divmodal">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CAMBIO DE CONTRASEÑA : </h5>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="USUARIO" class="col-form-label">Usuario :</label>
                    <input type="text" class="form-control" id="USUARIO" readonly>
                    <label for="pass1" class="col-form-label">Escriba una nueva contraseña :</label>
                    <input type="password" class="form-control" id="pass1">
                    <label for="pass2" class="col-form-label">Escriba de nuevo la contraseña :</label>
                    <input type="password" class="form-control" id="pass2">
                  </div>

                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarmodal">Cerrar</button>
                  <button type="button" class="btn btn-primary" onclick="pass_change()">Cambiar Password</button>
              </div>
    </form>
  </div>
  </div>
  </div>
  </div>

  </div>