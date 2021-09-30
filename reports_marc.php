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
        /* background-image: url('img/human-resources-employment.jpg'); */
        background-image: url('img/bgny.jpg');
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
<!-- <marquee width="100%" behavior="scroll" bgcolor="pink">  
SE EXPERIMENTA UN PROBLEMA CON LAS MARCADAS DEL 10 FEB EN ADELANTE, SE LES MANTENDRA INFORMADOS...PUEDEN INGRESAR LAS DEMAS
</marquee>   -->
  <div class="container">
  <div class="card" style="background: rgba(0,0,0,0.3);">
  <div class="card-body">
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
        if ($var_desc2 == 'I' || $var_desc2 == 'R' || $var_desc2 == 'Y' || $var_desc2 == 'X') {
          echo "<nav class='navbar navbar-dark bg-primary'>";
          echo "<h1 class='text-center h3 mb-3 font-weight-normal'><label class='mb-1 text-white' title='BIENVENIDO AL USUARIO!'> HOLA " . $_SESSION['user1'] . " </label>";
          
          echo "&nbsp <a href='mi_perfil.php'> <img src='img/profile.png' alt='Mi perfil' height='42' width='42' title='Personal a Cargo'></a>";
          
          echo "&nbsp <img src='img/chart.png' alt='Reports' height='42' width='42' title='Reports'>";
          echo "&nbsp <a href='log_hist.php'> <img src='img/log.png' alt='Log' height='42' width='42' title='Log'></a>";
          echo "&nbsp <img src='img/key.png' alt='cambiar' height='42' width='42' title='Cambiar Contraseña' onclick='cambio_pass()'> ";
          //if ($var_desc2 == 'A') {
          if ($var_desc2 == 'I') {
            echo "&nbsp <a href='cambio_planta.php'> <img src='img/listm.png' alt='Cambio Planta' height='42' width='42' title='Cambio Planta'></a>";
          }
          echo "&nbsp <a href='log_marcadas.php'> <img src='img/logout.png' alt='Logout' height='42' width='42' title='Logout'> </a></h1>";
        } else {
          echo "<nav class='navbar navbar-dark bg-primary'>";
          echo "<h1 class='text-center h3 mb-3 font-weight-normal'><label class='mb-1 text-white' id='descsup' name='descsup'> " . $var_desc . " </label>";
          
          echo "&nbsp &nbsp <a href='main_marcadas.php'> <img src='img/searchi.png' alt='Mi perfil' height='42' width='42' title='Consulta...'></a>";

          echo "&nbsp <a href='mi_perfil.php'> <img src='img/profile.png' alt='Mi perfil' height='42' width='42' title='Personal a Cargo'></a>";
          // echo "&nbsp <a href='listmanto.php'> <img src='img/gear.png' alt='Mi perfil' height='30' width='30' title='Modificar mi personal'></a>";
          echo "&nbsp <img src='img/chart.png' alt='Reports' height='42' width='42' title='Reports'>";
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



          $tablita .=    "<select name='sup' id='sup' autofocus autocomplete='false' onclick='graficar_todo()'>
          <option value=''></option> ";

          foreach ($result_sups as $row) {


            $tablita .=   "<option value='" . $row['SUPER'] . "'>" . $row['SUPER'] . "</option> ";
          }

          $tablita .=  "</select><br> ";

          echo '<label class="p-1 mb-2 bg-dark text-white"> FILTRAR &nbsp SUPERVISOR : </label>&nbsp';
          echo $tablita;
        } else if ($var_desc2[0] != 'A') {
          echo "<label class='p-1 mb-2 bg-dark text-white'> FILTRAR &nbsp SUPERVISOR : </label>&nbsp
          <select name='sup' id='sup' autofocus autocomplete='false' onclick='graficar_todo()'>
          <option value=''></option>
             <option value='$var_desc'> $var_desc</option></select><br>";
        }
      }



      ?>

      <br>
      <!--Accordion wrapper-->
      <div class="bg-primary">
        I: <input type="date" name="fini" id="fini" autofocus onclick="graficar_todo()">
        F: <input type="date" name="ffin" id="ffin"  autofocus onclick="graficar_todo()"><br>
        <b>SERIE POR :
          <input type="radio" id="WK" name="plotear" value="WK" onclick="graficar_todo()">
          <label for="WK">SEMANA</label>
          <input type="radio" id="MTH" name="plotear" value="MTH" onclick="graficar_todo()">
          <label for="MTH">MES</label>
          <input type="radio" id="DLY" name="plotear" value="DLY" onclick="graficar_todo()">
          <label for="MTH">DIARIO</label>
          <br>GRAFICOS :
          <input type="radio" id="GL" name="plotear2" value="GL" onclick="graficar_todo()">
          <label for="GL">GENERAL</label>
          <input type="radio" id="AREA" name="plotear2" value="AREA" onclick="graficar_todo()">
          <label for="AREA">MI AREA</label>
          <br></b>

        <!-- <button type="button" class="btn btn-success" name="EJECUTAR" id="EJECUTAR" onclick="graficar_todo()">EJECUTAR</button> -->


      </div><br>


      <div class="bg-info text-white">
        <center><b>REPORTES GENERALES </b></center>
        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

          <!-- Accordion card -->
          <div class="card">

            <!-- Card header -->
            <div class="card-header" role="tab" id="headingOne1">
              <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                <h5 class="mb-0">
                  AUSENTISMO<i class="fas fa-angle-down rotate-icon"></i>
                </h5>
              </a>
            </div>

            <!-- Card body -->
            <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
              <div class="card-body">

                <div id="gf1">
                  <canvas id="bar-chart"></canvas>
                </div>

              </div>
            </div>

          </div>
          <!-- Accordion card -->

          <!-- Accordion card -->
          <div class="card">

            <!-- Card header -->
            <div class="card-header" role="tab" id="headingTwo2">
              <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                <h5 class="mb-0">
                  ENTRADAS TARDIAS <i class="fas fa-angle-down rotate-icon"></i>
                </h5>
              </a>
            </div>

            <!-- Card body -->
            <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
              <div class="card-body">
                <div id="gf2">
                  <canvas id="bar-chart2"></canvas>
                </div>
              </div>
            </div>

          </div>
          <!-- Accordion card -->

          <!-- Accordion card -->
          <div class="card">

            <!-- Card header -->
            <div class="card-header" role="tab" id="headingThree3">
              <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                <h5 class="mb-0">
                  INCAPACIDAD <i class="fas fa-angle-down rotate-icon"></i>
                </h5>
              </a>
            </div>

            <!-- Card body -->
            <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3" data-parent="#accordionEx">
              <div class="card-body">
                <div id="gf3">
                  <canvas id="bar-chart3"></canvas>
                </div>



              </div>
            </div>

          </div>
          <!-- Accordion card -->

          <!-- Accordion card -->
          <div class="card">

            <!-- Card header -->
            <div class="card-header" role="tab" id="headingFour4">
              <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseFour4" aria-expanded="false" aria-controls="collapseFour4">
                <h5 class="mb-0">
                  PERMISOS PERSONALES <i class="fas fa-angle-down rotate-icon"></i>
                </h5>
              </a>
            </div>

            <!-- Card body -->
            <div id="collapseFour4" class="collapse" role="tabpanel" aria-labelledby="headingFour4" data-parent="#accordionEx">
              <div class="card-body">
                <div id="gf4">
                  <canvas id="bar-chart4"></canvas>
                </div>


              </div>
            </div>

          </div>

        </div>
      </div>
      </div> </div>





