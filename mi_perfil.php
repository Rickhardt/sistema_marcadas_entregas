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
    <link rel="stylesheet" href="img/load.css">

</head>


<body onload="cargar()">
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
                echo "<nav class='navbar navbar-dark bg-primary'>";
                echo "<h1 class='text-center h3 mb-3 font-weight-normal'><label class='mb-1 text-white' id='descsup' name='descsup'> " . $var_desc . " </label>";
                if ($var_desc2 != 'I' && $var_desc2 != 'Y' && $var_desc2 != 'X') {
                echo "&nbsp &nbsp <a href='main_marcadas.php'> <img src='img/searchi.png' alt='Mi perfil' height='42' width='42' title='Consulta...'></a>";
                }
                echo "&nbsp <img src='img/profile.png' alt='Mi perfil' height='42' width='42' title='Personal a Cargo'>";
                // echo "&nbsp <a href='listmanto.php'> <img src='img/gear.png' alt='Mi perfil' height='30' width='30' title='Modificar mi personal'></a>";
                echo "&nbsp <a href='reports_marc.php'> <img src='img/chart.png' alt='Reports' height='42' width='42' title='Reports'></a>";
                echo "&nbsp <a href='log_hist.php'> <img src='img/log.png' alt='Log' height='42' width='42' title='Log'></a>";
                //if ($var_desc2 == 'A') {
                if ($var_desc2 == 'I') {
                    echo "&nbsp <a href='cambio_planta.php'> <img src='img/listm.png' alt='Cambio Planta' height='42' width='42' title='Cambio Planta'></a>";
                }
                echo "&nbsp <img src='img/key.png' alt='cambiar' height='42' width='42' title='Cambiar Contraseña' onclick='cambio_pass()'> ";
                echo "&nbsp <a href='log_marcadas.php'> <img src='img/logout.png' alt='Logout' height='42' width='42' title='Logout'> </a></h1>";




                // $info2 = new crud();

                // $result_perf = $info2->($var_desc);


                // $info3 = new crud();

                // $result_perf2 = $info3->fill_oper_sup2($var_desc);

                // $turnoactual = $result_perf2[0];


                // echo 'TURNO : (' . $result_perf2[0] . ') TOTAL  : (' . count($result_perf) . ') PERSONAS </nav> ';


                echo '</nav>';
            }
            ?>



            <div class="col-xs-2">



                <?php


                // $info2 = new crud();

                // $result_perf = $info2->($var_desc);

                // // echo print_r($result_perf);



                // echo '<label class="p-3 mb-2 bg-dark text-white"> TURNO : ' . $result_perf[0]['TURNO'] . ' </br> TOTAL  : ' . count($result_perf) . ' </label> &nbsp &nbsp';

                if ($var_desc2[0] == 'A') {

                    $info3 = new crud();

                    $result_sups = $info3->get_personal($_SESSION['user1']);

                    $tablita = '';



                    $tablita .=    "<select name='sup' id='sup' autofocus autocomplete='false' onchange='borrartodo()' >
                    <option value=''></option> ";

                    foreach ($result_sups as $row) {


                        $tablita .=   "<option value='" . $row['SUPER'] . "'>" . $row['SUPER'] . "</option> ";
                    }

                    $tablita .=  "</select>><button type='button' class='btn btn-success' name='mostrar' id='mostrar' onclick='llenar_miperfil()'>Mostrar</button><br> ";

                    echo '<label class="p-1 mb-2 bg-dark text-white"> FILTRAR &nbsp SUPERVISOR : </label>&nbsp';
                    echo $tablita;

                } else if ($var_desc2[0] == 'I' || $var_desc2[0] == 'R' || $var_desc2[0] == 'C' || $var_desc2 == 'Y' || $var_desc2 == 'X') {
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
                    echo "<button type='button' class='btn btn-success' name='mostrar' id='mostrar' onclick='llenar_miperfil()'>Mostrar</button><br>";


                    
                } else if ($var_desc2[0] != 'A') {

                    echo "<label class='p-1 mb-2 bg-dark text-white'> FILTRAR &nbsp SUPERVISOR : </label>&nbsp
                    <select name='sup' id='sup' autofocus autocomplete='false' >
                       <option value='$var_desc'> $var_desc</option></select><button type='button' class='btn btn-success' name='mostrar' id='mostrar' onclick='llenar_miperfil()'>Mostrar</button><br> ";
                }

                ?>
                <!-- <button type="button" class="btn btn-success" id="exp_excel_marc" onclick="export_excel_marc()"><img src='img/excel.png' height='20' width='20'> &nbsp EXCEL</button> -->
                <div name="showresults2" id="showresults2">
                </div>

                <div name="showresults" id="showresults">
                </div>



            </div>



            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">MODIFICAR DATOS DE OPERADORA : </h5>
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                <span aria-hidden="true">&times;</span>
                            </button> -->

                        </div>
                        <div class="modal-body">
                            <form>
                                <input type="hidden" id="rolclick" />
                                <div class="form-group">
                                    <label for="Operadora1" class="col-form-label">Operadora:</label>
                                    </br>
                                    <input type="text" class="col-form-label" width="200" maxlength="5" id="Operadora1" readonly>

                                    <button type="button" class="btn btn-primary" id="buscar" name="buscar">Buscar</button>
                                    <button type="button" class="btn btn-danger" name="borrar" id="borrar">BORRAR</button>
                                </div>
                                <div class="form-group">
                                    <label for="Nombre" class="col-form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="Nombre" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="area" class="col-form-label">Area:</label>
                                    <input type="text" class="form-control" id="area" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="puesto" class="col-form-label">Puesto Principal: (Si no existe solicitar a IT Ext. 481)</label>
                                    <!-- <input type="text" class="form-control" id="puesto"> -->

                                    <?php
                                    $info9 = new crud();

                                    $result_perf991 = $info9->fill_puestos();

                                    echo '<select name="puesto" id="puesto" autofocus autocomplete="false" class="form-control">';
                                    echo '<option value=""></option>';

                                    foreach ($result_perf991 as $row) {
                                        echo '<option value=' . $row['PUESTO'] . '>' . $row['PUESTO'] . '</option>';
                                    }

                                    echo '</select>';

                                    echo '<label for="puesto2" class="col-form-label">Puesto 2:</label>';


                                    echo '<select name="puesto2" id="puesto2" autofocus autocomplete="false" class="form-control">';
                                    echo '<option value=""></option>';

                                    foreach ($result_perf991 as $row) {
                                        echo '<option value=' . $row['PUESTO'] . '>' . $row['PUESTO'] . '</option>';
                                    }

                                    echo '</select>';

                                    echo '<label for="puesto3" class="col-form-label">Puesto 3:</label>';


                                    echo '<select name="puesto3" id="puesto3" autofocus autocomplete="false" class="form-control">';
                                    echo '<option value=""></option>';

                                    foreach ($result_perf991 as $row) {
                                        echo '<option value=' . $row['PUESTO'] . '>' . $row['PUESTO'] . '</option>';
                                    }

                                    echo '</select>';

                                    /***** Campos agregados en 16/04/2021 debido a tikcet 572765 *****/

                                    echo '<label for="puesto4" class="col-form-label">Puesto 4:</label>';


                                    echo '<select name="puesto4" id="puesto4" autofocus autocomplete="false" class="form-control">';
                                    echo '<option value=""></option>';

                                    foreach ($result_perf991 as $row) {
                                        echo '<option value=' . $row['PUESTO'] . '>' . $row['PUESTO'] . '</option>';
                                    }

                                    echo '</select>';

                                    echo '<label for="puesto5" class="col-form-label">Puesto 5:</label>';


                                    echo '<select name="puesto5" id="puesto5" autofocus autocomplete="false" class="form-control">';
                                    echo '<option value=""></option>';

                                    foreach ($result_perf991 as $row) {
                                        echo '<option value=' . $row['PUESTO'] . '>' . $row['PUESTO'] . '</option>';
                                    }

                                    echo '</select>';


                                    ?>




                                    <!-- <input type="text" class="form-control" id="puesto2"> -->
                                    <!-- <label for="puesto3" class="col-form-label">Puesto 3:</label>
                                    <input type="text" class="form-control" id="puesto3"> -->
                                </div>
                                <div class="form-group">
                                    <label for="turn1" class="col-form-label">Turno:</label>
                                    <!-- 
                                    <select name="turn1" id="turn1" autofocus autocomplete="false" class="form-control"  disabled>
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="A">A</option>
                                    </select> -->

                                    <input name="turn1" id="turn1" type="text" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="estado" class="col-form-label">Estado:</label>
                                    <?php
                                    $info8 = new crud();

                                    $result_perf88 = $info8->fill_estados();

                                    echo '<select name="estado" id="estado" autofocus autocomplete="false" class="form-control">';
                                    echo '<option value=""></option>';

                                    foreach ($result_perf88 as $row) {
                                        echo '<option value=' . $row['ESTADO'] . '>' . $row['ESTADO'] . '</option>';
                                    }

                                    echo '</select>';



                                    ?>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href=window.location.href">Cerrar</button> -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('mostrar').click();">Cerrar</button>
                            <button type="button" class="btn btn-success" name="agregar" id="agregar">Nuevo/Modificar</button>
                        </div>
                    </div>
                </div>
            </div>




        </form>

        </div>   </div>


    </div>



