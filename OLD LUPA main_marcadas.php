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

echo '<input type="hidden" id="admin" value="' . $_SESSION['user1'] . '"/>';

echo '<input type="hidden" id="supi" value="' . $_SESSION['user1'] . '"/>';

$result_desc3 = $info->get_my_admin($var_desc);



if ($result_desc3[0] == '') {

    echo '<input type="hidden" id="admini" value="' .  $_SESSION['user1']  . '"/>';
    //   echo 1;
} else {
    echo '<input type="hidden" id="admini" value="' . $result_desc3[0] . '"/>';
}

?>

<!DOCTYPE html>
<html lang="es-Es">
<style type="text/css">
    body {
        background-image: url('img/human-resources-employment.jpg');
        background-image: url('img/bgny.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;

    }


    .wrapper {
        max-height: 700px;
        max-width: 1200px;
        overflow: auto;
    }

    /* .table1 {
    width: 2000px;
    height: 700px;    
    border: 1px solid #000;
    
    
} */


    /* #table-scroll {
    overflow-x:scroll; 
    -ms-overflow-style: none;  
     scrollbar-width: none;  
    -ms-overflow-style: none;  
} */






    table td#ROW1 {
        background-color: red;
        color: white;
    }

    table td#ROW2 {
        background-color: green;
        color: white;
    }

    table td#ROW3 {
        background-color: gray;
        color: white;
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
    <link rel="stylesheet" href="img/load.css">


</head>