</html>


<script type="text/javascript">
  function graficar_todo() {
    /* AUSENTISMO */
    valor = '';
    valor2 = '';
    sup = '';

    colorg = '';
    titulog = '';

    var ele = document.getElementsByName('plotear');

    for (i = 0; i < ele.length; i++) {
      if (ele[i].checked) {
        valor = ele[i].value;
      }
    }


    var ele2 = document.getElementsByName('plotear2');

    for (j = 0; j < ele2.length; j++) {
      if (ele2[j].checked) {
        valor2 = ele2[j].value;
      }
    }


    if (valor2 == 'GL' && document.getElementById('sup').value != '') {
      document.getElementById('sup').value = '';
    }


    if (valor2 == 'AREA' && document.getElementById('sup').value != '') {
      sup = document.getElementById('sup').value;
      colorg = 'green';
      titulog = 'POR AREA'
    } else if (valor2 == 'AREA' && document.getElementById('sup').value == '') {
      sup = '';
      colorg = 'blue';
      titulog = 'EN GENERAL'
    } else {
      sup = '';
      colorg = 'blue';
      titulog = 'EN GENERAL'
    }




    if (valor == '' || valor2 == '') {


    } else {

      $.ajax({
        type: "POST",
        url: "inter_borraroper.php",
        data: {
          fini: document.getElementById('fini').value,
          ffin: document.getElementById('ffin').value,
          tipo: valor,
          sup: sup,
          estado: 'grafs_ausencias'
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#gf1').html('');
          $('#gf1').html('<canvas id="bar-chart"></canvas>');

          var nameArr = JSON.parse(r);
          // console.log(nameArr[0]);
          // console.log(nameArr[1]);



          var ctx = document.getElementById('bar-chart').getContext('2d');
          var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar', // also try bar or other graph types

            // The data for our dataset
            data: {
              labels: nameArr[0],
              // Information about the dataset
              datasets: [{
                label: "AUSENTISMO",
                backgroundColor: colorg,
                borderColor: 'black',
                data: nameArr[1],
              }]
            },

            // Configuration options
            options: {
              layout: {
                padding: 10,
              },
              legend: {
                position: 'bottom',
                display: false
              },
              title: {
                display: true,
                text: 'AUSENTISMO ' + titulog
              },
              scales: {
                yAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'Cuenta de Ausencias'
                  }
                }],
                xAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: valor
                  }
                }]
              }
            }
          });


        }


      });


      $.ajax({
        type: "POST",
        url: "inter_borraroper.php",
        data: {
          fini: document.getElementById('fini').value,
          ffin: document.getElementById('ffin').value,
          tipo: valor,
          sup: sup,
          estado: 'grafs_tardias'
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#gf2').html('');
          $('#gf2').html('<canvas id="bar-chart2"></canvas>');
          var nameArr = JSON.parse(r);
          // console.log(nameArr[0]);
          // console.log(nameArr[1]);


          var ctx = document.getElementById('bar-chart2').getContext('2d');
          var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar', // also try bar or other graph types

            // The data for our dataset
            data: {
              labels: nameArr[0],
              // Information about the dataset
              datasets: [{
                label: "ENTRADAS TARDE",
                backgroundColor: colorg,
                borderColor: 'black',
                data: nameArr[1],
              }]
            },

            // Configuration options
            options: {
              layout: {
                padding: 10,
              },
              legend: {
                position: 'bottom',
                display: false
              },
              title: {
                display: true,
                text: 'ENTRADAS TARDIAS ' + titulog
              },
              scales: {
                yAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'Cuenta de ENTRADAS TARDE'
                  }
                }],
                xAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: valor
                  }
                }]
              }
            }
          });


        }


      });




      $.ajax({
        type: "POST",
        url: "inter_borraroper.php",
        data: {
          fini: document.getElementById('fini').value,
          ffin: document.getElementById('ffin').value,
          tipo: valor,
          sup: sup,
          estado: 'grafs_incapa'
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#gf3').html('');
          $('#gf3').html('<canvas id="bar-chart3"></canvas>');
          3

          var nameArr = JSON.parse(r);
          // console.log(nameArr[0]);
          // console.log(nameArr[1]);


          var ctx = document.getElementById('bar-chart3').getContext('2d');
          var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar', // also try bar or other graph types

            // The data for our dataset
            data: {
              labels: nameArr[0],
              // Information about the dataset
              datasets: [{
                label: "INCAPACIDADES",
                backgroundColor: colorg,
                borderColor: 'black',
                data: nameArr[1],
              }]
            },

            // Configuration options
            options: {
              layout: {
                padding: 10,
              },
              legend: {
                position: 'bottom',
                display: false
              },
              title: {
                display: true,
                text: 'INCAPACIDADES ' + titulog
              },
              scales: {
                yAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'Cuenta de INCAPACIDADES'
                  }
                }],
                xAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: valor
                  }
                }]
              }
            }
          });


        }


      });

      $.ajax({
        type: "POST",
        url: "inter_borraroper.php",
        data: {
          fini: document.getElementById('fini').value,
          ffin: document.getElementById('ffin').value,
          tipo: valor,
          sup: sup,
          estado: 'grafs_permisos'
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#gf4').html('');
          $('#gf4').html('<canvas id="bar-chart4"></canvas>');
          3

          var nameArr = JSON.parse(r);
          // console.log(nameArr[0]);
          // console.log(nameArr[1]);


          var ctx = document.getElementById('bar-chart4').getContext('2d');
          var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar', // also try bar or other graph types

            // The data for our dataset
            data: {
              labels: nameArr[0],
              // Information about the dataset
              datasets: [{
                label: "PERMISOS",
                backgroundColor: colorg,
                borderColor: 'black',
                data: nameArr[1],
              }]
            },

            // Configuration options
            options: {
              layout: {
                padding: 10,
              },
              legend: {
                position: 'bottom',
                display: false
              },
              title: {
                display: true,
                text: 'PERMISOS PERSONALES ' + titulog
              },
              scales: {
                yAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'Cuenta de PERMISOS'
                  }
                }],
                xAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: valor
                  }
                }]
              }
            }
          });


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