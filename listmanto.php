<!-- <style type="text/css">
    select {
        width: 70px;
        height: 55px;
    }
</style> -->

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

</head>


<body onload='cambiarturno()'>

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
                echo "<nav class='navbar navbar-dark bg-primary'>";
                echo "<h1 class='text-center h3 mb-3 font-weight-normal'><label class='mb-1 text-white' name='descsup' id='descsup'> " . $var_desc . " </label>";
                echo "&nbsp &nbsp <a href='main_marcadas.php'> <img src='img/searchi.png' alt='Mi perfil' height='30' width='30' title='Consulta...'></a>";
                echo "&nbsp <a href='mi_perfil.php'><img src='img/profile.png' alt='Mi perfil' height='30' width='30' title='Personal a Cargo'></a>";
                echo "&nbsp <img src='img/gear.png' alt='Personal a Cargo' height='30' width='30' title='Modificar mi personal'>";
                echo "&nbsp <a href='log_marcadas.php'> <img src='img/logout.png' alt='Logout' height='30' width='30' title='Logout'> </a></h1>";
                echo "</nav>";
            }

            if ($var_desc2[0] == 'A') {

                $info3 = new crud();

                $result_sups = $info3->get_personal($_SESSION['user1']);

                $tablita = '';



                $tablita .=    "<select name='sup' id='sup' autofocus autocomplete='false' onChange='cambiarturno()'>
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
                   <option value='$var_desc'> $var_desc</option></select><br> ";
            }
            ?>



            <div class="col-xs-2">
                <center>
                    <label class="p-3 mb-2 bg-dark text-white"> MANTENIMIENTO DE SUPERVISORES </label>
                </center>



                <div class="container p-3 my-3 bg-primary text-white round text-center">
                    </br>
                    
                    <div name="showresults" id="showresults">
                </div>
                    <p>



                        <?php

                        if ($var_desc2[0] == 'A') {
                            // $info3 = new crud();

                            // $result_perf2 = $info3->fill_oper_sup2($var_desc);

                            // $turnoactual = $result_perf2[0];

                            // echo '<input type="hidden" id="turn1" value="' . $result_perf2[0] . '"/>';
                            // echo '<label class="p-3 mb-2 bg-dark text-white" > CAMBIO DE TURNO <b>' . $result_perf2[0] . '</b> (SUPERVISOR) A  : </label> ';

                            echo '<select name="turnon" id="turnon" style="width:70px; height:55px">
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="4">5</option>
                    </select>  &nbsp &nbsp
                    <input class="btn btn-sm btn-success border border-round" type="button" name="cturno" id="cturno" class="btn btn-outline-success" value="CAMBIAR" style="width:100px; height:55px" />';
                        } else if ($var_desc2[0] != 'A') {

                            echo "<label class='p-1 mb-2 bg-dark text-red'>  NO ESTA AUTORIZADO A UTILIZAR ESTA SECCION. </label>&nbsp";
                        }

                        ?>







                    </p>
                </div>








            </div>




        </form>




    </div>

</body>




<script type="text/javascript">
    /* BOTON DE CAMBIOS */
    $(document).ready(function() {
        $('#cturno').click(function() {


            var x = document.forms["FormLog"]["turnon"].value;


            if (x == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error...',
                    text: 'Seleccione un turno!'
                })


            } else {

                //AJAX MANDAR LOS DATOS A LA SIGUIENTE PAGINA

                /* Ingresos de datos */
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: true
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de cambiar de turno?',
                    text: "Cambiara al turno :" + document.getElementById('turnon').value,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, cambiar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        swalWithBootstrapButtons.fire(
                            'Se cambio a turno :' + document.getElementById('turnon').value,
                            'Exito',
                            'success'
                        ).then(function() {
                            /*AJAX PARA BORRAR */
                            $.ajax({
                                type: "POST",
                                url: "inter_cturno.php",
                                data: {
                                    datos: document.getElementById('turnon').value,
                                    sup: document.getElementById('sup').value
                                    // sup: document.getElementById('descsup').innerText
                                },
                                beforeSend: function() {

                                },
                                success: function(r) {

                                    //  console.log(document.getElementById('formOper').value);
                                    if (r == 1) {

                                        window.location.reload();

                                    } else {
                                        alert("ERROR DESCONOCIDO" + r);
                                    }


                                }

                            });



                        });

                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'El operador no se borro',
                            'error'
                        )
                    }
                })

                return false;






            }





        });






    });


    function cambiarturno() {
     var sup1;
     sup1 = document.getElementById('sup').value;

 
     $.ajax({
            type: "POST",
            url: "inter_borraroper.php",
            dataType: "html",
            data: {
                estado: 'mostrarturno',
                sup: sup1
            },
            beforeSend: function() {

            },
            success: function(r) {
                
                $('#showresults').html(r);



            }

        });






    }


  


</script>



</html>