</body>




<script type="text/javascript">
    // var excel_personal;

    function borrartodo() {
        document.getElementById('showresults').innerHTML = '';
        document.getElementById('showresults2').innerHTML = '';
    }

    $('#exampleModal').on('hidden.bs.modal', function() {
        // location.reload();
        document.getElementById('mostrar').click();
    })

    $('#exampleModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        // var modal = $(this)
        // modal.find('.modal-title').text('MODIFICAR DATOS DE OPERADORA :')
        // modal.find('.modal-body input').val(recipient)
        $('input[id="Operadora1"]').val(recipient)

        var recipient2 = button.data('nombre')
        $('input[id="Nombre"]').val(recipient2)

        var recipient3 = button.data('area')
        $('input[id="area"]').val(recipient3)

        var recipient4 = button.data('puesto')
        // $('input[id="puesto"]').val(recipient4)

        document.getElementById('puesto').value = recipient4

        var recipient5 = button.data('estado')
        document.getElementById('estado').value = recipient5

        var recipient6 = button.data('turn1')
        document.getElementById('turn1').value = recipient6


        // SOLO PARA SUPS DE SUPERINTENDENT
        var recipient7 = button.data('rolclick')
        document.getElementById('rolclick').value = recipient7

        var recipient8 = button.data('asignado')


        if (recipient7 == 'A') {
            document.getElementById('turn1').value = recipient8
            $("#turn1").prop("disabled", false);

        }

        //llamar los dos puestos que no estan en la tabla

        $.ajax({

            type: "POST",
            url: "inter_borraroper.php",
            data: {
                badge: document.getElementById('Operadora1').value,
                estado: 'LoadPuestos'
            },
            success: function(data) {

                var nameArr1 = JSON.parse(data);
                if (nameArr1 == null) {
                    document.getElementById('puesto2').value = '';
                    document.getElementById('puesto3').value = '';
                    document.getElementById('puesto4').value = '';
                    document.getElementById('puesto5').value = '';
                } else {
                    // console.log('entro');
                    // console.log(nameArr1[0]);
                    document.getElementById('puesto2').value = nameArr1[0];
                    document.getElementById('puesto3').value = nameArr1[1];
                    document.getElementById('puesto4').value = nameArr1[2];
                    document.getElementById('puesto5').value = nameArr1[3];
                }
            }
        });



    })


    /*boton BUSCAR OPERADOR */

    $('#buscar').click(function() {
        var x = document.getElementById('Operadora1').value;
        //document.getElementById('badge').value = ''
        if (x < 50000) {
            Swal.fire({
                icon: 'info',
                title: 'Badge Incorrecto...',
                text: 'Ingrese un badge correcto '
            })
        } else {

            $.ajax({

                type: "POST",
                url: "inter_borraroper.php",
                data: {
                    badge: document.getElementById('Operadora1').value,
                    estado: 'LoadDataOper'
                },
                success: function(data) {
                    var nameArr = JSON.parse(data);
                    if (nameArr == null) {

                        document.getElementById('Nombre').value = '';
                        document.getElementById('puesto').value = '';
                        document.getElementById('puesto2').value = '';
                        document.getElementById('puesto3').value = '';
                        document.getElementById('puesto4').value = '';
                        document.getElementById('puesto5').value = '';
                        document.getElementById('area').value = '';
                        document.getElementById('estado').value = '';
                        document.getElementById('turn1').value = '';


                        ///otro ajax desde listado oficial
                        $.ajax({

                            type: "POST",
                            url: "inter_borraroper.php",
                            data: {
                                badge: document.getElementById('Operadora1').value,
                                estado: 'LoadDataOper2'
                            },
                            success: function(data) {
                                var nameArr = JSON.parse(data);
                                if (nameArr == null) {

                                    document.getElementById('Nombre').value = '';
                                    document.getElementById('puesto').value = '';
                                    document.getElementById('puesto2').value = '';
                                    document.getElementById('puesto3').value = '';
                                    document.getElementById('puesto4').value = '';
                                    document.getElementById('puesto5').value = '';
                                    document.getElementById('area').value = '';
                                    document.getElementById('estado').value = '';
                                    document.getElementById('turn1').value = '';


                                } else {
                                    document.getElementById('Nombre').value = nameArr[0];
                                    document.getElementById('area').value = nameArr[1];
                                    document.getElementById('estado').value = '';
                                    document.getElementById('turn1').value = '';


                                    $("#Operadora1").attr("readonly", "readonly");
                                    $("#Operadora1").addClass("readOnly");







                                }
                            }
                        });


                    } else {
                        document.getElementById('Operadora1').value = nameArr[0];
                        document.getElementById('Nombre').value = nameArr[1];
                        document.getElementById('puesto').value = nameArr[2];
                        document.getElementById('puesto2').value = nameArr[3];
                        document.getElementById('puesto3').value = nameArr[4];
                        document.getElementById('puesto4').value = nameArr[5];
                        document.getElementById('puesto5').value = nameArr[6];
                        document.getElementById('area').value = nameArr[7];
                        document.getElementById('estado').value = nameArr[8];
                        document.getElementById('turn1').value = nameArr[9];
                        // $("#Operadora1").attr("readonly", "readonly");
                        // $("#Operadora1").addClass("readOnly");







                    }

                    //if badge still blank, get from operadorasturno
                    $.ajax({

                        type: "POST",
                        url: "inter_borraroper.php",
                        data: {
                            badge: document.getElementById('Operadora1').value,
                            estado: 'LoadDataOper3'
                        },
                        success: function(data) {

                            var nameArr1 = JSON.parse(data);
                            if (nameArr1 == null) {
                                document.getElementById('turn1').value = '';
                                $("#Operadora1").attr("readonly", "readonly");
                                $("#Operadora1").addClass("readOnly");
                            } else {
                                // console.log('entro');
                                // console.log(nameArr1[0]);
                                document.getElementById('turn1').value = nameArr1[0];
                                $("#Operadora1").attr("readonly", "readonly");
                                $("#Operadora1").addClass("readOnly");
                            }
                        }
                    });




                }




            });





        }

    })

    // agregar o modificar datos

    $('#agregar').click(function() {
        var x = document.getElementById('Operadora1').value;
        var y = document.getElementById('Nombre').value;
        var z = document.getElementById('puesto').value;
        var u = document.getElementById('area').value;
        var s = document.getElementById('estado').value;
        var t = document.getElementById('turn1').value;
        var rol = document.getElementById('rol').value;
        var rolclick = document.getElementById('rolclick').value;




        var today = new Date();
        var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date + ' ' + time;

        let result;
        let suppert;
        /*validar un operador seleccionado */
        if (x == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese badge!'
            })
        } else if (y == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un nombre y apellido!'
            })

        } else if (u == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese una AREA!'
            })

        } else if (z == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un puesto!'
            })

        } else if (t == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un TURNO!'
            })

        } else if (s == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un ESTADO!'
            })





        } else {

            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                data: {
                    badge: document.getElementById('Operadora1').value,
                    estado: 'ExisteOper'
                },
                success: function(data) {
                    var cuentarr = JSON.parse(data);
                    if (cuentarr == null) {
                        result = '0'
                        suppert = '0'
                    } else {
                        result = cuentarr[0];
                        suppert = cuentarr[1];
                    }
                    // console.log(resultado);
                    if (result == 1) {
                        //verificar si es mio primero

                        if (suppert != document.getElementById('sup').value && rol == 'A' || rol == 'M' || rol == 'C') {
                            var yy = '';
                            if (rolclick == 'A' || rol == 'M' || rol == 'C') {
                                yy = document.getElementById('var_desc').value;
                            } else {
                                yy = document.getElementById('sup').value;
                            }

                            // actualizar datos y jalar a mi turno nada mas
                            $.ajax({
                                type: "POST",
                                url: "inter_borraroper.php",
                                data: {
                                    // responsable1: document.getElementById('descsup').innerText,
                                    responsable1: yy,
                                    badge1: document.getElementById('Operadora1').value,
                                    nombre1: document.getElementById('Nombre').value,
                                    puesto1: document.getElementById('puesto').value,
                                    puesto2: document.getElementById('puesto2').value,
                                    puesto3: document.getElementById('puesto3').value,
                                    puesto4: document.getElementById('puesto4').value,
                                    puesto5: document.getElementById('puesto5').value,
                                    area1: document.getElementById('area').value,
                                    estado1: document.getElementById('estado').value,
                                    turno1: document.getElementById('turn1').value,
                                    estado: 'UpdateOper'

                                },
                                beforeSend: function() {
                                    $("#Operadora1").focus;
                                },
                                success: function(datos) {

                                    document.getElementById('Operadora1').value = '';
                                    document.getElementById('Nombre').value = '';
                                    document.getElementById('puesto').value = '';
                                    document.getElementById('puesto2').value = '';
                                    document.getElementById('puesto3').value = '';
                                    document.getElementById('puesto4').value = '';
                                    document.getElementById('puesto5').value = '';
                                    document.getElementById('area').value = '';
                                    document.getElementById('estado').value = '';
                                    document.getElementById('turn1').value = '';

                                    // window.location.reload();
                                    $("#Operadora1").removeAttr("readonly");
                                    // Eliminamos la clase que hace que cambie el color
                                    $("#Operadora1").removeClass("readOnly");


                                }
                            });

                            Swal.fire({
                                title: "Exito!",
                                // text: "Operadora ya existe, del supervisor : " + suppert + " , Datos actualizados con exito!",
                                text: "Datos actualizados con exito!",
                                showConfirmButton: true,
                                icon: "success"

                            })


                            //logear actualizacion
                            $.ajax({
                                type: "POST",
                                url: "inter_borraroper.php",
                                data: {
                                    // responsable1: document.getElementById('descsup').innerText,
                                    accion: 'Estado/Puesto',
                                    super: document.getElementById('var_desc').value,
                                    fechahora: dateTime,
                                    operario: document.getElementById('Operadora1').value,
                                    puesto: document.getElementById('puesto').value,
                                    puesto2: document.getElementById('puesto2').value,
                                    puesto3: document.getElementById('puesto3').value,
                                    estado2: document.getElementById('estado').value,
                                    transfer: '',
                                    estado: 'UpdateBita'

                                },
                                beforeSend: function() {},
                                success: function(datos) {}
                            });

                        } else if (suppert == document.getElementById('sup').value && rol == 'S') {

                            // actualizar datos y jalar a mi turno nada mas
                            $.ajax({
                                type: "POST",
                                url: "inter_borraroper.php",
                                data: {
                                    // responsable1: document.getElementById('descsup').innerText,
                                    responsable1: yy,
                                    badge1: document.getElementById('Operadora1').value,
                                    nombre1: document.getElementById('Nombre').value,
                                    puesto1: document.getElementById('puesto').value,
                                    puesto2: document.getElementById('puesto2').value,
                                    puesto3: document.getElementById('puesto3').value,
                                    puesto4: document.getElementById('puesto4').value,
                                    puesto5: document.getElementById('puesto5').value,
                                    area1: document.getElementById('area').value,
                                    estado1: document.getElementById('estado').value,
                                    turno1: document.getElementById('turn1').value,
                                    estado: 'UpdateOper'

                                },
                                beforeSend: function() {
                                    $("#Operadora1").focus;
                                },
                                success: function(datos) {

                                    document.getElementById('Operadora1').value = '';
                                    document.getElementById('Nombre').value = '';
                                    document.getElementById('puesto').value = '';
                                    document.getElementById('puesto2').value = '';
                                    document.getElementById('puesto3').value = '';
                                    document.getElementById('puesto4').value = '';
                                    document.getElementById('puesto5').value = '';
                                    document.getElementById('area').value = '';
                                    document.getElementById('estado').value = '';
                                    document.getElementById('turn1').value = '';

                                    // window.location.reload();
                                    $("#Operadora1").removeAttr("readonly");
                                    // Eliminamos la clase que hace que cambie el color
                                    $("#Operadora1").removeClass("readOnly");


                                }
                            });

                            Swal.fire({
                                title: "Exito!",
                                text: "Datos actualizados con exito!",
                                showConfirmButton: true,
                                icon: "success"

                            })


                            //logear actualizacion
                            $.ajax({
                                type: "POST",
                                url: "inter_borraroper.php",
                                data: {
                                    // responsable1: document.getElementById('descsup').innerText,
                                    accion: 'Estado/Puesto',
                                    super: document.getElementById('var_desc').value,
                                    fechahora: dateTime,
                                    operario: document.getElementById('Operadora1').value,
                                    puesto: document.getElementById('puesto').value,
                                    puesto2: document.getElementById('puesto2').value,
                                    puesto3: document.getElementById('puesto3').value,
                                    estado2: document.getElementById('estado').value,
                                    transfer: '',
                                    estado: 'UpdateBita'

                                },
                                beforeSend: function() {},
                                success: function(datos) {}
                            });

                        } else if (suppert == document.getElementById('sup').value && rol == 'A' || rol == 'M' || rol == 'C') {
                            var yy = '';
                            if (rolclick == 'A' || rol == 'M' || rol == 'C') {
                                yy = document.getElementById('var_desc').value;
                            } else {
                                yy = document.getElementById('sup').value;
                            }

                            console.log(yy);
                            // actualizar datos y jalar a mi turno nada mas
                            $.ajax({
                                type: "POST",
                                url: "inter_borraroper.php",
                                data: {
                                    // responsable1: document.getElementById('descsup').innerText,
                                    responsable1: yy,
                                    badge1: document.getElementById('Operadora1').value,
                                    nombre1: document.getElementById('Nombre').value,
                                    puesto1: document.getElementById('puesto').value,
                                    puesto2: document.getElementById('puesto2').value,
                                    puesto3: document.getElementById('puesto3').value,
                                    puesto4: document.getElementById('puesto4').value,
                                    puesto5: document.getElementById('puesto5').value,
                                    area1: document.getElementById('area').value,
                                    estado1: document.getElementById('estado').value,
                                    turno1: document.getElementById('turn1').value,
                                    estado: 'UpdateOper'

                                },
                                beforeSend: function() {
                                    $("#Operadora1").focus;
                                },
                                success: function(datos) {

                                    document.getElementById('Operadora1').value = '';
                                    document.getElementById('Nombre').value = '';
                                    document.getElementById('puesto').value = '';
                                    document.getElementById('puesto2').value = '';
                                    document.getElementById('puesto3').value = '';
                                    document.getElementById('puesto4').value = '';
                                    document.getElementById('puesto5').value = '';
                                    document.getElementById('area').value = '';
                                    document.getElementById('estado').value = '';
                                    document.getElementById('turn1').value = '';

                                    // window.location.reload();
                                    $("#Operadora1").removeAttr("readonly");
                                    // Eliminamos la clase que hace que cambie el color
                                    $("#Operadora1").removeClass("readOnly");

                                }
                            });

                            Swal.fire({
                                title: "Exito!",
                                // text: "Operadora ya existe, del supervisor : " + suppert + " , Datos actualizados con exito!",
                                text: "Datos actualizados con exito!",
                                showConfirmButton: true,
                                icon: "success"

                            })


                            //logear actualizacion
                            $.ajax({
                                type: "POST",
                                url: "inter_borraroper.php",
                                data: {
                                    accion: 'Estado/Puesto',
                                    super: document.getElementById('var_desc').value,
                                    fechahora: dateTime,
                                    operario: document.getElementById('Operadora1').value,
                                    puesto: document.getElementById('puesto').value,
                                    puesto2: document.getElementById('puesto2').value,
                                    puesto3: document.getElementById('puesto3').value,
                                    estado2: document.getElementById('estado').value,
                                    transfer: '',
                                    estado: 'UpdateBita'

                                },
                                beforeSend: function() {},

                                success: function(datos) {}


                            });





                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'NO ESTA AUTORIZADO PARA TRANSFERIR OPERADOR(A) DE ' + suppert + ' !'
                            })



                        }

                    } else {
                        //ASI PUEDEN CREAR YA LOS SUPS N GRUPO SUPER
                        if (rol == 'A' || rol == 'S' || rol == 'M' || rol == 'C') {
                            var yy = '';
                            if (rolclick == 'A' || rol == 'M' || rol == 'C') {
                                yy = document.getElementById('var_desc').value;
                            } else {
                                yy = document.getElementById('sup').value;
                            }

                            console.log(yy);

                            $.ajax({
                                type: "POST",
                                url: "inter_borraroper.php",
                                data: {
                                    // responsable1: document.getElementById('descsup').innerText,
                                    responsable1: yy,
                                    // badge1: document.getElementById('Operadora1').value,
                                    // nombre1: document.getElementById('Nombre').value,
                                    // puesto1: document.getElementById('puesto').value,
                                    // puesto2: document.getElementById('puesto2').value,
                                    // puesto3: document.getElementById('puesto3').value,
                                    // area1: document.getElementById('area').value,
                                    // estado1: document.getElementById('estado').value,
                                    // turno1: document.getElementById('turn1').value,

                                    badge1: document.getElementById('Operadora1').value,
                                    nombre1: document.getElementById('Nombre').value,
                                    puesto1: document.getElementById('puesto').value,
                                    puesto2: document.getElementById('puesto2').value,
                                    puesto3: document.getElementById('puesto3').value,
                                    puesto4: document.getElementById('puesto4').value,
                                    puesto5: document.getElementById('puesto5').value,
                                    area1: document.getElementById('area').value,
                                    estado1: document.getElementById('estado').value,
                                    turno1: document.getElementById('turn1').value,
                                    estado: 'InsertOper'

                                },
                                beforeSend: function() {

                                },
                                success: function(datos) {
                                    //log bitacora nuevo
                                    $.ajax({
                                        type: "POST",
                                        url: "inter_borraroper.php",
                                        data: {
                                            // responsable1: document.getElementById('descsup').innerText,
                                            accion: 'Transferencia',
                                            super: document.getElementById('var_desc').value,
                                            fechahora: dateTime,
                                            operario: document.getElementById('Operadora1').value,
                                            puesto: document.getElementById('puesto').value,
                                            puesto2: document.getElementById('puesto2').value,
                                            puesto3: document.getElementById('puesto3').value,
                                            estado2: document.getElementById('estado').value,
                                            transfer: document.getElementById('sup').value,
                                            estado: 'UpdateBita'

                                        },
                                        beforeSend: function() {},
                                        success: function(datos) {}
                                    });

                                    //fin log bitacora
                                    document.getElementById('Operadora1').value = '';
                                    document.getElementById('Nombre').value = '';
                                    document.getElementById('puesto').value = '';
                                    document.getElementById('puesto2').value = '';
                                    document.getElementById('puesto3').value = '';
                                    document.getElementById('puesto4').value = '';
                                    document.getElementById('puesto5').value = '';
                                    document.getElementById('area').value = '';
                                    document.getElementById('estado').value = '';
                                    document.getElementById('turn1').value = '';
                                    // document.getElementById('Operadora1').focus();
                                    $("#Operadora1").removeAttr("readonly");
                                    // Eliminamos la clase que hace que cambie el color
                                    $("#Operadora1").removeClass("readOnly");
                                    // window.location.reload();

                                    Swal.fire({
                                        title: "Exito!",
                                        // text: "Se agrego la nueva operadora " + document.getElementById('Operadora1').value + "",
                                        text: "Se agrego un nuevo estado...",
                                        showConfirmButton: true,
                                        icon: "success"

                                        // agregar todos los datos nuevos junto al sup actual y turno

                                    })

                                    document.getElementById('mostrar').click();
                                    $("#Operadora1").focus();

                                }

                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'NO TIENE PERMISOS PARA AGREGAR UN OPERARIO(A) DENTRO SU PERFIL!'
                            })
                        }




                    }







                }
            });












        }



    });

    /*boton BUSCAR OPERADOR */

    $('#borrar').click(function() {


        document.getElementById('Nombre').value = '';
        document.getElementById('puesto').value = '';
        document.getElementById('puesto2').value = '';
        document.getElementById('puesto3').value = '';
        document.getElementById('puesto4').value = '';
        document.getElementById('puesto5').value = '';
        document.getElementById('area').value = '';
        document.getElementById('estado').value = '';
        document.getElementById('turn1').value = '';
        document.getElementById('Operadora1').value = '';
        $("#Operadora1").removeAttr("readonly");
        // Eliminamos la clase que hace que cambie el color
        $("#Operadora1").removeClass("readOnly");
        $("#Operadora1").focus();

    })


    function llenar_miperfil() {
        var allsups;
        var sup;
        var rol;
        sup = document.getElementById('sup').value;
        rol = document.getElementById('rol').value;
        supi = document.getElementById('supi').value;
        admini = document.getElementById('admini').value;

        var len = document.getElementById("sup").length
       // console.log(sup);
        //  document.getElementById('suph').value = sup;
        document.cookie = "suph=" + sup;
        if (sup != '' && rol == 'S' || rol == 'M' || rol == 'C' ) {
            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                dataType: "html",
                data: {
                    estado: 'mostrardatos',
                    sup: sup,
                    rol: rol,
                    admin: admini,
                    supi: supi
                },
                beforeSend: function() {

                },
                success: function(r) {
                    $('#showresults').html(r);
                    // var d = JSON.parse(r);
                    //     excel_personal = d[1];
                    //     $('#showresults').html(d[0]);


                }

            });

        } else if (sup == '' && rol == 'A' ) {
            ///cuadro mostrar supervisores
            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                dataType: "html",
                data: {
                    estado: 'mostrardatossup',
                    sup: supi,
                    rol: rol
                },
                beforeSend: function() {

                },
                success: function(r) {
                    $('#showresults2').html(r);



                }

            });

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
            console.log(all);
            console.log(rol);
            console.log(admini);
          

            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                dataType: "html",
                data: {
                    estado: 'mostrardatos_all',
                    sup: all,
                    rol: rol,
                    admin: admini
                },
                beforeSend: function() {

                },
                success: function(r) {
                    $('#showresults').html(r);
                    // var d = JSON.parse(r);
                    //     excel_personal = d[1];
                    //     $('#showresults').html(d[0]);


                }

            });

        } else if (sup != '' && rol == 'A' ) {

            ///cuadro mostrar supervisores
            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                dataType: "html",
                data: {
                    estado: 'mostrardatossup',
                    sup: supi,
                    rol: rol
                },
                beforeSend: function() {

                },
                success: function(r) {
                    $('#showresults2').html(r);



                }

            });

            //normal cuadro de mostrar
            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                dataType: "html",
                data: {
                    estado: 'mostrardatos',
                    supi:supi,
                    sup: sup,
                    rol: rol,
                    admin: admini
                },
                beforeSend: function() {

                },
                success: function(r) {
                    $('#showresults').html(r);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);

                }

            });






        } else if (sup != '' && rol == 'I' || rol == 'R' || rol != 'Y' ) {
         //PARA QUE PUEDAN VERLOS TODOS
         $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                dataType: "html",
                data: {
                    estado: 'mostrardatos_rrhh',
                    sup: sup,
                    rol: rol,
                    admin: admini
                },
                beforeSend: function() {
                    $("#showresults").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>CARGANDO DATOS...ESPERE<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                },
                success: function(r) {
                    $('#showresults').html(r);

                }

            });



        
        } else if (sup == '' && rol == 'I' || rol == 'R' ) {

            $.ajax({
                type: "POST",
                url: "inter_borraroper.php",
                dataType: "html",
                data: {
                    estado: 'mostrardatos_rrhh_all',
                    sup: sup,
                    rol: rol,
                    admin: admini
                },
                beforeSend: function() {
                    $("#showresults").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>CARGANDO DATOS...ESPERE<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
                },
                success: function(r) {
                    $('#showresults').html(r);

                }

            });


        }



    }


    function cargar() {
        var correr = document.getElementById("mostrar")
        name = 'suph';
         


        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));

        
        if (match) {
            document.getElementById('sup').value = match[2];
            correr.click();

        } else {
            console.log('--something went wrong---');
        }
    }


    /*pass change*/
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




    //     function export_excel_marc() {
    //     //  console.log(excel_marcadas);
    //     //     console.log(excel_marcadasno);


    //    if (excel_personal == '' || excel_personal == null) {
    //     swal.fire({
    //                 title: "<img src='img/excel.png' height='30' width='30'>",
    //                 html: "No hay aun datos que exportar...o ya exporto todo ",
    //                 showConfirmButton: true,
    //                 icon: "Error"
    //             })
    //    } else {

    //     $.ajax({
    //         async:true,
    //         type:"POST",
    //         dataType:"html",
    //         contentType:"application/x-www-form-urlencoded",
    //         url: "excel_mipersonal.php",
    //         data: {
    //             mipersonal: JSON.stringify(excel_personal)
    //         },
    //         beforeSend: function() {

    //         },
    //         success: function(data) {
    //             var rnd;
    //             rnd = Math.floor(Math.random() * 9999) + 1000;
    //             var opResult = JSON.parse(data);
    //                   var $a=$("<a>");
    //                   $a.attr("href",opResult.data);
    //                   //$a.html("LNK");
    //                   $("body").append($a);
    //                   $a.attr("download","marcadas_mipersonal_" + rnd + ".xls");
    //                   $a[0].click();
    //                   $a.remove();


    //             swal.fire({
    //                 title: "Exito!",
    //                 text: "Datos Exportados con Exito",
    //                 showConfirmButton: true,
    //                 icon: "success"
    //             })
    //             excel_personal = null;


    //         }

    //     })
    //    }

    // }
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