<body>

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
                        if ($var_desc2 == 'I' || $var_desc2 == 'R') {
                            header("Location: log_hist.php", true, 301);
                        } else {
                            echo "<nav class='navbar navbar-dark bg-primary'>";
                            echo "<h1 class='text-center h3 mb-3 font-weight-normal'><label class='mb-1 text-white' title='BIENVENIDO AL USUARIO!'> HOLA " . $_SESSION['user1'] . " </label>";
                            echo "&nbsp &nbsp <img src='img/searchi.png' alt='Mi perfil' height='42' width='42' title='Ver mi Perfil'>";
                            echo "&nbsp <a href='mi_perfil.php'> <img src='img/profile.png' alt='Mi perfil' height='42' width='42' title='Personal a Cargo'></a>";
                            echo "&nbsp <a href='reports_marc.php'> <img src='img/chart.png' alt='Reports' height='42' width='42' title='Reports'></a>";
                            echo "&nbsp <a href='log_hist.php'> <img src='img/log.png' alt='Log' height='42' width='42' title='Log'></a>";
                            // //if ($var_desc2 == 'A') {
                            // if ($var_desc2 == 'I') {
                            //     echo "&nbsp <a href='cambio_planta.php'> <img src='img/listm.png' alt='Cambio Planta' height='42' width='42' title='Cambio Planta'></a>";
                            // }
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


                        echo     '<div class="col-xs-2">
                <div class="bg-dark text-white">
        <label class="radio-inline" > CONSULTAR :
          <input type="radio" name="ss" value="E" id="ent" onclick="clear_tablas()">&nbsp ENTRADAS
        </label>
        <label class="radio-inline">
          <input type="radio" name="ss" value="S" id="sal" onclick="clear_tablas()">&nbsp SALIDAS
                  </label>
    </div>';

                        //                 echo     '<div class="col-xs-2">
                        //     <div class="bg-dark text-white">
                        // <label class="radio-inline" > TIPO :
                        // <input type="radio" name="ss" value="CD" id="CD">&nbsp CONTROL DIARIO
                        // </label>
                        // <label class="radio-inline">
                        // <input type="radio" name="ss" value="CC" id="CC">&nbsp CONTROL CONSOLIDADO
                        //       </label>
                        // </div>';


                        if ($var_desc2[0] == 'A') {

                            $info3 = new crud();

                            $result_sups = $info3->get_personal($_SESSION['user1']);

                            $tablita = '';



                            $tablita .=    "<select name='sup' id='sup' autofocus autocomplete='false'>
                    <option value=''></option> ";

                            foreach ($result_sups as $row) {


                                $tablita .=   "<option value='" . $row['SUPER'] . "'>" . $row['SUPER'] . "</option> ";
                            }

                            $tablita .=  "</select><br> ";

                            echo '<label class="p-1 mb-2 bg-dark text-white"> FILTRAR &nbsp SUPERVISOR : </label>&nbsp';
                            echo $tablita;
                        } else if ($var_desc2[0] != 'A') {
                            echo "<label class='p-1 mb-2 bg-dark text-white'> FILTRAR &nbsp SUPERVISOR : </label>&nbsp
                    <select name='sup' id='sup' autofocus autocomplete='false' >
                       <option value='$var_desc'> $var_desc</option></select><br>";
                        }









                        echo '<label class="p-1 mb-2 bg-dark text-white"> FILTRAR &nbsp PUESTO : </label>&nbsp';
                        echo '<input type="text" name="search2" id="inputSearch2" size="30" autofocus placeholder="DIGITE UN PUESTO (OPCIONAL)">';


                        echo '&nbsp &nbsp<label class="p-1 mb-2 bg-dark text-white"> FILTRAR BADGE : </label>&nbsp';
                        echo '<input type="number" name="searchb" id="inputSearchb" size="17" autofocus placeholder="BADGE" maxlength="5" min="50000" max="99999">';
                        //echo '&nbsp &nbsp <input  type="button" name="filtrar" id="filtrar"  value="FILTRAR" onclick="ajax_Tabla()"  />';
                        echo  '&nbsp &nbsp &nbsp <input class="btn-primary" type="button" name="filtrar" id="filtrar" class="btn btn-success" value="FILTRAR" onclick="ajax_Tabla()" />';
                    }
                    ?>




                    <br>
                    <label class="bg-dark text-white"> DIA A CONSULTAR :
                        <input type="date" name="search1" id="inputSearch" max=<?php echo date("Y-m-d"); ?> placeholder="AAAA-MM-DD" autofocus>
                        <input class=" btn-primary" type="button" name="login" id="login" value="CONSULTAR" onclick="ajax_Tabla()" />

                        <button type="button" class="btn btn-success" id="exp_excel_marc" onclick="export_excel_marc()"><img src='img/excel.png' height='20' width='20'> &nbsp EXCEL</button>


                    </label>



            </div>




            <div id="table-scroll">
                <div name="showresults3" id="showresults3">
                </div>
            </div>


            <br>

            <div id="table-scroll">
                <div name="showresults4" id="showresults4">
                </div>
            </div>
            <br><br>



            <br>

            <div id="table-scroll">
                <div name="showresults2" id="showresults2">
                </div>
            </div>

            <br>

            <div id="table-scroll">
                <div name="showresults" id="showresults">
                </div>
            </div>


            <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div id="divmodal">
                        <div class="modal-content bg-primary">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">NOTAS DE LA OPERADORA ACTUAL : </h5>
                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                                <input type="hidden" id="ajuste">
                            </div>
                            <div class="modal-body">
                                <form style="background: lightgray;">
                                    <div name="hextras" id="hextras">
                                    </div>
                                    <div>
                                        <label for="fechacons" class="col-form-label">Fecha Consultada:</label>
                                        <input type="date" class="form-control" id="fechacons" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="Operadora1" class="col-form-label">Badge:</label>
                                        <input type="text" class="form-control" id="Operadora1" readonly>

                                        <label for="Nombre" class="col-form-label">Nombre:</label>
                                        <input type="text" class="form-control" id="Nombre" readonly>

                                        <label for="area" class="col-form-label">Area:</label>
                                        <input type="text" class="form-control" id="area" readonly>
                                        <label for="turno" class="col-form-label">Turno:</label>
                                        <input type="text" class="form-control" id="turno" readonly>

                                        <label for="observacion" class="col-form-label">Observacion:</label>
                                        <div id="selecciones">
                                            <!-- <select class="form-control" name="observacion" id="observacion" onchange="fechas_des()" required>
                                            <option value=""></option>
                                            <option value="HORAS EXTRAS" class="bg-success" ><b>HORAS EXTRAS</b></option>  
                                            <option value="AUSENCIA INJUSTIFICADA">AUSENCIA INJUSTIFICADA</option>
                                            <option value="CAMBIO DE TURNO">CAMBIO DE TURNO</option>
                                            <option value="CAMBIO DE TURNO CUBRIO BADGE…">CAMBIO DE TURNO CUBRIO BADGE…</option>
                                            <option value="CITA ISSS">CITA ISSS</option>
                                            <option value="CITA MEDICA PRIVADA">CITA MEDICA PRIVADA</option>
                                            <option value="CUARENTENA COVID">CUARENTENA COVID</option>
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
                                        </select> -->
                                        </div>




                                    </div>
                                    <div class="form-group">
                                        <div id="areaextras">
                                            <!-- <label for="fechacons1" size="">F.Inicial:</label>
                                        <input type="date" id="fechacons1" onchange="calcular_diff()">
                                        <label for="fechacons2">F.Final:</label>
                                        <input type="date" id="fechacons2" onchange="calcular_diff()">

                                        <label for="ndias">No.de Dias:</label>
                                        <input type="number" id="ndias" min="0" max="60" width="5px" size="17">
                                        <label for="nhoras">No.de Horas:</label>
                                        <input type="number" id="nhoras" min="0" max="60" width="5px" size="17">
                                        <label for="nmins">No.de Min:</label>
                                        <input type="number" id="nmins" min="0" max="60" width="5px" size="17">
                                        </br> </br>
                                        <div name="campo_horas" id="campo_horas">
                                        </div>
                                        <input type="radio" name="cb-s" id="ps" value="PAGAR SEPTIMO"> PAGAR SÉPTIMO &nbsp&nbsp
                                        <input type="radio" name="cb-s" id="nps" value="NO PAGAR SEPTIMO"> NO PAGAR SÉPTIMO &nbsp&nbsp
                                        <div name="subirf" id="subirf"> -->
                                            <div>

                                            </div>

                                        </div>
                                        <div class="form-group">

                                            <label for="message-text" class="col-form-label">Notas:</label>
                                            <textarea class="form-control" id="message-text"></textarea>



                                            <div name="tabla_notas" id="tabla_notas">
                                            </div>


                                            <!-- <br>
                                    <table border="1" class="table-primary">
                                        <td><span onclick="removeday()" title="Nota 1" id="1">N1</span></td>
                           
                                    </table> -->


                                        </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarmodal">Cerrar</button>
                                <div id="svd2"><button type="button" class="btn btn-info" onclick="save_details()" id="svd">Agregar</button></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- OTRO MODAL -->

            <div class="modal fade bd-example-modal-xl" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content bg-primary">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">CONSULTA DETALLADA : </h5>
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                        </div>

                        <div class="modal-body">
                            <label for="badge1">BADGE:</label> &nbsp;
                            <input type="TEXT" class="badge1" id="badge1" onKeyDown="if(event.keyCode==13) document.getElementById('act_cuadro').click();">

                            <form>


                                <label for="fechacons">INICIO:</label> &nbsp;
                                <input type="date" id="fechaini1">
                                <label for="fechacons">FINAL:</label>
                                <input type="date" id="fechafin1" max=<?php echo date("Y-m-d"); ?>>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" id="exp_excel_cuadro" onclick="export_excel_cuadro()"><img src='img/excel.png' height='20' width='20'> &nbsp &nbsp EXCEL</button>
                                    <button type="button" class="btn btn-info" onclick="filltabla()" id="act_cuadro">Actualizar Cuadro</button>
                                    <button type="button" class="btn btn-warning" onclick="filltabla2()" id="act_cronos">Reporte CRONOS</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarmodal2">Cerrar</button>
                                </div>
                                <div class='wrapper'>
                                    <div name="tabla_notas2" id="tabla_notas2">



                                    </div>

                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>



            </form>
        </div>
    </div>
    </div>
</body>



