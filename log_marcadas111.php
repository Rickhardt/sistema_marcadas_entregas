<!DOCTYPE html>
<html lang="es-Es">

<?php
session_start();
session_destroy();
?>

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


<body>

    <div class="container">

        <form id="FormLog" class="form-signin block-centered" method="POST">

            <h1 class="text-center h3 mb-3 font-weight-normal">

                <label class="p-3 mb-2 bg-dark text-white"> INGRESO A SISTEMA DE MARCADAS </label><br>

            </h1>
            <div class="col-xs-2">
                <input type="text" name="user1" id="inputUsuario" class="form-control " placeholder="Usuario" autofocus>
            </div>
            <div class="col-xs-2">
                <input type="password" name="pass1" id="inputPassword" class="form-control " placeholder="Password">
            </div>

            <input class="btn btn-sm btn-primary btn-block" type="button" name="login" id="login" class="btn btn-success form-control-file" value="OK" />
            </br></br></br></br></br></br></br></br></br></br></br></br>

            <div class="text-center">
                <img src="img/avxlogo.jpg" class="rounded" width="400px" height="200px" title='AVX INDUSTRIES Ltd.'>
            </div>
            <div><b class="text-white"> Ver 3.2.0 </b></div>

        </form>


    </div>

</body>



<script type="text/javascript">
    $(document).keydown(function(e) {

        // Set self as the current item in focus
        var self = $(':focus'),
            // Set the form by the current item in focus
            form = self.parents('form:eq(0)'),
            focusable;

        // Array of Indexable/Tab-able items
        focusable = form.find('input,a,select,button,textarea,div[contenteditable=true]').filter(':visible');

        function enterKey() {
            if (e.which === 13 && !self.is('textarea,div[contenteditable=true]')) { // [Enter] key

                // If not a regular hyperlink/button/textarea
                if ($.inArray(self, focusable) && (!self.is('a,button'))) {
                    // Then prevent the default [Enter] key behaviour from submitting the form
                    e.preventDefault();
                } // Otherwise follow the link/button as by design, or put new line in textarea

                // Focus on the next item (either previous or next depending on shift)
                focusable.eq(focusable.index(self) + (e.shiftKey ? -1 : 1)).focus();

                return false;
            }
        }
        // We need to capture the [Shift] key and check the [Enter] key either way.
        if (e.shiftKey) {
            enterKey()
        } else {
            enterKey()
        }
    });


    $(document).ready(function() {
        $('#login').click(function() {


            var x = document.forms["FormLog"]["inputUsuario"].value;
            var y = document.forms["FormLog"]["inputPassword"].value;





            if (x == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error...',
                    text: 'Ingrese un usuario valido!'
                }).then(function() {
                    window.location.reload();

                });

            } else if (y == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error...',
                    text: 'Ingrese un Password valido!'
                }).then(function() {
                    window.location.reload();

                });


            } else {
                //AJAX MANDAR LOS DATOS A LA SIGUIENTE PAGINA

                /* Ingresos de datos */
                var datos = $('#FormLog').serialize();
                $.ajax({
                    type: "POST",
                    url: "inter1.php",
                    data: {
                        sup: sup,
                        badge: badge,
                        fini: fini,
                        ffin: ffin,
                        estado: 'llenar_detalle',
                        tdays: '7'
                    },
                    beforeSend: function() {
                        $('#login').attr('disabled', "disabled");
                    },
                    success: function(r) {

                        if (r == 1) {
                            window.location = "main_marcadas.php";
                        } else if (r == 99) {
                            swal.fire({
                                title: "Error!",
                                text: "Usuario o password incorrecto!",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 5000
                            }).then(function() {
                                window.location.reload();
                            });
                        } else {
                            alert("ERROR DESCONOCIDO" + r);
                        }


                    }
                });
                return false;






            }





        });
    });
</script>

</html>