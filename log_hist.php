<?php

// INSERT INTO supervisores
//     (admin, badge, supervisor, turno, rol, AREA, areaempleado)
// SELECT 
//     'ROMMEL', badge , supervisor, turno, rol, AREA, areaempleado
// FROM 
//     supervisores
// WHERE 
//     admin = 'MORATAYA' /*AND BADGE = '66479'*/  AND TURNO = '2' 

session_start();
require_once "cfg/conexion.php";
require_once "crud/crud.php";
$info = new crud();

$result_desc = $info->get_sup_name($_SESSION['user1']);
$result_desc2 = $info->get_sup_rol($_SESSION['user1']);
$result_desc3 = $info->get_sup_clerk($_SESSION['user1']);

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

if ($result_desc3[0] != '') {
  $var_desc3 = $result_desc3[0];
  //   echo 1;
} else {
  // echo 99;   
}

echo '<input type="hidden" id="var_desc" value="' . $var_desc . '"/>';

echo '<input type="hidden" id="rol" value="' . $var_desc2 . '"/>';


echo '<input type="hidden" id="supi" value="' . $_SESSION['user1'] . '"/>';

echo '<input type="hidden" id="clerk" value="' .  $var_desc3 . '"/>';

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

  .anyClass {
    height: 700px;
    overflow-y: scroll;
  }

  th,
  td {
    font-size: 12px;
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
              echo "&nbsp <a href='reports_marc.php'> <img src='img/chart.png' alt='Reports' height='42' width='42' title='Reports'></a>";
              echo "&nbsp <img src='img/log.png' alt='Log' height='42' width='42' title='Log'>";
              echo "&nbsp <img src='img/key.png' alt='cambiar' height='42' width='42' title='Cambiar Contraseña' onclick='cambio_pass()'> ";
              //if ($var_desc2 == 'A') {
              if ($var_desc2 == 'I') {
                echo "&nbsp <a href='cambio_planta.php'> <img src='img/listm.png' alt='Cambio Planta' height='42' width='42' title='Cambio Planta'></a>";
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

            // $result_perf = $info2->get_perfil($var_desc);


            // $info3 = new crud();

            // $result_perf2 = $info3->fill_oper_sup2($var_desc);

            // $turnoactual = $result_perf2[0];


            // echo 'TURNO : (' . $result_perf2[0] . ') TOTAL  : (' . count($result_perf) . ') PERSONAS </nav> ';

            echo '</nav>';
          }


          if ($var_desc2[0] == 'A' || $var_desc2[0] == 'X') {

            $info3 = new crud();

            $result_sups = $info3->get_personal($_SESSION['user1']);

            $tablita = '';



            $tablita .=    "<select name='sup' id='sup' autofocus autocomplete='false'>
                <option value=''></option> ";

            foreach ($result_sups as $row) {


              $tablita .=   "<option value='" . $row['SUPER'] . "'>" . $row['SUPER'] . "</option> ";
            }

            $tablita .=   "<option value='" . $var_desc  . "'>" . $var_desc  . "</option> ";

            $tablita .=  "</select><br> ";

            echo '<label class="p-1 mb-2 bg-dark text-white"> FILTRAR &nbsp SUPERVISOR : </label>&nbsp';
            echo $tablita;
          } else if ($var_desc2[0] == 'I' || $var_desc2[0] == 'R' || $var_desc2[0] == 'C' || $var_desc2[0] == 'Y' || $var_desc2[0] == 'X') {
            $info3 = new crud();

            $result_sups = $info3->get_personal_all();

            $tablita = '';



            $tablita .=    "<select name='sup' id='sup' autofocus autocomplete='false'>
                <option value=''></option> ";

            foreach ($result_sups as $row) {


              $tablita .=   "<option value='" . $row['SUPER'] . "'>" . $row['SUPER'] . "</option> ";
            }

            $tablita .=   "<option value='" . $var_desc  . "'>" . $var_desc  . "</option> ";

            $tablita .=  "</select><br> ";

            echo '<label class="p-1 mb-2 bg-dark text-white"> FILTRAR &nbsp SUPERVISOR : </label>&nbsp';
            echo $tablita;
          } else if ($var_desc2[0] != 'A') {
            echo "<label class='p-1 mb-2 bg-dark text-white'> FILTRAR &nbsp SUPERVISOR : </label>&nbsp
                <select name='sup' id='sup' autofocus autocomplete='false' >
                   <option value='$var_desc'> $var_desc</option></select><br>";
          }


          ?>



          <div class="col-xs-2">
            <center>
              <label class="p-3 mb-2 bg-dark text-white"> REPORTE DE ACCIONES DE PERSONAL / AJUSTES </label>
            </center>
            <label class="p-1 mb-2 text-white bg-dark">INICIO :</label>
            <input type="date" name="search1" id="inputSearch" autofocus placeholder="AAAA-MM-DD"><br>
            <label class="p-1 mb-2 text-white bg-dark">FIN &nbsp :</label> &nbsp &nbsp
            <input type="date" name="search2" id="inputSearch2" autofocus placeholder="AAAA-MM-DD">
            <label class="p-1 mb-2 text-white bg-dark"> BADGE :</label>
            <input type="text" name="search3" id="inputSearch3" maxlength="5" autofocus size="6px">
            <label class="p-1 mb-2 text-white bg-dark"> OBSERVACION :</label>


            <select name="observacion" id="observacion">
              <option value=""></option>
              <option value="HORAS EXTRAS"><b>HORAS EXTRAS</b></option>
              <option value="AUSENCIA INJUSTIFICADA">AUSENCIA INJUSTIFICADA</option>
              <option value="CAMBIO DE TURNO">CAMBIO DE TURNO</option>
              <option value="CAMBIO DE TURNO CUBRIO BADGE…">CAMBIO DE TURNO CUBRIO BADGE…</option>
              <option value="CITA ISSS">CITA ISSS</option>
              <option value="CITA MEDICA PRIVADA">CITA MEDICA PRIVADA</option>
              <option value="ENTRADA TARDIA">ENTRADA TARDIA</option>
              <option value="ENTRENAMIENTO">ENTRENAMIENTO</option>
              <option value="EXAMENES ISSS">EXAMENES ISSS</option>
              <option value="INCAPACIDAD ISSS">INCAPACIDAD ISSS</option>
              <option value="INCAPACIDAD MEDICO PRIVADO">INCAPACIDAD MEDICO PRIVADO</option>
              <option value="JORNADA CONTINUA DE TRABAJO">JORNADA CONTINUA DE TRABAJO</option>
              <option value="LE HIZO EL TURNO">LE HIZO EL TURNO</option>
              <option value="NO MARCO ENTRADA/SALIDA">NO MARCO ENTRADA/SALIDA</option>
              <option value="PATERNIDAD">PATERNIDAD</option>
              <option value="PERMISO PERSONAL">PERMISO PERSONAL</option>
              <option value="REGRESO DE INCAPACIDAD">REGRESO DE INCAPACIDAD</option>
              <option value="REPUSO EN FECHA…">REPUSO EN FECHA…</option>
              <option value="RENUNCIA">RENUNCIA</option>
              <option value="SUSPENSION">SUSPENSION</option>
            </select>



            </select>
            <label class="p-1 mb-2 text-white bg-dark"> TURNO :</label>
            <select name="turno" id="turno">
              <option value=""></option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="A">A</option>
            </select><br>
            <label class="p-1 mb-2 text-white bg-dark"> ESTADO :</label>
            <?php

            // A=superI M=RYM S=SUPS I= RRHH R=CONTA C=GRRHH X=GERENTE Y=CONTRALOR
            if ($var_desc2[0] == 'R') {

              echo '<select name="estado" id="estado">';
              echo '<option value="PROCESADO">PROCESADO</option>';
              echo '<option value="PAGADO">PAGADO</option>';
              echo '</select>';

              echo '<label class="p-1 mb-2 text-white bg-dark"> TIPO :</label>';
              echo '<select name="tipo_per" id="tipo_per">';
              echo '<option value="M">MARCA</option>';
              echo '</select>';
            } else if ($var_desc2[0] == 'C') {
              echo '<select name="estado" id="estado">';
              echo '<option value="REVISADO">REVISADO</option>';
              echo '<option value="PAGADO">PAGADO</option>';
              echo '</select>';

              echo '<label class="p-1 mb-2 text-white bg-dark"> TIPO :</label>';
              echo '<select name="tipo_per" id="tipo_per">';
              echo '<option value="E">EXENTO</option>';
              echo '</select>';
            } else if ($var_desc2[0] == 'I') {
              echo '<select name="estado" id="estado">';
              echo '<option value="REVISADO">REVISADO</option>';
              echo '<option value="PROCESADO">PROCESADO</option>';
              echo '</select>';

              echo '<label class="p-1 mb-2 text-white bg-dark"> TIPO :</label>';
              echo '<select name="tipo_per" id="tipo_per">';
              echo '<option value="M">MARCA</option>';
              // echo '<option value="E">EXENTO</option>';
              echo '</select>';
            } else if ($var_desc2[0] == 'Y') {
              echo '<select name="estado" id="estado">';
              echo '<option value="REVISADO">REVISADO</option>';
              echo '<option value="PROCESADO">PROCESADO</option>';
              echo '</select>';

              echo '<label class="p-1 mb-2 text-white bg-dark"> TIPO :</label>';
              echo '<select name="tipo_per" id="tipo_per">';
              echo '<option value="M">MARCA</option>';
              // echo '<option value="E">EXENTO</option>';
              echo '</select>';
            } else if ($var_desc2[0] == 'X') {
              echo '<select name="estado" id="estado">';
              echo '<option value="REVISION">REVISION</option>';
              echo '<option value="REVISADO">REVISADO</option>';
              echo '</select>';

              echo '<label class="p-1 mb-2 text-white bg-dark"> TIPO :</label>';
              echo '<select name="tipo_per" id="tipo_per">';
              echo '<option value="M">MARCA</option>';
              // echo '<option value="E">EXENTO</option>';
              echo '</select>';
            } else {

              echo '<select name="estado" id="estado">';
              // echo '<option value=""></option>';
              echo '<option value="CREADO">CREADO</option>';
              echo '<option value="REVISION">REVISION</option>';
              echo '<option value="REVISADO">REVISADO</option>';
              echo '<option value="PROCESADO">PROCESADO</option>';
              echo '<option value="PAGADO">PAGADO</option>';
              echo '<option value="CANCELADO">CANCELADO</option>';
              echo '</select>';

              echo '<label class="p-1 mb-2 text-white bg-dark"> TIPO :</label>';
              echo '<select name="tipo_per" id="tipo_per">';
              echo '<option value="M">MARCA</option>';
              // echo '<option value="E">EXENTO</option>';
              echo '</select>';
            }

            ?>




            <label class="p-1 mb-2 text-white bg-dark"> AJUSTE :</label>
            <select name="ajuste" id="ajuste">
              <option value=""></option>
              <option value="OV">OV</option>
              <option value="NO">NO</option>
              <option value="SI">SI</option>
            </select>

            <?php
            if ($var_desc2[0] == 'I' || $var_desc2[0] == 'R' || $var_desc2[0] == 'C'  || $var_desc2[0] == 'Y' || $var_desc2[0] == 'X') {
              $tablita2 = '';

              $tablita2 .= '</br><label class="p-1 mb-2 text-white bg-dark"> AREA :</label>
          <select name="area" id="area" autofocus autocomplete="false" multiple size = 4> 
            <option value=""></option>';


              $info4 = new crud();

              $result_areas = $info4->get_areas_linea();


              foreach ($result_areas as $row) {
                $tablita2 .=   "<option value='" . $row['nomarea'] . "'>" . $row['nomarea'] . "</option> ";
              }

              $tablita2 .= '</select>';

              echo $tablita2;
            } else if ($var_desc2[0] == 'A') {
              $tablita2 = '';

              $tablita2 .= '</br><label class="p-1 mb-2 text-white bg-dark"> AREA :</label>
          <select name="area" id="area" autofocus autocomplete="false" multiple size = 4> 
            <option value=""></option>';


              $info4 = new crud();

              $result_areas = $info4->get_areas_lineai($_SESSION['user1']);


              foreach ($result_areas as $row) {
                $tablita2 .=   "<option value='" . $row['nomarea'] . "'>" . $row['nomarea'] . "</option> ";
              }

              $tablita2 .= '</select>';

              echo $tablita2;
            }

            ?>

          </div>

          <input type='checkbox' name='ordenx' id="ordern1" value='1' onclick="onlyOne(this)" /> <label class="p-1 mb-2 text-white bg-dark"> ORDENADO POR FECHA_REG</label>
          <input type='checkbox' name='ordenx' id="ordern2" value='2' onclick="onlyOne(this)" /> <label class="p-1 mb-2 text-white bg-dark"> ORDENADO POR FECHA_INICIO</label>
          <input class="btn btn-sm btn-primary btn-block" type="button" class="btn btn-success form-control-file" id="mostrar" value="MOSTRAR" onclick="ajax_Tabla()" /></br>

          <button type="button" class="btn btn-success" id="exp_excel_marc" onclick="export_excel_marc()"><img src='img/excel.png' height='20' width='20'> &nbsp EXCEL</button>




      </div>

      </form>
    </div>
  </div>
  </div>
  <?php

  // CASO SUPER ESPECIAL
  if ($var_desc3 == 'XX') {
  } else {
    if ($var_desc2[0] == 'I') {
      echo '<br><button type="button" class="btn btn-info" onclick="revisar()"><img src="img/add.png" height="20" width="20"> PROCESAR</button>';
    } else if ($var_desc2[0] == 'R') {
      echo '<br><button type="button" class="btn btn-info" onclick="revisar()"><img src="img/add.png" height="20" width="20"> PAGADO</button>';
    } else if ($var_desc2[0] == 'A') {
      echo '<br><button type="button" class="btn btn-success" onclick="revisar()"><img src="img/add.png" height="20" width="20"> REVISAR</button>';
      echo '<button type="button" class="btn btn-danger" onclick="cancelar()"><img src="img/add.png" height="20" width="20"> CANCELAR</button>';
    } else if ($var_desc2[0] == 'C') {
      echo '<br><button type="button" class="btn btn-info" onclick="revisar()"><img src="img/add.png" height="20" width="20"> PAGADO</button>';
    } else if ($var_desc2[0] == 'Y') {
      echo '<br><button type="button" class="btn btn-info" onclick="revisar()"><img src="img/add.png" height="20" width="20">PROCESAR EXTRAS </button>';
    } else if ($var_desc2[0] == 'X') {
      echo '<br><button type="button" class="btn btn-info" onclick="revisar()"><img src="img/add.png" height="20" width="20">REVISAR EXTRAS </button>';
    } else {
      echo '<br><button type="button" class="btn btn-danger" onclick="cancelar()"><img src="img/add.png" height="20" width="20"> CANCELAR</button>';
    }
  }

  ?>

  <label class="p-1 mb-2 text-white bg-dark" id="res"> RESULTADOS : 0</label>

  <div class="card" style="background: rgba(0,0,0,0.3);">
    <div class="card-body">
      <div class="nav nav-pills nav-stacked anyClass">
        <div name="showresults" id="showresults">
        </div>
      </div>
    </div>
  </div>
</body>

<script type="text/javascript">
  var sup;
  var fecha;
  var fechaf;
  var badge;
  var obs;
  var rol;
  var cajas;
  var areas_concat;
  var all;
  var ajuste;
  //datos excel
  var excel_marcadas;
  var allsups;
  var all2;
  var orden;

  function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('ordenx')
    checkboxes.forEach((item) => {
      if (item !== checkbox) item.checked = false
    })




  }

  function ajax_Tabla() {
    if (document.getElementById('ordern1').checked == true) {
      orden = '1'
    } else if (document.getElementById('ordern2').checked == true) {
      orden = '2'
    } else {
      orden = '1'
    }
    
   
    sup = document.getElementById('sup').value;
    fecha = document.getElementById('inputSearch').value;
    fechaf = document.getElementById('inputSearch2').value;
    badge = document.getElementById('inputSearch3').value;
    obs = document.getElementById('observacion').value;
    rol = document.getElementById('rol').value;
    estado2 = document.getElementById('estado').value;
    turno = document.getElementById('turno').value;
    ajuste = document.getElementById('ajuste').value;
    tipo_per = document.getElementById('tipo_per').value;



    if (document.getElementById('sup').value == '') {

      var len = document.getElementById("sup").length


      for (i = 1; i <= len; i++) {
        document.getElementById("sup").selectedIndex = i;
        if (i != len) {
          allsups = allsups + "'" + document.getElementById('sup').value + "',";
        } else if (i == len) {
          allsups = allsups + document.getElementById('sup').value;
        }


      }


      all2 = allsups.replace("undefined", "");
      all2 = all2.substr(0, all2.length - 1)

    } else {

      all2 = "'" + document.getElementById('sup').value + "'";


    }

    if (rol == 'S' || rol == 'M') {
      area = '';
    } else {
      // area = document.getElementById('area').value;

      if (typeof(document.getElementById('area')) != 'undefined' && document.getElementById('area') != null) {
        var select = document.getElementById('area');
        var selected = [...select.selectedOptions]
          .map(option => option.value);
        var areas1 = [];
        areas1 = selected;
        areas_concat = '';

        if (areas1.length != 0) {
          var arrayLength = areas1.length;
          for (var i = 0; i < arrayLength; i++) {
            if (i != arrayLength) {
              areas_concat = areas_concat + "'" + areas1[i] + "',";
            } else if (i == arrayLength) {
              areas_concat = areas_concat + areas1[i];
            }

          }
          all = '';
          all = areas_concat.replace("undefined", "");
          all = all.substr(0, all.length - 1)




          if (all.length == 2) {
            area = ''
          } else {
            area = all;

          }

        } else {
          area = '';

        }







      }

    }



    // console.log('sup:' + sup);
    // console.log('fecha:' + fecha);
    // console.log('fechaf:' + fechaf);
    // console.log('obs:' + obs);
    // console.log('badge:' + badge);
    // console.log('rol:' + rol);
    // console.log('estado2:' + estado2);
    // console.log('turno:' + turno);
    // console.log('area:' + area);
    // console.log('ajuste:' + ajuste);
    // console.log('tipo_per:' + tipo_per);

    buscar();

  }


  function buscar() {
    // console.log(ajuste);
    // console.log(sup);

    // console.log(all2);
    // console.log(fecha);
    // console.log(fechaf);
    // console.log(badge);
    // console.log(obs);
    // console.log(rol);
    // console.log(turno);
    // console.log(estado2);
    // console.log(area);
    // console.log(ajuste);
    // console.log(tipo_per);

    $.ajax({
      type: "POST",
      url: "inter_borraroper.php",
      dataType: "html",
      data: {
        // supervisor: document.getElementById('var_desc').value,
        //supervisor: sup,
        supervisor: all2,
        fecha: fecha,
        fechaf: fechaf,
        badge: badge,
        obs: obs,
        rol: rol,
        turno: turno,
        estado2: estado2,
        area: area,
        ajuste: ajuste,
        tipo_per: tipo_per,
        estado: 'BuscarNotas',
        orden: orden
      },
      beforeSend: function() {

      },
      success: function(r) {
        //  $('#showresults').html(r);
        var d = JSON.parse(r);
        excel_marcadas = d[1];
        // console.log(excel_marcadas);
        $('#showresults').html(d[0]);
        var rowCount = $("#table tr").length;
        if (rowCount > 0) {
          rowCount = rowCount - 1;
        }

        document.getElementById('res').innerHTML = "RESULTADOS : " + rowCount;

      }

    });

  }


  function getcheckboxes() {
    var node_list = document.getElementsByTagName('input');

    var checkboxes = [];
    for (var i = 0; i < node_list.length; i++) {
      var node = node_list[i];
      if (node.getAttribute('type') == 'checkbox') {
        checkboxes.push(node);
      }
    }
    return checkboxes;
  }

  function toggle(source) {
    checkboxes = getcheckboxes();
    for (var i = 0, n = checkboxes.length; i < n; i++) {
      checkboxes[i].checked = source.checked;
    }



  }


  function revisar() {
    var estado;
    checkboxes = document.getElementsByName('registros');
    selectedCboxes = Array.prototype.slice.call(checkboxes).filter(ch => ch.checked == true);
    rol = document.getElementById('rol').value;
    sup = document.getElementById('var_desc').value;

    // A=superI M=RYM S=SUPS I= RRHH R=CONTA C=GRRHH
    fechat = '';
    var date = new Date();
    fechat = date.toISOString().split('T')[0] + ' ' + date.toTimeString().split(' ')[0];
    var bandera_estado;


    if (rol == 'A') {
      estado = 'actualizarestado';
      bandera_estado = 'REVISADO/REVISION POR';
    } else if (rol == 'M') {
      estado = 'actualizarestado2';
      bandera_estado = 'REVISION POR';
    } else if (rol == 'I') {
      estado = 'procesarestado';
      bandera_estado = 'PROCESADO POR';
    } else if (rol == 'R' || rol == 'C') {
      estado = 'pagadoestado';
      bandera_estado = 'PAGADO POR';
    } else if (rol == 'Y') {
      estado = 'procesadoextras';
      bandera_estado = 'PROCESADO EXTRAS';
    } else if (rol == 'X') {
      estado = 'revisadoextras';
      bandera_estado = 'REVISADO EXTRAS';
    }

    // PARA LO QUE NO SEA HORA EXTRAS POR QUE EL WORK FLOW ES DIFERENTE


    var idclerk = '';
    var clerknow = '';
    var mess1 = 0;
    var obsernow = '';

    cajas = '';
    cajas2 = '';
    cajas3 = '';
    cajas4 = '';


    for (var i = 0, n = selectedCboxes.length; i < n; i++) {

      idclerk = document.getElementById(selectedCboxes[i].value);
      clerknow = idclerk.getAttribute('data-nombre');
      obsernow = idclerk.getAttribute('data-obs');
      //console.log(clerknow);
      if (document.getElementById('var_desc').value == clerknow && document.getElementById('clerk').value == 'NO') {
        //alerta por la bandera NO de clerk que no puede autorizarse a si misma
        //al final
        //console.log('se salto');
        mess1 = 1;
      } else {
        //los insert values
        // console.log(obsernow);
        if (obsernow != 'HORAS EXTRAS') {
          cajas2 = cajas2 + "('" + bandera_estado + "','" + sup + "','" + fechat + "','" + selectedCboxes[i].value + "'),"
          cajas = cajas + "'" + selectedCboxes[i].value + "',"
        } else {
          cajas4 = cajas4 + "('" + bandera_estado + "','" + sup + "','" + fechat + "','" + selectedCboxes[i].value + "'),"
          cajas3 = cajas3 + "'" + selectedCboxes[i].value + "',"
        }

      }
    }

    // se separan extras en diferentes in cajas
    // cajas normales
    cajas = cajas.replace(/.$/, "")
    cajas2 = cajas2.replace(/.$/, "")

    // cajas horas extras
    cajas3 = cajas3.replace(/.$/, "")
    cajas4 = cajas4.replace(/.$/, "")

    // console.log(cajas);
    // console.log(cajas2);
    // console.log('-----------------');
    // console.log(cajas3);
    // console.log(cajas4);


    if (cajas == '' && cajas3 == '') {

      if (mess1 == 1) {
        swal.fire({
          title: "Exito!",
          text: "No ha seleccionado nada. NOTA: SE DETECTO 1 AUTO REVISION NO PERMITIDO",
          showConfirmButton: true,
          icon: "success"
        })
      } else {
        swal.fire({
          title: "Error",
          html: "No ha seleccionado nada ",
          showConfirmButton: true,
          icon: "error"
        })
      }
    } else {
      $.ajax({
        type: "POST",
        url: "inter_borraroper.php",
        dataType: "text",
        data: {
          rol: rol,
          sup: sup,
          estado: estado,
          boxes: cajas,
          boxes2: cajas2,
          boxes3: cajas3,
          boxes4: cajas4
        },
        beforeSend: function() {

        },
        success: function(r) {

          if (mess1 == 1) {
            swal.fire({
              title: "Exito!",
              text: "Datos Actualizados con exito. NOTA: SE DETECTO 1 AUTO REVISION NO PERMITIDO",
              showConfirmButton: true,
              icon: "success"
            })
          } else {
            swal.fire({
              title: "Exito!",
              text: "Datos Actualizados con exito",
              showConfirmButton: true,
              icon: "success"
            })
          }

          //buscar();
          $("#mostrar").click()

        }

      });





    }

  }


  function cancelar() {
    var estado;
    checkboxes = document.getElementsByName('registros');
    selectedCboxes = Array.prototype.slice.call(checkboxes).filter(ch => ch.checked == true);
    rol = document.getElementById('rol').value;
    sup = document.getElementById('var_desc').value;

    // A=superI M=RYM S=SUPS I= RRHH R=CONTA C=GRRHH
    fechat = '';
    var date = new Date();
    fechat = date.toISOString().split('T')[0] + ' ' + date.toTimeString().split(' ')[0];
    var bandera_estado;



    estado = 'cancelaraccion';
    bandera_estado = 'CANCELADO';

    var idclerk = '';
    var clerknow = '';
    var mess1 = 0;
    var obsernow = '';

    cajas = '';
    cajas2 = '';
    cajas3 = '';
    cajas4 = '';


    for (var i = 0, n = selectedCboxes.length; i < n; i++) {

      idclerk = document.getElementById(selectedCboxes[i].value);
      clerknow = idclerk.getAttribute('data-nombre');
      obsernow = idclerk.getAttribute('data-obs');
      //console.log(clerknow);
      if (document.getElementById('var_desc').value == clerknow && document.getElementById('clerk').value == 'NO') {
        //alerta por la bandera NO de clerk que no puede autorizarse a si misma
        //al final
        //console.log('se salto');
        mess1 = 1;
      } else {
        //los insert values
        // console.log(obsernow);
        if (obsernow != 'HORAS EXTRAS') {
          cajas2 = cajas2 + "('" + bandera_estado + "','" + sup + "','" + fechat + "','" + selectedCboxes[i].value + "'),"
          cajas = cajas + "'" + selectedCboxes[i].value + "',"
        } else {
          cajas4 = cajas4 + "('" + bandera_estado + "','" + sup + "','" + fechat + "','" + selectedCboxes[i].value + "'),"
          cajas3 = cajas3 + "'" + selectedCboxes[i].value + "',"
        }

      }
    }

    // se separan extras en diferentes in cajas
    // cajas normales
    cajas = cajas.replace(/.$/, "")
    cajas2 = cajas2.replace(/.$/, "")

    // cajas horas extras
    cajas3 = cajas3.replace(/.$/, "")
    cajas4 = cajas4.replace(/.$/, "")

    // console.log(cajas);
    // console.log(cajas2);
    // console.log('-----------------');
    // console.log(cajas3);
    // console.log(cajas4);


    if (cajas == '' && cajas3 == '') {

      if (mess1 == 1) {
        swal.fire({
          title: "Exito!",
          text: "No ha seleccionado nada. NOTA: SE DETECTO 1 AUTO REVISION NO PERMITIDO",
          showConfirmButton: true,
          icon: "success"
        })
      } else {
        swal.fire({
          title: "Error",
          html: "No ha seleccionado nada ",
          showConfirmButton: true,
          icon: "error"
        })
      }
    } else {
      $.ajax({
        type: "POST",
        url: "inter_borraroper.php",
        dataType: "text",
        data: {
          rol: rol,
          sup: sup,
          estado: estado,
          boxes: cajas,
          boxes2: cajas2,
          boxes3: cajas3,
          boxes4: cajas4
        },
        beforeSend: function() {

        },
        success: function(r) {

          if (mess1 == 1) {
            swal.fire({
              title: "Exito!",
              text: "ACCIONES CANCELADAS CON EXITO",
              showConfirmButton: true,
              icon: "success"
            })
          } else {
            swal.fire({
              title: "Exito!",
              text: "ACCIONES CANCELADAS CON EXITO",
              showConfirmButton: true,
              icon: "success"
            })
          }

          //buscar();
          $("#mostrar").click()

        }

      });





    }

  }


  function export_excel_marc() {

    if (excel_marcadas == '' || excel_marcadas == null) {
      swal.fire({
        title: "<img src='img/excel.png' height='30' width='30'>",
        html: "No hay aun datos que exportar...o ya exporto todo ",
        showConfirmButton: true,
        icon: "error"
      })
    } else {

      $.ajax({
        async: true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url: "excel_marc_acciones.php",
        data: {
          marcsi: JSON.stringify(excel_marcadas)
        },
        beforeSend: function() {

        },
        success: function(data) {
          var rnd;
          rnd = Math.floor(Math.random() * 9999) + 1000;
          var opResult = JSON.parse(data);
          var $a = $("<a>");
          $a.attr("href", opResult.data);
          //$a.html("LNK");
          $("body").append($a);
          $a.attr("download", "marcadas_acciones_" + rnd + ".xls");
          $a[0].click();
          $a.remove();


          swal.fire({
            title: "Exito!",
            text: "Datos Exportados con Exito",
            showConfirmButton: true,
            icon: "success"
          })
          // excel_marcadas = null;


        }

      })
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


  function sortTable(n, j) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById('table');
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
      // Start by saying: no switching is done:
      switching = false;
      rows = table.rows;
      /* Loop through all table rows (except the
      first, which contains table headers): */
      for (i = 1; i < (rows.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /* Check if the two rows should switch place,
        based on the direction, asc or desc: */
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        // Each time a switch is done, increase this count by 1:
        switchcount++;
      } else {
        /* If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again. */
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
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


</html>