<script type="text/javascript">
    // los ASISTENTES
    var excel_marcadas;
    var excel_marcadasno;

    function ajax_Tabla() {
        var estado_rad
        var rol = document.getElementById('rol').value;
        sup = document.getElementById('sup').value
        admin = document.getElementById('admini').value

        var len = document.getElementById("sup").length

        if (document.getElementById('ent').checked == false && document.getElementById('sal').checked == false) {
            swal.fire({
                title: "Error!",
                text: "DEBE SELECCIONAR ENTRADA O SALIDA",
                showConfirmButton: false,
                icon: "error",
                timer: 5000
            })
            document.getElementById('ent').focus
        } else {


            if (document.getElementById('ent').checked == true) {
                var estado_rad = "E";
            } else {
                var estado_rad = "S";
            }

            if (sup != '' && rol == 'S' || rol == 'M' || rol == 'C') {

                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {
                        //sup: document.getElementById('var_desc').value,
                        sup: document.getElementById('sup').value, //nuevo combo
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarc',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {
                        try {
                            var d = JSON.parse(r);
                            excel_marcadas = d[1];
                            $('#showresults').html(d[0]);
                        } catch {
                            $("#showresults").html("<center><div><label class='bg-info'><img src='img/warn.png' height='15' width='15'><br>MARCADAS: NO SE ENCONTRARON RESULTADOS<br><img src='img/warn.png' height='15' width='15'></label></div></center>");

                        }

                    },
                    error: function(r) {
                        $("#showresults").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }


                });

                // los QUE FALTARON
                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {

                        //sup: document.getElementById('var_desc').value,
                        sup: document.getElementById('sup').value, //nuevo combo
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarc2',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults2").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS: CARGANDO NO MARCADAS <div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults2").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS: CARGANDO NO MARCADAS <div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {
                        try {
                            var d = JSON.parse(r);

                            excel_marcadasno = d[1];
                            $('#showresults2').html(d[0]);
                        } catch {
                            $("#showresults2").html("<center><div><label class='bg-info'><img src='img/warn.png' height='15' width='15'><br>NO MARCADAS: NO SE ENCONTRARON RESULTADOS<br><img src='img/warn.png' height='15' width='15'></label></div></center>");

                        }
                    },
                    error: function(r) {
                        $("#showresults2").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }

                });
            } else if (sup == '' && rol == 'A') {

                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {
                        sup: document.getElementById('admin').value,
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarcsups_all',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults4").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS SUPS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults4").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS SUPS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {

                        $('#showresults4').html(r);
                    },
                    error: function(r) {
                        $("#showresults4").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }

                });

                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {
                        sup: document.getElementById('admin').value,
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarcsups_no_all',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults3").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS SUPS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults3").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS SUPS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {

                        $('#showresults3').html(r);
                    },
                    error: function(r) {
                        $("#showresults3").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }

                });

                var allsups;

                for (i = 1; i <= len; i++) {
                    document.getElementById("sup").selectedIndex = i;
                    if (i != len) {
                        allsups = allsups + "'" + document.getElementById('sup').value + "',";
                    } else if (i == len) {
                        allsups = allsups + document.getElementById('sup').value;
                    }


                }

                var all;
                all = allsups.replace("undefined", "");
                all = all.substr(0, all.length - 1)



                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {
                        //sup: document.getElementById('var_desc').value,
                        sup: all, //nuevo combo
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarc_all',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {

                        $('#showresults').html(r);
                    },
                    error: function(r) {
                        $("#showresults").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }

                });

                // los QUE FALTARON
                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {

                        //sup: document.getElementById('var_desc').value,
                        sup: all, //nuevo combo
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarc2_all',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults2").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS: CARGANDO NO MARCADAS <div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults2").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS: CARGANDO NO MARCADAS <div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {

                        $('#showresults2').html(r);


                    },
                    error: function(r) {
                        $("#showresults2").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }

                });

            } else if (sup != '' && rol == 'A') {
                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {
                        sup: document.getElementById('admin').value,
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarcsups_all',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults4").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS SUPS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults4").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS SUPS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {

                        $('#showresults4').html(r);
                    },
                    error: function(r) {
                        $("#showresults4").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }

                });

                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {
                        sup: document.getElementById('admin').value,
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarcsups_no_all',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults3").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS SUPS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults3").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS SUPS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {

                        $('#showresults3').html(r);
                    },
                    error: function(r) {
                        $("#showresults3").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }

                });

                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {
                        //sup: document.getElementById('var_desc').value,
                        sup: document.getElementById('sup').value, //nuevo combo
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarc',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS: CARGANDO MARCADAS<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {

                        try {
                            var d = JSON.parse(r);
                            excel_marcadas = d[1];
                            $('#showresults').html(d[0]);
                        } catch {
                            $("#showresults").html("<center><div><label class='bg-info'><img src='img/warn.png' height='15' width='15'><br>MARCADAS: NO SE ENCONTRARON RESULTADOS<br><img src='img/warn.png' height='15' width='15'></label></div></center>");

                        }
                    },
                    error: function(r) {
                        $("#showresults").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }

                });

                // los QUE FALTARON
                $.ajax({
                    type: "POST",
                    url: "inter_borraroper.php",
                    datatype: "html",
                    data: {

                        //sup: document.getElementById('var_desc').value,
                        sup: document.getElementById('sup').value, //nuevo combo
                        fecha: document.getElementById('inputSearch').value,
                        area: document.getElementById('inputSearch2').value,
                        badge: document.getElementById('inputSearchb').value,
                        radio: estado_rad,
                        estado: 'BuscarMarc2',
                        admin: admin
                    },
                    beforeSend: function() {
                        if (estado_rad == 'E') {
                            $("#showresults2").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>ENTRADAS: CARGANDO NO MARCADAS <div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        } else if (estado_rad == 'S') {
                            $("#showresults2").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>SALIDAS: CARGANDO NO MARCADAS <div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                        }
                    },
                    success: function(r) {
                        try {
                            var d = JSON.parse(r);

                            excel_marcadasno = d[1];
                            $('#showresults2').html(d[0]);
                        } catch {
                            $("#showresults2").html("<center><div><label class='bg-info'><img src='img/warn.png' height='15' width='15'><br>NO MARCADAS: NO SE ENCONTRARON RESULTADOS<br><img src='img/warn.png' height='15' width='15'></label></div></center>");

                        }

                    },
                    error: function(r) {
                        $("#showresults2").html("<center>NO HAY DATOS PARA LA CONSULTA</center>");

                    }

                });



            }



        }


    }


    function abrircerrar() {
        var datet = new Date(document.getElementById('inputSearch').value);



        if ((datet instanceof Date && !isNaN(datet.valueOf())) != false) {
            $('#exampleModal').modal('show')





        }






    }

    $('#exampleModal').on('show.bs.modal', function(event) {
        // $('#hextras').html('');
        // $('#campo_horas').html('');


        // document.getElementById('ps').checked = false;
        // document.getElementById('nps').checked = false;

        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        var recipient51 = button.data('ajuste')
        document.getElementById('ajuste').value = recipient51


        // modal.find('.modal-body input').val(recipient)
        $('input[id="Operadora1"]').val(recipient)
        var modal = $(this)

        if (recipient51 == 'SI') {


            $('#selecciones').html('');
            $('#areaextras').html('');
            $('#areaextras').html('<label for="fechacons1" size="">F.Inicial:</label><input type="date" id="fechacons1" onchange="calcular_diff()"><label for="fechacons2">F.Final:</label><input type="date" id="fechacons2" onchange="calcular_diff()"><label for="ndias">No.de Dias:</label><input type="number" id="ndias" min="0" max="60" width="5px" size="17"><label for="nhoras">No.de Horas:</label><input type="number" id="nhoras" min="0" max="60" width="5px" size="17"><label for="nmins">No.de Min:</label><input type="number" id="nmins" min="0" max="60" width="5px" size="17"></br> </br><div name="campo_horas" id="campo_horas"></div><input type="radio" name="cb-s" id="ps" value="PAGAR SEPTIMO"> PAGAR SÉPTIMO &nbsp&nbsp<input type="radio" name="cb-s" id="nps" value="NO PAGAR SEPTIMO"> NO PAGAR SÉPTIMO &nbsp&nbsp<div name="subirf" id="subirf">');
            $('#selecciones').html('<select class="form-control" name="observacion" id="observacion" onchange="fechas_des()" required><option value=""></option><option value="AUSENCIA INJUSTIFICADA">AUSENCIA INJUSTIFICADA</option><option value="CAMBIO DE TURNO">CAMBIO DE TURNO</option><option value="CAMBIO DE TURNO CUBRIO BADGE…">CAMBIO DE TURNO CUBRIO BADGE…</option><option value="CITA ISSS">CITA ISSS</option><option value="CITA MEDICA PRIVADA">CITA MEDICA PRIVADA</option><option value="CUARENTENA COVID">CUARENTENA COVID</option><option value="ENTRADA TARDIA">ENTRADA TARDIA</option><option value="ENTRENAMIENTO">ENTRENAMIENTO</option><option value="EXAMENES ISSS">EXAMENES ISSS</option><option value="INCAPACIDAD ISSS">INCAPACIDAD ISSS</option><option value="INCAPACIDAD MEDICO PRIVADO">INCAPACIDAD MEDICO PRIVADO</option><option value="JORNADA CONTINUA DE TRABAJO">JORNADA CONTINUA DE TRABAJO</option><option value="LE HIZO EL TURNO">LE HIZO EL TURNO</option><option value="NO MARCO ENTRADA/SALIDA">NO MARCO ENTRADA/SALIDA</option><option value="PATERNIDAD">PATERNIDAD</option><option value="PERMISO PERSONAL">PERMISO PERSONAL</option><option value="REGRESO DE INCAPACIDAD">REGRESO DE INCAPACIDAD</option><option value="REPUSO EN FECHA…">REPUSO EN FECHA…</option><option value="RENUNCIA">RENUNCIA</option><option value="SUSPENSION">SUSPENSION</option></select>');

            $('#hextras').html('');
            $('#campo_horas').html('');


            document.getElementById('ps').checked = false;
            document.getElementById('nps').checked = false;

  
            modal.find('.modal-title').text('AJUSTE PARA : ' + recipient)
            modal.find('.modal-title').removeClass('bg-success')
            modal.find('.modal-title').addClass('bg-info')


            $('#subirf').html('<form method="post" action="#" enctype="multipart/form-data"><div class="card" ><div class="card-body"><div class="form-group"><label for="image">Adjunte solamnente Planilla :</label> </br><input type="file" name="image" id="image"></div></div></div></form>');

            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                dataType: "text",
                data: {
                    // supervisor: document.getElementById('var_desc').value,
                    oper: recipient,
                    estado: 'obtenerexento'
                },
                beforeSend: function() {

                },
                success: function(r) {

                    var nameArr = JSON.parse(r);

                    if (nameArr[0] == 'E') {
                        // dijeron que exentos aun no aqui se modifico temporalmente. se quito obligar adjuntos
                        swal.fire({
                            title: "Error",
                            text: "NO SE GUARDARAN LAS NOTAS , LA PERSONA NO MARCA!",
                            showConfirmButton: true,
                            icon: "error"
                        })

                        $('#svd2').html('');
                    } else {
                        $('#svd2').html('<button type="button" class="btn btn-info" onclick="save_details()" id="svd">Agregar</button>');


                    }

                }

            });

        } else if (recipient51 == 'NO') {


            $('#selecciones').html('');
            $('#areaextras').html('');
            $('#areaextras').html('<label for="fechacons1" size="">F.Inicial:</label><input type="date" id="fechacons1" onchange="calcular_diff()"><label for="fechacons2">F.Final:</label><input type="date" id="fechacons2" onchange="calcular_diff()"><label for="ndias">No.de Dias:</label><input type="number" id="ndias" min="0" max="60" width="5px" size="17"><label for="nhoras">No.de Horas:</label><input type="number" id="nhoras" min="0" max="60" width="5px" size="17"><label for="nmins">No.de Min:</label><input type="number" id="nmins" min="0" max="60" width="5px" size="17"></br> </br><div name="campo_horas" id="campo_horas"></div><input type="radio" name="cb-s" id="ps" value="PAGAR SEPTIMO"> PAGAR SÉPTIMO &nbsp&nbsp<input type="radio" name="cb-s" id="nps" value="NO PAGAR SEPTIMO"> NO PAGAR SÉPTIMO &nbsp&nbsp<div name="subirf" id="subirf">');
            $('#selecciones').html('<select class="form-control" name="observacion" id="observacion" onchange="fechas_des()" required><option value=""></option><option value="AUSENCIA INJUSTIFICADA">AUSENCIA INJUSTIFICADA</option><option value="CAMBIO DE TURNO">CAMBIO DE TURNO</option><option value="CAMBIO DE TURNO CUBRIO BADGE…">CAMBIO DE TURNO CUBRIO BADGE…</option><option value="CITA ISSS">CITA ISSS</option><option value="CITA MEDICA PRIVADA">CITA MEDICA PRIVADA</option><option value="CUARENTENA COVID">CUARENTENA COVID</option><option value="ENTRADA TARDIA">ENTRADA TARDIA</option><option value="ENTRENAMIENTO">ENTRENAMIENTO</option><option value="EXAMENES ISSS">EXAMENES ISSS</option><option value="INCAPACIDAD ISSS">INCAPACIDAD ISSS</option><option value="INCAPACIDAD MEDICO PRIVADO">INCAPACIDAD MEDICO PRIVADO</option><option value="JORNADA CONTINUA DE TRABAJO">JORNADA CONTINUA DE TRABAJO</option><option value="LE HIZO EL TURNO">LE HIZO EL TURNO</option><option value="NO MARCO ENTRADA/SALIDA">NO MARCO ENTRADA/SALIDA</option><option value="PATERNIDAD">PATERNIDAD</option><option value="PERMISO PERSONAL">PERMISO PERSONAL</option><option value="REGRESO DE INCAPACIDAD">REGRESO DE INCAPACIDAD</option><option value="REPUSO EN FECHA…">REPUSO EN FECHA…</option><option value="RENUNCIA">RENUNCIA</option><option value="SUSPENSION">SUSPENSION</option></select>');

            $('#hextras').html('');
            $('#campo_horas').html('');


            document.getElementById('ps').checked = false;
            document.getElementById('nps').checked = false;

      
            modal.find('.modal-title').text('ACCION DE PERSONAL PARA : ' + recipient)
            modal.find('.modal-title').removeClass('bg-info')
            modal.find('.modal-title').addClass('bg-success')

            // comprobar si es exento
            // if () {
            //     $('#subirf').html('<form method="post" action="#" enctype="multipart/form-data"><div class="card" style="width: 30rem;"><div class="card-body"><div class="form-group"><label for="image">Adjunte comprobante :</label> </br><input type="file" name="image" id="image"></div></div></div></form>');

            // }
            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                dataType: "text",
                data: {
                    // supervisor: document.getElementById('var_desc').value,
                    oper: recipient,
                    estado: 'obtenerexento'
                },
                beforeSend: function() {

                },
                success: function(r) {

                    var nameArr = JSON.parse(r);

                    if (nameArr[0] == 'E') {
                        // dijeron que exentos aun no aqui se modifico temporalmente. se quito obligar adjuntos
                        swal.fire({
                            title: "Error",
                            text: "NO SE GUARDARAN LAS NOTAS , LA PERSONA NO MARCA!",
                            showConfirmButton: true,
                            icon: "error"
                        })
                        $('#subirf').html('<form method="post" action="#" enctype="multipart/form-data"><div class="card" ><div class="card-body"><div class="form-group"><label for="image">Adjunte un Comprobante :</label> </br><input type="file" name="image" id="image"></div></div></div></form>');
                        $('#svd2').html('');
                    } else {
                        $('#subirf').html('');
                        $('#svd2').html('<button type="button" class="btn btn-info" onclick="save_details()" id="svd">Agregar</button>');


                    }

                }

            });



        } else if (recipient51 == 'OVT') {
            $('#selecciones').html('');
            $('#selecciones').html('<select class="form-control" name="observacion" id="observacion" onchange="fechas_des()" required><option value="HORAS EXTRAS" class="bg-success" selected ><b>HORAS EXTRAS</b></option></select>');


            $('#areaextras').html('<label for="fechacons1" size="">F.Inicial:</label><input type="datetime-local" id="fechacons1" onchange=""><br><label for="fechacons2">F.Final:</label>&nbsp%nbsp<input type="datetime-local" id="fechacons2" onchange="">');


           
            modal.find('.modal-title').text('HORAS EXTRAS PARA : ' + recipient)
            modal.find('.modal-title').removeClass('bg-info')
            modal.find('.modal-title').addClass('bg-success')



            
        }




        var recipient2 = button.data('nombre')
        $('input[id="Nombre"]').val(recipient2)

        var recipient3 = button.data('area')
        $('input[id="area"]').val(recipient3)

        var recipient4 = document.getElementById('inputSearch').value
        $('input[id="fechacons"]').val(recipient4)

        var recipient5 = button.data('turno')
        document.getElementById('turno').value = recipient5

        // call data
        if (recipient51 != 'OVT') {
            $('#areaextras').html('<label for="fechacons1" size="">F.Inicial:</label><input type="date" id="fechacons1" onchange="calcular_diff()"><label for="fechacons2">F.Final:</label><input type="date" id="fechacons2" onchange="calcular_diff()"><label for="ndias">No.de Dias:</label><input type="number" id="ndias" min="0" max="60" width="5px" size="17"><label for="nhoras">No.de Horas:</label><input type="number" id="nhoras" min="0" max="60" width="5px" size="17"><label for="nmins">No.de Min:</label><input type="number" id="nmins" min="0" max="60" width="5px" size="17"></br> </br><div name="campo_horas" id="campo_horas"></div><input type="radio" name="cb-s" id="ps" value="PAGAR SEPTIMO"> PAGAR SÉPTIMO &nbsp&nbsp<input type="radio" name="cb-s" id="nps" value="NO PAGAR SEPTIMO"> NO PAGAR SÉPTIMO &nbsp&nbsp<div name="subirf" id="subirf">');
            document.getElementById('observacion').value = ''


            document.getElementById('message-text').value = ''
            document.getElementById('fechacons1').disabled = true
            document.getElementById('fechacons2').disabled = true
            document.getElementById('fechacons1').value = document.getElementById('inputSearch').value
            document.getElementById('fechacons2').value = document.getElementById('inputSearch').value


            //var d = new Date(); // today!
            //var x = 20; // go back 5 days!
            //d.setDate(d.getDate() - x);

            //console.log(d);
            //document.getElementById("fechacons1").setAttribute("min", document.getElementById('inputSearch').value);


            //     if (document.getElementById('ajuste') == 'SI') {
            //       document.getElementById("fechacons1").min = new Date()-20;
            //  } else {

            //    document.getElementById("fechacons1").min = document.getElementById('inputSearch').value;
            // }

            document.getElementById('ndias').disabled = true
            document.getElementById('ndias').value = ''
            document.getElementById('nhoras').value = ''
            document.getElementById('nmins').value = ''
            document.getElementById('ndias').value = '1'

        }


        $.ajax({
            type: "POST",
            url: "inter_borraroper.php",
            datatype: "html",
            data: {
                sup: document.getElementById('sup').value,
                fecha: document.getElementById('fechacons').value,
                operario: document.getElementById('Operadora1').value,
                estado: 'buscaridnotas'
            },
            beforeSend: function() {

            },
            success: function(r) {

                $('#tabla_notas').html(r);

            }

        });


    })


    var sup;
    var newfilename;
    var todayf;
    var estado_rad;

    function save_details() {


        if (document.getElementById('observacion').value != 'HORAS EXTRAS') {
            horaini = ''
            horafin = ''
        } else {
            horaini = document.getElementById('horaini1').value + ':' + document.getElementById('horaini2').value
            horafin = document.getElementById('horafin1').value + ':' + document.getElementById('horafin2').value
        }

        if (document.getElementById('ent').checked == true) {
            estado_rad = "E";
        } else {
            estado_rad = "S";
        }

        if (document.getElementById('ps').checked == true) {
            pagar = "SI";
        } else {
            pagar = "NO"
        }

        x = document.getElementById('observacion').value;
        y = document.getElementById('message-text').value;
        var today = new Date().toISOString().slice(2, 10);
        var d = new Date().toTimeString().slice(0, 8)

        todayf = today.concat(' ', d);
        // date yyyy-mm-dd hh:mm:ss


        //   if (y == '') {
        //     document.getElementById('message-text').value = 'NA'
        // }

        //console.log(document.getElementById('horaini').value);

        if (x == '') {
            swal.fire({
                title: "Error",
                text: "Seleccione una observacion al menos!",
                showConfirmButton: false,
                icon: "error",
                timer: 5000
            })
        } else if (document.getElementById('observacion').value == 'HORAS EXTRAS' && document.getElementById('horaini1').value == '') {
            swal.fire({
                title: "Error",
                text: "Ingrese una hora inicial!",
                showConfirmButton: false,
                icon: "error",
                timer: 5000
            })
        } else if (document.getElementById('observacion').value == 'HORAS EXTRAS' && document.getElementById('horafin1').value == '') {
            swal.fire({
                title: "Error",
                text: "Ingrese una hora final!",
                showConfirmButton: false,
                icon: "error",
                timer: 5000
            })
        } else if (document.getElementById('observacion').value == 'HORAS EXTRAS' && document.getElementById('nhoras').value == '') {
            swal.fire({
                title: "Error",
                text: "Digite el total de horas!",
                showConfirmButton: false,
                icon: "error",
                timer: 5000
            })

        } else if (document.getElementById('observacion').value == 'HORAS EXTRAS' && document.getElementById('horaini1').value == '' && document.getElementById('horafin1').value == '') {
            swal.fire({
                title: "Error",
                text: "Ingrese una hora inicial y final!",
                showConfirmButton: false,
                icon: "error",
                timer: 5000
            })
        } else {

            if (document.getElementById('rol').value == 'A' || document.getElementById('rol').value == 'M' || document.getElementById('rol').value == 'C') {
                sup = document.getElementById('var_desc').value;
            } else {
                sup = document.getElementById('sup').value;
            }



            if (document.getElementById('ajuste').value == 'SI') {
                var formData = new FormData();
                var files = $('#image')[0].files[0];
                formData.append('file', files);
                $.ajax({
                    url: 'upload.php',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(responser) {
                        // if (response != 0) {
                        //     $(".card-img-top").attr("src", response);
                        // } else {
                        //     alert('Formato de imagen incorrecto.');
                        // }
                        newfilename = responser;
                        // console.log(newfilename);
                        saveall();

                    },
                    error: function(responser2) {
                        swal.fire({
                            title: "Error",
                            text: "No ha anexado un comprobante!",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 5000
                        })
                        newfilename = '';


                    }

                });
                //se movio aca por si no hay un attachmente.




            } else {
                saveall();
            }










        }
    }


    function saveall() {
        $.ajax({
            type: "POST",
            url: "inter_borraroper.php",
            data: {
                //  sup: document.getElementById('var_desc').value,
                // sup: document.getElementById('sup').value,
                sup: sup,
                fecha: todayf,
                fecha_s: document.getElementById('fechacons1').value,
                fecha_s2: document.getElementById('fechacons2').value,
                oper: document.getElementById('Operadora1').value,
                nombre: document.getElementById('Nombre').value,
                area: document.getElementById('area').value,
                observacion: document.getElementById('observacion').value,
                notas: document.getElementById('message-text').value,
                ndias: document.getElementById('ndias').value,
                nhoras: document.getElementById('nhoras').value,
                nmins: document.getElementById('nmins').value,
                horaini: horaini,
                horafin: horafin,
                turno: document.getElementById('turno').value,
                tipo: estado_rad,
                septimo: pagar,
                ajuste: document.getElementById('ajuste').value,
                newfilename: newfilename,
                rol: document.getElementById('rol').value,
                estado: 'SaveDetails'
            },
            beforeSend: function() {},
            success: function(r) {


                swal.fire({
                    title: "Exito!",
                    text: "Se agrego una nota para : " + document.getElementById('Operadora1').value,
                    showConfirmButton: false,
                    icon: "success",
                    timer: 5000
                })

                document.getElementById('observacion').value = '';
                document.getElementById('message-text').value = '';
                document.getElementById('observacion').value = ''
                document.getElementById('fechacons1').disabled = true
                document.getElementById('fechacons2').disabled = true
                document.getElementById('fechacons1').value = ''
                document.getElementById('fechacons2').value = ''
                document.getElementById('ndias').value = ''
                document.getElementById('nhoras').value = ''
                document.getElementById('nmins').value = ''



                document.getElementById('cerrarmodal').click();
            }



        });


    }


    function getdatab(clicked_id) {

        $.ajax({
            type: "POST",
            url: "inter_borraroper.php",
            data: {
                idn: clicked_id,
                estado: 'GetDetails'
            },
            beforeSend: function() {},
            success: function(data) {
                var nameArr = JSON.parse(data);
                document.getElementById('observacion').value = nameArr[0];
                document.getElementById('message-text').value = nameArr[1];
                document.getElementById('fechacons1').value = nameArr[2];
                document.getElementById('fechacons2').value = nameArr[3];
                document.getElementById('ndias').value = nameArr[4];
                document.getElementById('nhoras').value = nameArr[5];
                document.getElementById('nmins').value = nameArr[6];

                document.getElementById('ps').checked == false;
                document.getElementById('nps').checked == false;

                if (nameArr[7] == "SI") {
                    document.getElementById('ps').checked = true;
                    document.getElementById('nps').checked = false;
                } else if (nameArr[7] == "NO") {
                    document.getElementById('ps').checked = false;
                    document.getElementById('nps').checked = true;
                }
            }
        });
    }


    function fechas_des() {

        combohoraini = '<select name="horaini1" id="horaini1" onchange="change_hora()"><option value=""></option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>';
        combomin = '<select name="horaini2" id="horaini2" onchange="change_hora()"><option value="00">00</option><option value="15">15</option><option value="30">30</option></select>';

        combohoraini2 = '<select name="horafin1" id="horafin1" onchange="change_hora()"><option value=""></option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>';
        combomin2 = '<select name="horafin2" id="horafin2" onchange="change_hora()"><option value="00">00</option><option value="15">15</option><option value="30">30</option></select>';



        document.getElementById('ndias').value = ''
        document.getElementById('nhoras').value = ''
        document.getElementById('nmins').value = ''
        document.getElementById('ps').checked = false;
        document.getElementById('nps').checked = false;
        document.getElementById('fechacons1').value = document.getElementById('fechacons').value;
        document.getElementById('fechacons2').value = document.getElementById('fechacons').value;
        // document.getElementById('fechacons1').value = today
        //         document.getElementById('fechacons2').value = today

        if (document.getElementById('observacion').value == 'HORAS EXTRAS') {

            $('#hextras').html('<center><b><h1 class="bg-success">INGRESO HORAS EXTRAS </h1></b></center>');
            // $('#campo_horas').html('<label for="horaini">Hora Inicial:</label>&nbsp<input type="time" id="horaini">&nbsp<label for="horafin">Hora Final :</label>&nbsp<input type="time"  id="horafin"  onblur="change_hora()">');
            $('#campo_horas').html('<label for="horaini">Hora Inicial:</label>&nbsp' + combohoraini + ' : ' + combomin + '&nbsp<label for="horafin">Hora Final :</label>&nbsp' + combohoraini2 + ' : ' + combomin2 + '');
            $('#nhoras').disabled = true;
            document.getElementById('nhoras').disabled = true
            document.getElementById('nmins').disabled = true


        } else {
            $('#hextras').html('');
            // $('#nhoras').disabled = false;
            $('#campo_horas').html('');
            document.getElementById('nhoras').disabled = false
            document.getElementById('nmins').disabled = false
        }

        var ob;
        ob = document.getElementById('observacion').value;

        if (ob != '') {

            // if (document.getElementById('ajuste').value != 'SI') {
            if ((/INCAPACIDAD/i.test(ob)) != true && (/ENTRENAMIENTO/i.test(ob)) != true && (/PATERNIDAD/i.test(ob)) != true && (/SUSPENSION/i.test(ob)) != true && (/PERMISO PERSONAL/i.test(ob)) != true && (/CUARENTENA/i.test(ob)) != true) {
                // document.getElementById('fechacons1').value = ''
                //document.getElementById('fechacons2').value = ''
                document.getElementById('fechacons1').disabled = true
                document.getElementById('fechacons2').disabled = true
                document.getElementById('ndias').disabled = true
                document.getElementById('ndias').value = '1'

            } else {
                document.getElementById('fechacons1').disabled = false
                document.getElementById('fechacons2').disabled = false
                document.getElementById('ndias').value = '1'
                document.getElementById('ndias').disabled = true

            }
            // } else {
            //     document.getElementById('fechacons1').disabled = false
            //     document.getElementById('fechacons2').disabled = false
            //     change_hora()
            // }

        }
    }
    //validaciones del modal
    function change_hora() {

        start = document.getElementById("horaini1").value + ':' + document.getElementById("horaini2").value; //to update time value in each input bar
        end = document.getElementById("horafin1").value + ':' + document.getElementById("horafin2").value; //to update time value in each input bar



        start = start.split(":");
        end = end.split(":");
        var startDate = new Date(0, 0, 0, start[0], start[1], 0);
        var endDate = new Date(0, 0, 0, end[0], end[1], 0);
        var diff = endDate.getTime() - startDate.getTime();
        var hours = Math.floor(diff / 1000 / 60 / 60);
        diff -= hours * 1000 * 60 * 60;
        var minutes = Math.floor(diff / 1000 / 60);

        // return (hours < 9 ? "0" : "") + hours + ":" + (minutes < 9 ? "0" : "") + minutes;


        document.getElementById('nhoras').value = hours;
        document.getElementById('nmins').value = minutes;
    }




    $("#ndias").keyup(function() {
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if ($(this).val() > max) {
            $(this).val(max);
        } else if ($(this).val() < min) {
            $(this).val(min);
        }
    });

    $("#nhoras").keyup(function() {
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if ($(this).val() > max) {
            $(this).val(max);
        } else if ($(this).val() < min) {
            $(this).val(min);
        }
    });

    $("#nmins").keyup(function() {
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if ($(this).val() > max) {
            $(this).val(max);
        } else if ($(this).val() < min) {
            $(this).val(min);
        }
    });


    function calcular_diff() {
        var fini = new Date(document.getElementById('fechacons1').value)
        var ffin = new Date(document.getElementById('fechacons2').value)

        if (fini != null || ffin != null) {
            // To calculate the time difference of two dates 
            var Difference_In_Time = ffin.getTime() - fini.getTime();

            // To calculate the no. of days between two dates 
            var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

            if (Difference_In_Days < 0) {
                document.getElementById('ndias').value = '0'
            } else {
                document.getElementById('ndias').value = Difference_In_Days + 1
            }
        }
    }




    $('#exampleModal2').on('show.bs.modal', function(event) {


        // badge clicked
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('ids') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        // modal.find('.modal-body input').val(recipient)
        $('input[id="badge1"]').val(recipient)

        // fecha ini -6
        var date2 = new Date();
        date2.setDate(date2.getDate() - 7);

        var day2 = ("0" + date2.getDate()).slice(-2);
        var month2 = ("0" + (date2.getMonth() + 1)).slice(-2);

        var today2 = date2.getFullYear() + "-" + (month2) + "-" + (day2);

        $('#fechaini1').val(today2);

        // fecha de ahora
        var now = new Date();

        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        $('#fechafin1').val(today);





        var sup = document.getElementById('sup').value;
        var badge = document.getElementById('badge1').value;
        var fini = document.getElementById('fechaini1').value;
        var ffin = document.getElementById('fechafin1').value;


        $.ajax({
            type: "POST",
            url: "inter_borraroper.php",
            datatype: "html",
            data: {
                sup: sup,
                badge: badge,
                fini: fini,
                ffin: ffin,
                estado: 'llenar_detalle',
                tdays: '7'
            },
            beforeSend: function() {

            },
            success: function(r) {

                $('#tabla_notas2').html(r);


            }

        });




    })

    function parseDate(input) {
        // Transform date from text to date
        var parts = input.match(/(\d+)/g);
        // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
        return new Date(parts[0], parts[1] - 1, parts[2]); // months are 0-based
    }
    ///click de boton dentro del modal
    function filltabla()

    {

        var date1 = parseDate($("#fechaini1").val());
        var date2 = parseDate($("#fechafin1").val());
        var diff = date2 - date1;
        var date_difference = parseInt(diff / (24 * 3600 * 1000));

        if (date_difference >= 0 && date_difference <= 15) {
            var sup = document.getElementById('sup').value;
            var badge = document.getElementById('badge1').value;
            var fini = document.getElementById('fechaini1').value;
            var ffin = document.getElementById('fechafin1').value;

            // console.log(sup);
            // console.log(badge);
            // console.log(fini);
            // console.log(ffin);

            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                datatype: "html",
                data: {
                    sup: sup,
                    badge: badge,
                    fini: fini,
                    ffin: ffin,
                    estado: 'llenar_detalle',
                    tdays: date_difference
                },
                beforeSend: function() {
                    $('#tabla_notas2').html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'> CARGANDO MARCADAS..ESPERE <div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                },
                success: function(r) {

                    $('#tabla_notas2').html(r);


                }

            });
        } else {
            swal.fire({
                title: "Error!",
                text: "RANGO DE TIEMPO DEBE SER DE 1 - 15 DIAS",
                showConfirmButton: false,
                icon: "error",
                timer: 5000
            })

        }

    }

    function filltabla2()

    {

        var date1 = parseDate($("#fechaini1").val());
        var date2 = parseDate($("#fechafin1").val());
        var diff = date2 - date1;
        var date_difference = parseInt(diff / (24 * 3600 * 1000));

        if (date_difference >= 0 && date_difference <= 15) {

            var allsups;
            var len = document.getElementById("sup").length


            if (len > 1) {
                for (i = 1; i <= len; i++) {
                    document.getElementById("sup").selectedIndex = i;
                    if (i != len) {
                        allsups = allsups + "'" + document.getElementById('sup').value + "',";
                    } else if (i == len) {
                        allsups = allsups + document.getElementById('sup').value;
                    }
                }

                var all;
                all = allsups.replace("undefined", "");
                all = all.substr(0, all.length - 1)

            } else {

                all = "'" + document.getElementById('sup').value + "'";


            }

            console.log(all);

            // var sup = document.getElementById('sup').value;
            var sup = all;
            var badge = document.getElementById('badge1').value;
            var fini = document.getElementById('fechaini1').value;
            var ffin = document.getElementById('fechafin1').value;


            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                datatype: "html",
                data: {
                    sup: sup,
                    badge: badge,
                    fini: fini,
                    ffin: ffin,
                    estado: 'llenar_detalle_cronos',
                    tdays: date_difference
                },
                beforeSend: function() {
                    $('#tabla_notas2').html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'> CARGANDO MARCADAS..ESPERE <div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                },
                success: function(r) {
                    $('#tabla_notas2').html(r);


                }

            });
        } else {
            swal.fire({
                title: "Error!",
                text: "RANGO DE TIEMPO DEBE SER DE 1 - 15 DIAS",
                showConfirmButton: false,
                icon: "error",
                timer: 5000
            })

        }

    }



    function ejecutar_busqueda(badge, fecha) {


        var str = String(fecha);
        // console.log(typeof(str));
        var res = str.substring(1, 11);

        $('#inputSearch').val(res);

        document.getElementById('inputSearchb').value = badge;

        $('#login').click();


        // document.getElementById(badge).click();

    }


    function clear_tablas() {
        // para evitar errores de que no hallan dado click en los radio de ES
        $('#showresults').html('')
        $('#showresults2').html('')



    }

    function export_excel_cuadro() {


        var sup = document.getElementById('sup').value;
        var badge = document.getElementById('badge1').value;
        var fini = document.getElementById('fechaini1').value;
        var ffin = document.getElementById('fechafin1').value;


        $.ajax({
            type: "POST",
            url: "export_excel_sum.php",
            datatype: "text",
            data: {
                sup: sup,
                badge: badge,
                fini: fini,
                ffin: ffin,
                estado: 'llenar_detalle',
                tdays: '7'
            },
            beforeSend: function() {

            },
            success: function(r) {




            }

        });

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



    function export_excel_marc() {
        //  console.log(excel_marcadas);
        //     console.log(excel_marcadasno);


        if (excel_marcadas == '' || excel_marcadas == null || excel_marcadasno == '' || excel_marcadasno == null) {
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
                url: "excel_marc.php",
                data: {
                    marcsi: JSON.stringify(excel_marcadas),
                    marcno: JSON.stringify(excel_marcadasno)
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
                    $a.attr("download", "marcadas_export_" + rnd + ".xls");
                    $a[0].click();
                    $a.remove();


                    swal.fire({
                        title: "Exito!",
                        text: "Datos Exportados con Exito",
                        showConfirmButton: true,
                        icon: "success"
                    })
                    excel_marcadas = null;
                    excel_marcadasno = null;

                }

            })
        }

    }

    function sortTable(n, j) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById('table2');
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

                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarmodal1">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="pass_change()">Cambiar Password</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>




</html>